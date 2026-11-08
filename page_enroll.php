<?php
/**
 * ระบบรับสมัครและขึ้นทะเบียนนิสิตใหม่ออนไลน์ (Admissions & Online Enrollment System)
 * หลักสูตรพุทธศาสตรบัณฑิต สาขาวิชาพระพุทธศาสนา มจร วิทยาเขตอุบลราชธานี
 * รองรับมาตรฐาน WCAG 2.1/2.2 AAA
 */

$is_vercel = !empty($_ENV['VERCEL']) || !empty($_SERVER['VERCEL']);
$enroll_dir = $is_vercel ? sys_get_temp_dir() . '/data' : __DIR__ . '/data';
if (!is_dir($enroll_dir)) {
    @mkdir($enroll_dir, 0777, true);
}
$dataFile = $enroll_dir . '/enrollments.json';
if ($is_vercel && !file_exists($dataFile) && file_exists(__DIR__ . '/data/enrollments.json')) {
    @copy(__DIR__ . '/data/enrollments.json', $dataFile);
}

// ฟังก์ชันโหลดข้อมูลผู้สมัคร
function getEnrollments($dataFile) {
    if (!file_exists($dataFile)) {
        return [];
    }
    $content = @file_get_contents($dataFile);
    $data = json_decode($content, true);
    return is_array($data) ? $data : [];
}

// ฟังก์ชันบันทึกข้อมูลผู้สมัคร
function saveEnrollments($dataFile, $data) {
    return @file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

$enrollments = getEnrollments($dataFile);

$msg_success = '';
$msg_error = '';
$preset_level = $_GET['level'] ?? '';
$active_tab = $_GET['tab'] ?? (!empty($preset_level) ? 'apply' : 'overview');
$search_result = null;
$enrolled_student = null;

// จัดการการส่งแบบฟอร์ม POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $action = $_POST['action'] ?? '';

    // 1. ยื่นใบสมัครออนไลน์ (Step 1)
    if ($action === 'submit_app') {
        $citizen_id = trim($_POST['citizen_id'] ?? '');
        $title_name = trim($_POST['title_name'] ?? '');
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name'] ?? '');
        $applicant_type = $_POST['applicant_type'] ?? 'monk';
        $phone      = trim($_POST['phone'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $line_id    = trim($_POST['line_id'] ?? '');
        $education  = trim($_POST['education'] ?? '');
        $curriculum_level = trim($_POST['curriculum_level'] ?? 'หลักสูตรพุทธศาสตรบัณฑิต สาขาวิชาพระพุทธศาสนา (ปริญญาตรี - พธ.บ.)');
        $program    = trim($_POST['program'] ?? 'ภาคปกติ (วันจันทร์ - วันศุกร์)');
        $address    = trim($_POST['address'] ?? '');

        if (empty($citizen_id) || empty($first_name) || empty($phone)) {
            $msg_error = 'กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน (เลขประจำตัวประชาชน, ชื่อ-ฉายา, หมายเลขโทรศัพท์)';
            $active_tab = 'apply';
        } else {
            // ตรวจสอบว่าเคยสมัครหรือยัง
            $existing_index = -1;
            foreach ($enrollments as $idx => $item) {
                if ($item['citizen_id'] === $citizen_id) {
                    $existing_index = $idx;
                    break;
                }
            }

            if ($existing_index >= 0) {
                $msg_error = "เลขประจำตัวประชาชนนี้เคยยื่นใบสมัครแล้ว (รหัสใบสมัคร: " . htmlspecialchars($enrollments[$existing_index]['app_id']) . ") ท่านสามารถตรวจสอบสถานะได้ที่แท็บ 'ตรวจสอบสถานะ'";
                $active_tab = 'check';
                $search_result = $enrollments[$existing_index];
            } else {
                $new_id_num = count($enrollments) + 1;
                $app_id = sprintf('MCU-UB-2570-%04d', $new_id_num);

                $new_record = [
                    'app_id'           => $app_id,
                    'citizen_id'       => $citizen_id,
                    'applicant_type'   => $applicant_type,
                    'title_name'       => $title_name,
                    'first_name'       => $first_name,
                    'last_name'        => $last_name,
                    'phone'            => $phone,
                    'email'            => $email,
                    'line_id'          => $line_id,
                    'education_level'  => $education,
                    'curriculum_level' => $curriculum_level,
                    'study_program'    => $program,
                    'address'          => $address,
                    'status'           => 'step1_submitted',
                    'status_text'      => 'ยื่นใบสมัครสำเร็จ (เจ้าหน้าที่กำลังตรวจสอบคุณสมบัติและเอกสาร)',
                    'interview_result' => 'รอการพิจารณาตรวจสอบเอกสาร',
                    'interview_date'   => 'จะแจ้งให้ทราบหลังการตรวจสอบเอกสาร',
                    'student_id'       => '',
                    'enrollment_date'  => '',
                    'registered_courses' => [],
                    'created_at'       => date('Y-m-d H:i:s')
                ];

                $enrollments[] = $new_record;
                saveEnrollments($dataFile, $enrollments);

                $msg_success = "ยื่นใบสมัครออนไลน์เรียบร้อยแล้ว! รหัสใบสมัครของท่านคือ: <strong>{$app_id}</strong> เจ้าหน้าที่จะดำเนินการตรวจสอบคุณสมบัติและเอกสารหลักฐานต่อไป";
                $search_result = $new_record;
                $active_tab = 'check';
            }
        }
    }

    // 2. ตรวจสอบสถานะการสมัคร (Step 2 & 3)
    if ($action === 'check_status') {
        $query = trim($_POST['search_query'] ?? '');
        $found = null;

        if (!empty($query)) {
            foreach ($enrollments as $item) {
                if ($item['citizen_id'] === $query || strcasecmp($item['app_id'], $query) === 0 || (!empty($item['student_id']) && $item['student_id'] === $query)) {
                    $found = $item;
                    break;
                }
            }
        }

        if ($found) {
            $search_result = $found;
            $active_tab = 'check';
        } else {
            $msg_error = 'ไม่พบข้อมูลใบสมัครจากเลขประจำตัวประชาชนหรือรหัสที่ระบุ กรุณาตรวจสอบความถูกต้อง';
            $active_tab = 'check';
        }
    }

    // 3. ขึ้นทะเบียนนิสิตใหม่ออนไลน์ (Step 4)
    if ($action === 'enroll_student') {
        $target_citizen = trim($_POST['target_citizen'] ?? '');
        $found_index = -1;

        foreach ($enrollments as $idx => $item) {
            if ($item['citizen_id'] === $target_citizen || strcasecmp($item['app_id'], $target_citizen) === 0) {
                $found_index = $idx;
                break;
            }
        }

        if ($found_index >= 0) {
            $record = &$enrollments[$found_index];
            
            // สร้างรหัสนิสิตใหม่หากยังไม่มี
            if (empty($record['student_id'])) {
                $enrolled_count = 0;
                foreach ($enrollments as $e) {
                    if (!empty($e['student_id'])) $enrolled_count++;
                }
                $record['student_id'] = sprintf('6701201%03d', $enrolled_count + 1);
            }

            $record['status'] = 'step4_enrolled';
            $record['status_text'] = 'ขึ้นทะเบียนนิสิตเรียบร้อยแล้ว (สถานะ: นิสิตปัจจุบัน)';
            $record['enrollment_date'] = date('Y-m-d H:i:s');
            
            // บันทึกรายวิชาภาคการศึกษาที่ 1 ปี 1 ตาม มคอ.๒ (๑๙ หน่วยกิต)
            $record['registered_courses'] = [
                ['code' => '๐๐๐ ๑๓๕', 'name' => 'พระไตรปิฎกศึกษา (Tipitaka Studies)', 'credits' => 3],
                ['code' => '๐๐๐ ๑๓๙', 'name' => 'เทศนาและปาฐกถาธรรม (Homiletics and Dhamma Discourse)', 'credits' => 2],
                ['code' => '๐๐๐ ๑๕๔', 'name' => 'สมาธิและวิปัสสนากรรมฐาน ๑ (Meditation and Vipassana Bhavana I)', 'credits' => 2],
                ['code' => '๑๐๑ ๑๐๑', 'name' => 'พระพุทธศาสนากับวิทยาศาสตร์ (Buddhism and Science)', 'credits' => 3],
                ['code' => '๑๐๑ ๓๑๐', 'name' => 'พระพุทธศาสนากับเทคโนโลยีปัญญาประดิษฐ์ (AI for Buddhism)', 'credits' => 3],
                ['code' => '๐๐๐ ๑๔๕', 'name' => 'ภาษาบาลีเบื้องต้น (Basic Pali)', 'credits' => 3],
                ['code' => '๐๐๐ ๑๕๑', 'name' => 'การเขียนเชิงวิชาการทางพระพุทธศาสนา (Academic Writing)', 'credits' => 3]
            ];

            saveEnrollments($dataFile, $enrollments);
            $enrolled_student = $record;
            $search_result = $record;
            $active_tab = 'voucher';
            $msg_success = "ขึ้นทะเบียนนิสิตใหม่ออนไลน์สำเร็จ! ยินดีต้อนรับสู่มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี รหัสนิสิตของท่านคือ: <strong>{$record['student_id']}</strong>";
        } else {
            $msg_error = 'ไม่พบข้อมูลผู้ผ่านการคัดเลือกเพื่อขึ้นทะเบียนนิสิต กรุณาตรวจสอบเลขประจำตัวประชาชน';
            $active_tab = 'register';
        }
    }
}

// ตรวจสอบว่าส่งพารามิเตอร์ค้นหาผ่าน GET มาหรือไม่
if (isset($_GET['check_id'])) {
    $q = trim($_GET['check_id']);
    foreach ($enrollments as $item) {
        if ($item['citizen_id'] === $q || strcasecmp($item['app_id'], $q) === 0) {
            $search_result = $item;
            $active_tab = 'check';
            break;
        }
    }
}
?>

<!-- หัวข้อและแบนเนอร์ระบบ -->
<div class="page-header-card">
    <div>
        <h1 style="display: flex; align-items: center; gap: 10px;">
            <i data-lucide="graduation-cap" style="width: 32px; height: 32px; color: var(--primary-color);"></i>
            ระบบรับสมัครและขึ้นทะเบียนนิสิตใหม่ออนไลน์
        </h1>
        <p style="color: #64748b; margin-top: 4px;">
            หลักสูตรพุทธศาสตรบัณฑิต (พธ.บ.) คณะพุทธศาสตร์ มจร วิทยาเขตอุบลราชธานี (มคอ.๒ ๒๕๗๐)
        </p>
    </div>
    <span class="page-header-badge" style="background: #16a34a; display: inline-flex; align-items: center; gap: 6px;">
        <i data-lucide="check-circle" style="width: 15px; height: 15px;"></i> เปิดระบบรับสมัครและขึ้นทะเบียนแล้ว
    </span>
</div>

<!-- ข้อความแจ้งเตือนสถานะการทำงาน -->
<?php if (!empty($msg_success)): ?>
    <div role="alert" style="background: #dcfce7; border-left: 5px solid #16a34a; color: #14532d; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i data-lucide="check-circle-2" style="width: 24px; height: 24px; color: #16a34a; flex-shrink: 0;"></i>
        <div><?php echo $msg_success; ?></div>
    </div>
<?php endif; ?>

<?php if (!empty($msg_error)): ?>
    <div role="alert" style="background: #fee2e2; border-left: 5px solid #dc2626; color: #7f1d1d; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i data-lucide="alert-triangle" style="width: 24px; height: 24px; color: #dc2626; flex-shrink: 0;"></i>
        <div><?php echo htmlspecialchars($msg_error); ?></div>
    </div>
<?php endif; ?>

<!-- ไทม์ไลน์ ๔ ขั้นตอนการสมัครเข้าศึกษาตามที่กำหนด -->
<section aria-labelledby="steps-heading" style="margin-bottom: 25px;">
    <h2 id="steps-heading" style="font-size: 1.25rem; margin-bottom: 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="list-ordered" style="width: 22px; height: 22px; color: var(--primary-color);"></i>
        ๔ ขั้นตอนการสมัครเข้าศึกษาและขึ้นทะเบียนนิสิต (ครบวงจรออนไลน์)
    </h2>
    <div class="admission-stepper">
        <!-- ขั้นตอนที่ 1 -->
        <div class="step-card <?php echo ($active_tab === 'apply') ? 'active-step' : ''; ?>">
            <div class="step-card-num">๑</div>
            <h4>ยื่นใบสมัคร</h4>
            <p>กรอกใบสมัครออนไลน์ หรือสมัคร ณ ห้องทะเบียน มจร อุบลราชธานี</p>
            <div style="margin-top: 10px;">
                <button type="button" onclick="switchEnrollTab('apply')" class="btn btn-outline" style="font-size: 0.8rem; padding: 4px 10px; width: 100%;">
                    <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i> กรอกใบสมัครออนไลน์
                </button>
            </div>
        </div>

        <!-- ขั้นตอนที่ 2 -->
        <div class="step-card">
            <div class="step-card-num" style="background: #0284c7;">๒</div>
            <h4>ตรวจสอบเอกสาร</h4>
            <p>เจ้าหน้าที่ตรวจสอบคุณสมบัติและเอกสารหลักฐานของผู้สมัคร</p>
            <div style="margin-top: 10px;">
                <button type="button" onclick="switchEnrollTab('check')" class="btn btn-outline" style="font-size: 0.8rem; padding: 4px 10px; width: 100%;">
                    <i data-lucide="file-search" style="width: 14px; height: 14px;"></i> เช็คสถานะเอกสาร
                </button>
            </div>
        </div>

        <!-- ขั้นตอนที่ 3 -->
        <div class="step-card">
            <div class="step-card-num" style="background: #d97706;">๓</div>
            <h4>สอบสัมภาษณ์</h4>
            <p>เข้ารับการสัมภาษณ์ทางวิชาการและทัศนคติ เพื่อประเมินความพร้อม</p>
            <div style="margin-top: 10px;">
                <button type="button" onclick="switchEnrollTab('check')" class="btn btn-outline" style="font-size: 0.8rem; padding: 4px 10px; width: 100%;">
                    <i data-lucide="calendar-check" style="width: 14px; height: 14px;"></i> ตารางสอบสัมภาษณ์
                </button>
            </div>
        </div>

        <!-- ขั้นตอนที่ 4 -->
        <div class="step-card <?php echo ($active_tab === 'register' || $active_tab === 'voucher') ? 'active-step' : ''; ?>" style="border-left: 4px solid #16a34a;">
            <div class="step-card-num" style="background: #16a34a;">๔</div>
            <h4>ขึ้นทะเบียนนิสิต</h4>
            <p>รายงานตัวและลงทะเบียนเรียนเพื่อเริ่มการศึกษา <strong>ทำเป็นระบบออนไลน์</strong></p>
            <div style="margin-top: 10px;">
                <button type="button" onclick="switchEnrollTab('register')" class="btn btn-primary" style="font-size: 0.8rem; padding: 4px 10px; width: 100%; background: #16a34a;">
                    <i data-lucide="check-square" style="width: 14px; height: 14px;"></i> ขึ้นทะเบียนนิสิตออนไลน์
                </button>
            </div>
        </div>
    </div>
</section>

<!-- กล่องทดสอบด่วน Quick Demo Bar สำหรับสาธิตระบบ -->
<div style="background: #f8fafc; border: 1px dashed #94a3b8; border-radius: 8px; padding: 12px 18px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; font-size: 0.875rem;">
    <div style="display: flex; align-items: center; gap: 8px; color: #334155;">
        <i data-lucide="info" style="width: 18px; height: 18px; color: var(--primary-color);"></i>
        <span><strong>ทดลองใช้งานระบบ:</strong> คลิกรหัสบัตรประชาชนตัวอย่างเพื่อทดสอบระบบแต่ละขั้นตอนได้ทันที:</span>
    </div>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="index.php?page=enroll&tab=register&check_id=1349900123456" class="btn btn-outline" style="font-size: 0.75rem; padding: 4px 8px;" title="ทดสอบขึ้นทะเบียนนิสิต ขั้นตอนที่ ๔">
            🎓 ทดสอบขั้นตอนที่ ๔ (พร้อมขึ้นทะเบียน: 1349900123456)
        </a>
        <a href="index.php?page=enroll&tab=check&check_id=1349900987654" class="btn btn-outline" style="font-size: 0.75rem; padding: 4px 8px;" title="ทดสอบเช็คสถานะนัดสัมภาษณ์ ขั้นตอนที่ ๓">
            📋 ทดสอบขั้นตอนที่ ๒-๓ (รอสัมภาษณ์: 1349900987654)
        </a>
        <a href="index.php?page=enroll&tab=check&check_id=1349900555555" class="btn btn-outline" style="font-size: 0.75rem; padding: 4px 8px;" title="ดูบัตรนิสิตที่ขึ้นทะเบียนสมบูรณ์">
            🆔 ดูนิสิตที่ขึ้นทะเบียนแล้ว (1349900555555)
        </a>
    </div>
</div>

<!-- แถบนำทางแท็บแบบมาตรฐาน WCAG AAA (Tablist) -->
<div class="enroll-tabs-nav" role="tablist" aria-label="เมนูระบบรับสมัครและขึ้นทะเบียน">
    <button type="button" role="tab" id="tab-btn-overview" aria-selected="<?php echo ($active_tab === 'overview') ? 'true' : 'false'; ?>" aria-controls="panel-overview" class="enroll-tab-btn <?php echo ($active_tab === 'overview') ? 'active' : ''; ?>" onclick="switchEnrollTab('overview')">
        <i data-lucide="book-open" style="width: 18px; height: 18px;"></i>
        ๑. ขั้นตอนและคุณสมบัติ
    </button>
    <button type="button" role="tab" id="tab-btn-apply" aria-selected="<?php echo ($active_tab === 'apply') ? 'true' : 'false'; ?>" aria-controls="panel-apply" class="enroll-tab-btn <?php echo ($active_tab === 'apply') ? 'active' : ''; ?>" onclick="switchEnrollTab('apply')">
        <i data-lucide="file-plus" style="width: 18px; height: 18px;"></i>
        ๒. ยื่นใบสมัครออนไลน์
    </button>
    <button type="button" role="tab" id="tab-btn-check" aria-selected="<?php echo ($active_tab === 'check') ? 'true' : 'false'; ?>" aria-controls="panel-check" class="enroll-tab-btn <?php echo ($active_tab === 'check') ? 'active' : ''; ?>" onclick="switchEnrollTab('check')">
        <i data-lucide="search" style="width: 18px; height: 18px;"></i>
        ๓. ตรวจสอบสถานะ & นัดสัมภาษณ์
    </button>
    <button type="button" role="tab" id="tab-btn-register" aria-selected="<?php echo ($active_tab === 'register' || $active_tab === 'voucher') ? 'true' : 'false'; ?>" aria-controls="panel-register" class="enroll-tab-btn <?php echo ($active_tab === 'register' || $active_tab === 'voucher') ? 'active' : ''; ?>" onclick="switchEnrollTab('register')">
        <i data-lucide="user-check" style="width: 18px; height: 18px;"></i>
        ๔. ขึ้นทะเบียนนิสิตใหม่ออนไลน์
    </button>
</div>

<!-- =========================================================================
     แท็บ 1: ขั้นตอนและคุณสมบัติ (Admissions Overview)
     ========================================================================= -->
<div id="panel-overview" class="enroll-tab-panel <?php echo ($active_tab === 'overview') ? 'active' : ''; ?>" role="tabpanel" aria-labelledby="tab-btn-overview">
    <div style="background: #ecfdf5; border-left: 4px solid #10b981; padding: 18px 24px; border-radius: 8px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h3 style="color: #065f46; font-size: 1.15rem; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="sparkles" style="width: 20px; height: 20px; color: #059669;"></i>
                โอกาสทางการศึกษาสำหรับพระภิกษุ สามเณร และบุคคลทั่วไป (มคอ.๒)
            </h3>
            <p style="color: #047857; font-size: 0.925rem;">
                หลักสูตรพุทธศาสตรบัณฑิต ๑๓๒ หน่วยกิต มีทุนการศึกษา กองทุนสนับสนุน และหอพักสำหรับพระภิกษุสามเณร
            </p>
        </div>
        <a href="มจร.วิทยาเขตอุบลราชธานี มคอ.2 สาขาวิชาพระพุทธศาสนา ปรับปรุง ๒๕๗๐.pdf" target="_blank" class="btn btn-primary" style="font-size: 0.85rem; gap: 6px;">
            <i data-lucide="download" style="width: 15px; height: 15px;"></i> ดาวน์โหลด มคอ.๒ (PDF)
        </a>
    </div>

    <div class="card-grid">
        <div class="info-card">
            <h3 style="font-size: 1.1rem; color: var(--secondary-color); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="graduation-cap" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
                คุณสมบัติผู้สมัคร (บรรพชิต)
            </h3>
            <ul style="margin-left: 18px; color: #475569; font-size: 0.9rem; line-height: 1.8;">
                <li>เป็นพระภิกษุ หรือสามเณร</li>
                <li>สำเร็จการศึกษาระดับมัธยมศึกษาตอนปลาย (ม.6) หรือเทียบเท่า หรือ</li>
                <li>สอบได้เปรียญธรรม 3 ประโยค (ป.ธ.๓) ขึ้นไป และจบ ม.ต้น หรือเทียบเท่า หรือ</li>
                <li>เป็นผู้มีคุณสมบัติตามข้อบังคับของมหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย</li>
            </ul>
        </div>

        <div class="info-card">
            <h3 style="font-size: 1.1rem; color: var(--secondary-color); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="users" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
                คุณสมบัติผู้สมัคร (คฤหัสถ์)
            </h3>
            <ul style="margin-left: 18px; color: #475569; font-size: 0.9rem; line-height: 1.8;">
                <li>บุคคลทั่วไป ทั้งชายและหญิง</li>
                <li>สำเร็จการศึกษาระดับมัธยมศึกษาตอนปลาย (ม.6) หรือ ปวช. หรือ กศน. ม.ปลาย หรือเทียบเท่า</li>
                <li>ไม่เป็นผู้มีความประพฤติเสื่อมเสีย หรือมีโรคติดต่อร้ายแรง</li>
                <li>มีความสนใจในการศึกษาหลักธรรมทางพระพุทธศาสนาและการประยุกต์ใช้เพื่อสังคม</li>
            </ul>
        </div>
    </div>

    <h3 style="font-size: 1.15rem; margin: 25px 0 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="file-check-2" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
        เอกสารหลักฐานที่ต้องเตรียม (นำมายื่นในวันรายงานตัวหรืออัปโหลด)
    </h3>
    <div class="custom-table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">ลำดับ</th>
                    <th>รายการเอกสารหลักฐาน</th>
                    <th style="width: 150px; text-align: center;">จำนวน</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">1</td>
                    <td>สำเนาใบสุทธิ (สำหรับบรรพชิต) หรือ สำเนาบัตรประจำตัวประชาชน (สำหรับคฤหัสถ์)</td>
                    <td style="text-align: center;">2 ชุด</td>
                </tr>
                <tr>
                    <td style="text-align: center;">2</td>
                    <td>สำเนาทะเบียนบ้าน / ทะเบียนวัด</td>
                    <td style="text-align: center;">2 ชุด</td>
                </tr>
                <tr>
                    <td style="text-align: center;">3</td>
                    <td>สำเนาหลักฐานการศึกษา (ใบ รบ. / ใบ ปพ.1 หรือ ประกาศนียบัตร ป.ธ.)</td>
                    <td style="text-align: center;">2 ชุด</td>
                </tr>
                <tr>
                    <td style="text-align: center;">4</td>
                    <td>รูปถ่ายหน้าตรง ขนาด 1.5 นิ้ว หน้าตรง ไม่สวมแว่นตาดำ ถ่ายไว้ไม่เกิน 6 เดือน</td>
                    <td style="text-align: center;">3 รูป</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- กล่องติดต่อสอบถามข้อมูลการรับสมัคร -->
    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 18px 22px; margin-top: 25px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: #fef3c7; display: flex; align-items: center; justify-content: center; color: #92400e; flex-shrink: 0;">
                <i data-lucide="phone-call" style="width: 24px; height: 24px;"></i>
            </div>
            <div>
                <h4 style="color: #92400e; font-size: 1rem; margin: 0 0 4px 0;">
                    สอบถามข้อมูลการรับสมัครเพิ่มเติม: พระมหาวีระชาติ ธีรสิทฺโธ, ผศ.ดร.
                </h4>
                <div style="display: flex; gap: 14px; flex-wrap: wrap; font-size: 0.85rem; color: #78350f;">
                    <span><strong>โทร:</strong> <a href="tel:0817060363" style="color: #0284c7; text-decoration: none; font-weight: 700;">081-706-0363</a></span>
                    <span><strong>Email:</strong> <a href="mailto:weerachat.pen@mcu.ac.th" style="color: var(--primary-color); text-decoration: none;">weerachat.pen@mcu.ac.th</a></span>
                    <span><strong>LINE ID:</strong> <a href="https://line.me/ti/p/~0817060363" target="_blank" rel="noopener noreferrer" style="color: #16a34a; text-decoration: none; font-weight: 700;">0817060363</a></span>
                    <span><strong>Facebook:</strong> <a href="https://www.facebook.com/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" style="color: #1877f2; text-decoration: none; font-weight: 700;">Dhirasiddho weerachat</a></span>
                </div>
            </div>
        </div>
        <a href="tel:0817060363" class="btn btn-primary" style="background: #b45309; border-color: #b45309; padding: 8px 18px; font-size: 0.875rem; gap: 6px;">
            <i data-lucide="phone-outgoing" style="width: 15px; height: 15px;"></i> โทรสอบถามทันที
        </a>
    </div>

    <div style="text-align: center; margin-top: 25px;">
        <button type="button" onclick="switchEnrollTab('apply')" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem; gap: 8px;">
            <i data-lucide="edit-3" style="width: 20px; height: 20px;"></i> ดำเนินการยื่นใบสมัครออนไลน์ทันที
        </button>
    </div>
</div>

<!-- =========================================================================
     แท็บ 2: ยื่นใบสมัครออนไลน์ (Step 1 Form)
     ========================================================================= -->
<div id="panel-apply" class="enroll-tab-panel <?php echo ($active_tab === 'apply') ? 'active' : ''; ?>" role="tabpanel" aria-labelledby="tab-btn-apply">
    <div class="enroll-form-card">
        <h3>
            <i data-lucide="file-text" style="width: 22px; height: 22px; color: var(--primary-color);"></i>
            แบบฟอร์มยื่นใบสมัครเข้าศึกษาออนไลน์ (ระดับปริญญาตรี พธ.บ.)
        </h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">
            กรุณากรอกข้อมูลจริงตามบัตรประชาชนหรือหนังสือสุทธิ เพื่อความสะดวกรวดเร็วในการตรวจสอบสิทธิ์และนัดสัมภาษณ์
        </p>

        <form action="index.php?page=enroll" method="post">
            <input type="hidden" name="action" value="submit_app">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="applicant_type">สถานภาพผู้สมัคร <span style="color: #dc2626;">*</span></label>
                    <select id="applicant_type" name="applicant_type" class="form-control" required onchange="handleTypeChange(this.value)">
                        <option value="monk">พระภิกษุ / สามเณร (บรรพชิต)</option>
                        <option value="layman">บุคคลทั่วไป (คฤหัสถ์ ชาย-หญิง)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="citizen_id">เลขประจำตัวประชาชน (๑๓ หลัก) <span style="color: #dc2626;">*</span></label>
                    <input type="text" id="citizen_id" name="citizen_id" class="form-control" placeholder="เช่น 1349900123456" maxlength="13" pattern="[0-9]{13}" required aria-describedby="citizen-hint">
                    <small id="citizen-hint" style="color: #64748b; font-size: 0.8rem;">กรอกตัวเลข ๑๓ หลัก ไม่ต้องใส่ขีด</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="title_name">คำนำหน้า / สมณศักดิ์ <span style="color: #dc2626;">*</span></label>
                    <input type="text" id="title_name" name="title_name" class="form-control" placeholder="เช่น พระ, พระมหา, พระครู, นาย, นางสาว" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="first_name">ชื่อ <span style="color: #dc2626;">*</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="ชื่อตัว" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="last_name" id="label-lastname">ฉายา / นามสกุล <span style="color: #dc2626;">*</span></label>
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="เช่น อิทฺธิญาโณ หรือ นามสกุล" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="curriculum_level">หลักสูตรที่ประสงค์สมัครเข้าศึกษา <span style="color: #dc2626;">*</span></label>
                    <select id="curriculum_level" name="curriculum_level" class="form-control" required>
                        <option value="หลักสูตรพุทธศาสตรดุษฎีบัณฑิต สาขาวิชาพระพุทธศาสนา (ปริญญาเอก - พธ.ด.)" <?php echo ($preset_level === 'phd') ? 'selected' : ''; ?>>
                            หลักสูตรพุทธศาสตรดุษฎีบัณฑิต (ปริญญาเอก - พธ.ด.)
                        </option>
                        <option value="หลักสูตรพุทธศาสตรมหาบัณฑิต สาขาวิชาพระพุทธศาสนา (ปริญญาโท - พธ.ม.)" <?php echo ($preset_level === 'master') ? 'selected' : ''; ?>>
                            หลักสูตรพุทธศาสตรมหาบัณฑิต (ปริญญาโท - พธ.ม.)
                        </option>
                        <option value="หลักสูตรพุทธศาสตรบัณฑิต สาขาวิชาพระพุทธศาสนา (ปริญญาตรี - พธ.บ.)" <?php echo ($preset_level === 'bachelor' || empty($preset_level)) ? 'selected' : ''; ?>>
                            หลักสูตรพุทธศาสตรบัณฑิต (ปริญญาตรี - พธ.บ.)
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="education">วุฒิการศึกษาเดิมที่ใช้สมัคร <span style="color: #dc2626;">*</span></label>
                    <select id="education" name="education" class="form-control" required>
                        <option value="มัธยมศึกษาตอนปลาย (ม.6) หรือเทียบเท่า">มัธยมศึกษาตอนปลาย (ม.6) หรือเทียบเท่า</option>
                        <option value="กศน. มัธยมศึกษาตอนปลาย">กศน. มัธยมศึกษาตอนปลาย</option>
                        <option value="ประกาศนียบัตรวิชาชีพ (ปวช.)">ประกาศนียบัตรวิชาชีพ (ปวช.)</option>
                        <option value="ป.ธ.๓ - ป.ธ.๙ (เปรียญธรรม ๓-๙ ประโยค)">ป.ธ.๓ - ป.ธ.๙ (เปรียญธรรม ๓-๙ ประโยค)</option>
                        <option value="ปริญญาตรี หรือเทียบเท่า">ปริญญาตรี หรือเทียบเท่า</option>
                        <option value="ปริญญาโท หรือเทียบเท่า">ปริญญาโท หรือเทียบเท่า</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="program">แผนการเรียนที่ประสงค์สมัคร <span style="color: #dc2626;">*</span></label>
                    <select id="program" name="program" class="form-control" required>
                        <option value="ภาคปกติ (วันจันทร์ - วันศุกร์)">ภาคปกติ (วันจันทร์ - วันศุกร์)</option>
                        <option value="ภาคพิเศษ (วันเสาร์ - วันอาทิตย์)">ภาคพิเศษ (วันเสาร์ - วันอาทิตย์)</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="phone">หมายเลขโทรศัพท์ติดต่อ <span style="color: #dc2626;">*</span></label>
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="เช่น 081-234-5678" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">อีเมล (ถ้ามี)</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="example@gmail.com">
                </div>
                <div class="form-group">
                    <label class="form-label" for="line_id">LINE ID (ถ้ามี)</label>
                    <input type="text" id="line_id" name="line_id" class="form-control" placeholder="ไอดีไลน์เพื่อรับการแจ้งเตือน">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="address">ที่อยู่ปัจจุบัน / วัดที่จำพรรษา <span style="color: #dc2626;">*</span></label>
                <textarea id="address" name="address" rows="3" class="form-control" placeholder="ระบุเลขที่/ชื่อวัด หมู่ที่ ตำบล อำเภอ จังหวัด รหัสไปรษณีย์" required></textarea>
            </div>

            <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer;">
                    <input type="checkbox" required style="width: 18px; height: 18px; margin-top: 2px;">
                    <span style="font-size: 0.875rem; color: #334155;">
                        ข้าพเจ้าขอรับรองว่าข้อความข้างต้นเป็นความจริงทุกประการ หากตรวจสอบภายหลังพบว่ามีคุณสมบัติไม่ตรงตามที่มหาวิทยาลัยกำหนด ข้าพเจ้ายินยอมให้ตัดสิทธิ์การเข้าศึกษาโดยไม่มีเงื่อนไข
                    </span>
                </label>
            </div>

            <div style="display: flex; gap: 15px; align-items: center; justify-content: flex-end; flex-wrap: wrap;">
                <button type="reset" class="btn btn-outline">
                    <i data-lucide="rotate-ccw" style="width: 16px; height: 16px;"></i> ล้างข้อมูล
                </button>
                <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 1rem;">
                    <i data-lucide="send" style="width: 18px; height: 18px;"></i> บันทึกยื่นใบสมัครออนไลน์
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================================
     แท็บ 3: ตรวจสอบสถานะการสมัคร & นัดสัมภาษณ์ (Step 2 & 3 Tracker)
     ========================================================================= -->
<div id="panel-check" class="enroll-tab-panel <?php echo ($active_tab === 'check') ? 'active' : ''; ?>" role="tabpanel" aria-labelledby="tab-btn-check">
    <div class="enroll-form-card">
        <h3>
            <i data-lucide="search" style="width: 22px; height: 22px; color: var(--primary-color);"></i>
            ค้นหาและตรวจสอบสถานะการสมัคร / นัดหมายสอบสัมภาษณ์
        </h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">
            กรอกเลขประจำตัวประชาชน ๑๓ หลัก หรือ รหัสใบสมัคร (เช่น MCU-UB-2570-0001) เพื่อตรวจสอบสถานะในระบบ
        </p>

        <form action="index.php?page=enroll" method="post" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 25px;">
            <input type="hidden" name="action" value="check_status">
            <div style="flex: 1; min-width: 280px;">
                <input type="text" name="search_query" class="form-control" placeholder="กรอกเลขประจำตัวประชาชน หรือ รหัสใบสมัคร" value="<?php echo htmlspecialchars($_POST['search_query'] ?? ($_GET['check_id'] ?? '')); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" style="gap: 8px;">
                <i data-lucide="search" style="width: 18px; height: 18px;"></i> ค้นหาสถานะ
            </button>
        </form>

        <?php if ($search_result): ?>
            <!-- การแสดงผลข้อมูลสถานะผู้สมัคร -->
            <div style="background: #ffffff; border: 2px solid var(--border-color); border-radius: 10px; padding: 22px; box-shadow: var(--box-shadow);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 20px;">
                    <div>
                        <span class="status-pill status-pill-info" style="margin-bottom: 8px;">
                            รหัสใบสมัคร: <?php echo htmlspecialchars($search_result['app_id']); ?>
                        </span>
                        <h4 style="font-size: 1.3rem; color: var(--secondary-color); margin: 6px 0;">
                            <?php echo htmlspecialchars($search_result['title_name'] . $search_result['first_name'] . ' ' . $search_result['last_name']); ?>
                        </h4>
                        <p style="color: #64748b; font-size: 0.875rem;">
                            หลักสูตร: <strong><?php echo htmlspecialchars($search_result['curriculum_level'] ?? 'หลักสูตรพุทธศาสตรบัณฑิต (พธ.บ.)'); ?></strong><br>
                            เลขบัตรประชาชน: <?php echo htmlspecialchars(substr($search_result['citizen_id'], 0, 3) . '-xxxxxx-' . substr($search_result['citizen_id'], -2)); ?> | แผนการเรียน: <?php echo htmlspecialchars($search_result['study_program']); ?>
                        </p>
                    </div>

                    <div>
                        <?php if ($search_result['status'] === 'step4_enrolled'): ?>
                            <span class="status-pill status-pill-success" style="font-size: 0.95rem; padding: 8px 16px;">
                                <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i> ขึ้นทะเบียนนิสิตเรียบร้อยแล้ว
                            </span>
                        <?php elseif ($search_result['status'] === 'step3_passed'): ?>
                            <span class="status-pill status-pill-success" style="font-size: 0.95rem; padding: 8px 16px;">
                                <i data-lucide="award" style="width: 18px; height: 18px;"></i> ผ่านการคัดเลือก (พร้อมขึ้นทะเบียนนิสิต)
                            </span>
                        <?php elseif ($search_result['status'] === 'step2_verified'): ?>
                            <span class="status-pill status-pill-warning" style="font-size: 0.95rem; padding: 8px 16px;">
                                <i data-lucide="clock" style="width: 18px; height: 18px;"></i> เอกสารผ่านแล้ว (รอนัดสัมภาษณ์)
                            </span>
                        <?php else: ?>
                            <span class="status-pill status-pill-info" style="font-size: 0.95rem; padding: 8px 16px;">
                                <i data-lucide="hourglass" style="width: 18px; height: 18px;"></i> อยู่ระหว่างตรวจสอบเอกสาร
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ความคืบหน้าระดับขั้นตอน (Step Progress) -->
                <div style="margin-bottom: 25px;">
                    <h5 style="color: #334155; margin-bottom: 15px; font-size: 1rem;">สถานะการดำเนินงานรายขั้นตอน:</h5>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                        <!-- ขั้นที่ 1 -->
                        <div style="border-radius: 8px; padding: 12px; border: 1px solid #10b981; background: #ecfdf5;">
                            <div style="display: flex; align-items: center; gap: 6px; color: #047857; font-weight: 600; font-size: 0.875rem;">
                                <i data-lucide="check-circle-2" style="width: 16px; height: 16px;"></i> ๑. ยื่นใบสมัคร
                            </div>
                            <span style="font-size: 0.775rem; color: #065f46;">เรียบร้อยแล้ว</span>
                        </div>

                        <!-- ขั้นที่ 2 -->
                        <div style="border-radius: 8px; padding: 12px; border: 1px solid <?php echo in_array($search_result['status'], ['step2_verified', 'step3_passed', 'step4_enrolled']) ? '#10b981; background: #ecfdf5;' : '#cbd5e1; background: #f8fafc;'; ?>">
                            <div style="display: flex; align-items: center; gap: 6px; color: <?php echo in_array($search_result['status'], ['step2_verified', 'step3_passed', 'step4_enrolled']) ? '#047857;' : '#64748b;'; ?> font-weight: 600; font-size: 0.875rem;">
                                <i data-lucide="<?php echo in_array($search_result['status'], ['step2_verified', 'step3_passed', 'step4_enrolled']) ? 'check-circle-2' : 'clock'; ?>" style="width: 16px; height: 16px;"></i> ๒. ตรวจเอกสาร
                            </div>
                            <span style="font-size: 0.775rem; color: #475569;">
                                <?php echo in_array($search_result['status'], ['step2_verified', 'step3_passed', 'step4_enrolled']) ? 'คุณสมบัติถูกต้องครบถ้วน' : 'กำลังตรวจสอบ'; ?>
                            </span>
                        </div>

                        <!-- ขั้นที่ 3 -->
                        <div style="border-radius: 8px; padding: 12px; border: 1px solid <?php echo in_array($search_result['status'], ['step3_passed', 'step4_enrolled']) ? '#10b981; background: #ecfdf5;' : '#cbd5e1; background: #f8fafc;'; ?>">
                            <div style="display: flex; align-items: center; gap: 6px; color: <?php echo in_array($search_result['status'], ['step3_passed', 'step4_enrolled']) ? '#047857;' : '#64748b;'; ?> font-weight: 600; font-size: 0.875rem;">
                                <i data-lucide="<?php echo in_array($search_result['status'], ['step3_passed', 'step4_enrolled']) ? 'check-circle-2' : 'calendar'; ?>" style="width: 16px; height: 16px;"></i> ๓. สอบสัมภาษณ์
                            </div>
                            <span style="font-size: 0.775rem; color: #475569;">
                                <?php echo in_array($search_result['status'], ['step3_passed', 'step4_enrolled']) ? 'ผ่านการสัมภาษณ์' : htmlspecialchars($search_result['interview_date']); ?>
                            </span>
                        </div>

                        <!-- ขั้นที่ 4 -->
                        <div style="border-radius: 8px; padding: 12px; border: 1px solid <?php echo ($search_result['status'] === 'step4_enrolled') ? '#10b981; background: #ecfdf5;' : ($search_result['status'] === 'step3_passed' ? '#f59e0b; background: #fffbeb;' : '#cbd5e1; background: #f8fafc;'); ?>">
                            <div style="display: flex; align-items: center; gap: 6px; color: <?php echo ($search_result['status'] === 'step4_enrolled') ? '#047857;' : ($search_result['status'] === 'step3_passed' ? '#b45309;' : '#64748b;'); ?> font-weight: 600; font-size: 0.875rem;">
                                <i data-lucide="<?php echo ($search_result['status'] === 'step4_enrolled') ? 'badge-check' : 'arrow-right-circle'; ?>" style="width: 16px; height: 16px;"></i> ๔. ขึ้นทะเบียนนิสิต
                            </div>
                            <span style="font-size: 0.775rem; color: #475569;">
                                <?php echo ($search_result['status'] === 'step4_enrolled') ? 'รหัส ' . htmlspecialchars($search_result['student_id']) : ($search_result['status'] === 'step3_passed' ? 'พร้อมขึ้นทะเบียน' : 'รอตามลำดับ'); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- กล่องแจ้งเตือนการขึ้นทะเบียนนิสิตในขั้นตอนที่ ๔ (Call to Action) -->
                <?php if ($search_result['status'] === 'step3_passed'): ?>
                    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 2px solid #22c55e; border-radius: 8px; padding: 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                        <div>
                            <h5 style="color: #15803d; font-size: 1.1rem; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                <i data-lucide="party-popper" style="width: 20px; height: 20px;"></i>
                                ยินดีด้วย! ท่านผ่านการสอบสัมภาษณ์เข้าศึกษาเรียบร้อยแล้ว
                            </h5>
                            <p style="color: #166534; font-size: 0.875rem; margin: 0;">
                                ท่านสามารถดำเนินการขึ้นทะเบียนนิสิตใหม่ รายงานตัว และลงทะเบียนเรียนภาคการศึกษาที่ ๑ ออนไลน์ได้ทันที
                            </p>
                        </div>
                        <form action="index.php?page=enroll" method="post" style="margin: 0;">
                            <input type="hidden" name="action" value="enroll_student">
                            <input type="hidden" name="target_citizen" value="<?php echo htmlspecialchars($search_result['citizen_id']); ?>">
                            <button type="submit" class="btn btn-primary" style="background: #15803d; border-color: #15803d; padding: 10px 22px; font-size: 0.95rem; gap: 6px;">
                                <i data-lucide="check-square" style="width: 18px; height: 18px;"></i> ดำเนินการขึ้นทะเบียนนิสิตออนไลน์ทันที
                            </button>
                        </form>
                    </div>
                <?php elseif ($search_result['status'] === 'step4_enrolled'): ?>
                    <div style="text-align: center; margin-top: 15px;">
                        <button type="button" onclick="viewVoucherFromStatus('<?php echo htmlspecialchars($search_result['citizen_id']); ?>')" class="btn btn-primary" style="padding: 10px 24px; gap: 8px;">
                            <i data-lucide="printer" style="width: 18px; height: 18px;"></i> ดูและพิมพ์ใบขึ้นทะเบียนนิสิต / บัตรประจำตัวนิสิต
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- =========================================================================
     แท็บ 4: ขึ้นทะเบียนนิสิตใหม่ออนไลน์ (Step 4 Registration System)
     ========================================================================= -->
<div id="panel-register" class="enroll-tab-panel <?php echo ($active_tab === 'register') ? 'active' : ''; ?>" role="tabpanel" aria-labelledby="tab-btn-register">
    <div class="enroll-form-card">
        <h3>
            <i data-lucide="check-square" style="width: 22px; height: 22px; color: #16a34a;"></i>
            ขั้นตอนที่ ๔: รายงานตัวและขึ้นทะเบียนนิสิตใหม่ออนไลน์
        </h3>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 20px;">
            สำหรับผู้สมัครที่ผ่านการสอบสัมภาษณ์และมีรายชื่อผ่านการคัดเลือก สามารถยืนยันสิทธิ์ รายงานตัว และลงทะเบียนเรียนภาคการศึกษาที่ ๑ (๑๙ หน่วยกิต ตาม มคอ.๒) ผ่านระบบออนไลน์ได้ที่นี่
        </p>

        <!-- ฟอร์มกรอกเลขเพื่อขึ้นทะเบียน -->
        <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 25px;">
            <form action="index.php?page=enroll" method="post">
                <input type="hidden" name="action" value="enroll_student">
                <label class="form-label" for="target_citizen">กรอกเลขประจำตัวประชาชน หรือ รหัสใบสมัคร ของผู้ผ่านการคัดเลือก <span style="color: #dc2626;">*</span></label>
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 12px;">
                    <div style="flex: 1; min-width: 260px;">
                        <input type="text" id="target_citizen" name="target_citizen" class="form-control" placeholder="เช่น 1349900123456 หรือ MCU-UB-2570-0001" value="<?php echo htmlspecialchars($_GET['check_id'] ?? ''); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background: #16a34a; gap: 8px;">
                        <i data-lucide="user-check" style="width: 18px; height: 18px;"></i> ตรวจสอบสิทธิ์ & ขึ้นทะเบียนนิสิต
                    </button>
                </div>
                <small style="color: #64748b;">
                    💡 สามารถทดสอบด้วยเลขประชาชนตัวอย่างที่ผ่านการสัมภาษณ์แล้ว: <code>1349900123456</code> (พระสมหมาย อิทฺธิญาโณ)
                </small>
            </form>
        </div>

        <!-- รายละเอียดรายวิชาที่จะลงทะเบียนเรียนเทอม ๑ ตาม มคอ.๒ -->
        <div style="margin-top: 25px;">
            <h4 style="color: var(--secondary-color); font-size: 1.1rem; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="book-marked" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
                แผนการลงทะเบียนเรียน ภาคการศึกษาที่ ๑ ชั้นปีที่ ๑ (มคอ.๒ คณะพุทธศาสตร์ ๑๙ หน่วยกิต)
            </h4>
            <div class="custom-table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">ลำดับ</th>
                            <th style="width: 120px;">รหัสวิชา</th>
                            <th>ชื่อรายวิชาตาม มคอ.๒</th>
                            <th style="width: 110px; text-align: center;">หน่วยกิต</th>
                            <th style="width: 140px; text-align: center;">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td><strong>๐๐๐ ๑๓๕</strong></td>
                            <td>พระไตรปิฎกศึกษา (Tipitaka Studies)</td>
                            <td style="text-align: center;">๓(๓-๐-๖)</td>
                            <td style="text-align: center;"><span class="status-pill status-pill-success" style="font-size: 0.75rem;">วิชาบังคับ</span></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">2</td>
                            <td><strong>๐๐๐ ๑๓๙</strong></td>
                            <td>เทศนาและปาฐกถาธรรม (Homiletics and Dhamma Discourse)</td>
                            <td style="text-align: center;">๒(๒-๐-๔)</td>
                            <td style="text-align: center;"><span class="status-pill status-pill-success" style="font-size: 0.75rem;">วิชาบังคับ</span></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">3</td>
                            <td><strong>๐๐๐ ๑๕๔</strong></td>
                            <td>สมาธิและวิปัสสนากรรมฐาน ๑ (Meditation and Vipassana Bhavana I)</td>
                            <td style="text-align: center;">๒(๑-๒-๓)</td>
                            <td style="text-align: center;"><span class="status-pill status-pill-success" style="font-size: 0.75rem;">วิชาบังคับ</span></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">4</td>
                            <td><strong>๑๐๑ ๑๐๑</strong></td>
                            <td>พระพุทธศาสนากับวิทยาศาสตร์ (Buddhism and Science)</td>
                            <td style="text-align: center;">๓(๓-๐-๖)</td>
                            <td style="text-align: center;"><span class="status-pill status-pill-success" style="font-size: 0.75rem;">วิชาเฉพาะ</span></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">5</td>
                            <td><strong>๑๐๑ ๓๑๐</strong></td>
                            <td>พระพุทธศาสนากับเทคโนโลยีปัญญาประดิษฐ์ (AI for Buddhism)</td>
                            <td style="text-align: center;">๓(๒-๒-๕)</td>
                            <td style="text-align: center;"><span class="status-pill status-pill-success" style="font-size: 0.75rem;">วิชาเฉพาะทันสมัย</span></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">6</td>
                            <td><strong>๐๐๐ ๑๔๕</strong></td>
                            <td>ภาษาบาลีเบื้องต้น (Basic Pali)</td>
                            <td style="text-align: center;">๓(๓-๐-๖)</td>
                            <td style="text-align: center;"><span class="status-pill status-pill-success" style="font-size: 0.75rem;">วิชาพื้นฐาน</span></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">7</td>
                            <td><strong>๐๐๐ ๑๕๑</strong></td>
                            <td>การเขียนเชิงวิชาการทางพระพุทธศาสนา (Academic Writing)</td>
                            <td style="text-align: center;">๓(๓-๐-๖)</td>
                            <td style="text-align: center;"><span class="status-pill status-pill-success" style="font-size: 0.75rem;">วิชาพื้นฐาน</span></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="background: #f8fafc; font-weight: 700;">
                            <td colspan="3" style="text-align: right; padding-right: 20px;">รวมจำนวนหน่วยกิตที่ลงทะเบียนเรียน เทอม ๑:</td>
                            <td style="text-align: center; color: var(--primary-color); font-size: 1.1rem;">๑๙ หน่วยกิต</td>
                            <td style="text-align: center; color: #16a34a;">พร้อมเริ่มเรียน</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================================
     แท็บ 5: บัตรประจำตัวนิสิตและใบยืนยันการขึ้นทะเบียน (Printable Voucher)
     ========================================================================= -->
<?php 
$voucher_student = $enrolled_student ?? (($search_result && $search_result['status'] === 'step4_enrolled') ? $search_result : null);
if ($voucher_student): 
?>
<div id="panel-voucher" class="enroll-tab-panel <?php echo ($active_tab === 'voucher') ? 'active' : ''; ?>" role="tabpanel">
    <div style="display: flex; justify-content: flex-end; margin-bottom: 15px; gap: 10px;" class="btn-print-trigger">
        <button type="button" onclick="window.print()" class="btn btn-primary" style="gap: 8px;">
            <i data-lucide="printer" style="width: 18px; height: 18px;"></i> สั่งพิมพ์ใบขึ้นทะเบียนนิสิต (Print Voucher)
        </button>
        <button type="button" onclick="switchEnrollTab('register')" class="btn btn-outline">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> กลับหน้าระบบ
        </button>
    </div>

    <!-- บัตรและใบรายงานตัวขึ้นทะเบียนนิสิตอย่างเป็นทางการ -->
    <article class="student-voucher" aria-label="ใบรายงานตัวและขึ้นทะเบียนนิสิตใหม่ออนไลน์">
        <div class="student-voucher-header">
            <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 8px;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #92400e; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem;">
                    มจร
                </div>
                <div>
                    <h2 style="margin: 0; font-size: 1.3rem;">มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี</h2>
                    <p style="margin: 2px 0; color: #64748b; font-size: 0.9rem;">คณะพุทธศาสตร์ สาขาวิชาพระพุทธศาสนา (มคอ.๒ ปรับปรุง ๒๕๗๐)</p>
                </div>
            </div>
            <div style="display: inline-block; background: #ecfdf5; border: 1px solid #10b981; color: #047857; padding: 4px 16px; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                ใบรายงานตัวและขึ้นทะเบียนนิสิตใหม่ออนไลน์ (Official Registration Certificate)
            </div>
        </div>

        <div class="student-voucher-body">
            <!-- กรอบรูปถ่ายนิสิต -->
            <div class="student-avatar-box">
                <i data-lucide="user" style="width: 48px; height: 48px; color: #94a3b8; margin-bottom: 6px;"></i>
                <span>รูปถ่ายนิสิต<br>ขนาด ๑.๕ นิ้ว</span>
            </div>

            <!-- ข้อมูลส่วนตัวนิสิต -->
            <div class="voucher-details-grid">
                <div class="voucher-field" style="grid-column: 1 / -1; background: #fffbeb; border-color: #fcd34d;">
                    <label>รหัสประจำตัวนิสิต (STUDENT ID)</label>
                    <strong style="font-size: 1.4rem; color: #92400e; font-family: monospace; letter-spacing: 2px;">
                        <?php echo htmlspecialchars($voucher_student['student_id']); ?>
                    </strong>
                </div>
                <div class="voucher-field">
                    <label>ชื่อ - ฉายา / นามสกุล</label>
                    <strong><?php echo htmlspecialchars($voucher_student['title_name'] . $voucher_student['first_name'] . ' ' . $voucher_student['last_name']); ?></strong>
                </div>
                <div class="voucher-field">
                    <label>เลขประจำตัวประชาชน</label>
                    <strong><?php echo htmlspecialchars($voucher_student['citizen_id']); ?></strong>
                </div>
                <div class="voucher-field">
                    <label>ระดับการศึกษา / หลักสูตร</label>
                    <strong><?php echo htmlspecialchars($voucher_student['curriculum_level'] ?? 'พุทธศาสตรบัณฑิต (พธ.บ.) ๑๓๒ หน่วยกิต'); ?></strong>
                </div>
                <div class="voucher-field">
                    <label>แผนการเรียน</label>
                    <strong><?php echo htmlspecialchars($voucher_student['study_program']); ?></strong>
                </div>
                <div class="voucher-field">
                    <label>เบอร์โทรศัพท์ติดต่อ</label>
                    <strong><?php echo htmlspecialchars($voucher_student['phone']); ?></strong>
                </div>
                <div class="voucher-field">
                    <label>วันที่ขึ้นทะเบียนนิสิต</label>
                    <strong><?php echo !empty($voucher_student['enrollment_date']) ? htmlspecialchars($voucher_student['enrollment_date']) : date('Y-m-d H:i:s'); ?></strong>
                </div>
            </div>
        </div>

        <!-- รายการวิชาที่ขึ้นทะเบียนเรียน -->
        <h4 style="font-size: 1rem; color: var(--secondary-color); margin: 15px 0 8px;">
            รายการวิชาที่ลงทะเบียนเรียน ภาคการศึกษาที่ ๑ (รวม ๑๙ หน่วยกิต)
        </h4>
        <table class="custom-table" style="font-size: 0.85rem; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="width: 100px;">รหัสวิชา</th>
                    <th>ชื่อรายวิชาตาม มคอ.๒</th>
                    <th style="width: 80px; text-align: center;">หน่วยกิต</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $courses = !empty($voucher_student['registered_courses']) ? $voucher_student['registered_courses'] : [
                    ['code' => '๐๐๐ ๑๓๕', 'name' => 'พระไตรปิฎกศึกษา (Tipitaka Studies)', 'credits' => 3],
                    ['code' => '๐๐๐ ๑๓๙', 'name' => 'เทศนาและปาฐกถาธรรม (Homiletics and Dhamma Discourse)', 'credits' => 2],
                    ['code' => '๐๐๐ ๑๕๔', 'name' => 'สมาธิและวิปัสสนากรรมฐาน ๑ (Meditation and Vipassana Bhavana I)', 'credits' => 2],
                    ['code' => '๑๐๑ ๑๐๑', 'name' => 'พระพุทธศาสนากับวิทยาศาสตร์ (Buddhism and Science)', 'credits' => 3],
                    ['code' => '๑๐๑ ๓๑๐', 'name' => 'พระพุทธศาสนากับเทคโนโลยีปัญญาประดิษฐ์ (AI for Buddhism)', 'credits' => 3],
                    ['code' => '๐๐๐ ๑๔๕', 'name' => 'ภาษาบาลีเบื้องต้น (Basic Pali)', 'credits' => 3],
                    ['code' => '๐๐๐ ๑๕๑', 'name' => 'การเขียนเชิงวิชาการทางพระพุทธศาสนา (Academic Writing)', 'credits' => 3]
                ];
                foreach ($courses as $c): 
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($c['code']); ?></strong></td>
                    <td><?php echo htmlspecialchars($c['name']); ?></td>
                    <td style="text-align: center;"><?php echo htmlspecialchars($c['credits']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- ส่วนลายเซ็นและตราประทับ -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 30px; padding-top: 15px; border-top: 1px dashed #cbd5e1; font-size: 0.85rem; color: #475569;">
            <div style="text-align: center;">
                <p>ลงชื่อ..........................................................</p>
                <p>( <?php echo htmlspecialchars($voucher_student['title_name'] . $voucher_student['first_name'] . ' ' . $voucher_student['last_name']); ?> )</p>
                <p>นิสิตผู้รายงานตัว</p>
            </div>
            <div style="text-align: center;">
                <p>ลงชื่อ..........................................................</p>
                <p>( นายทะเบียน มจร วิทยาเขตอุบลราชธานี )</p>
                <p>นายทะเบียน / ผู้ตรวจสอบสิทธิ์</p>
            </div>
        </div>
    </article>
</div>
<?php endif; ?>

<!-- สคริปต์สลับแท็บและลูกเล่นระบบออนไลน์ -->
<script>
function switchEnrollTab(tabName) {
    // ซ่อนทุกแท็บ
    document.querySelectorAll('.enroll-tab-panel').forEach(function(panel) {
        panel.classList.remove('active');
    });
    // ปลด active ปุ่มแท็บ
    document.querySelectorAll('.enroll-tab-btn').forEach(function(btn) {
        btn.classList.remove('active');
        btn.setAttribute('aria-selected', 'false');
    });

    var targetPanel = document.getElementById('panel-' + tabName);
    var targetBtn = document.getElementById('tab-btn-' + tabName);

    if (targetPanel) {
        targetPanel.classList.add('active');
    }
    if (targetBtn) {
        targetBtn.classList.add('active');
        targetBtn.setAttribute('aria-selected', 'true');
    }

    // อัปเดตไอคอน Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
}

function handleTypeChange(val) {
    var labelLast = document.getElementById('label-lastname');
    var inputLast = document.getElementById('last_name');
    if (val === 'monk') {
        if (labelLast) labelLast.innerHTML = 'ฉายา <span style="color: #dc2626;">*</span>';
        if (inputLast) inputLast.placeholder = 'เช่น อิทฺธิญาโณ';
    } else {
        if (labelLast) labelLast.innerHTML = 'นามสกุล <span style="color: #dc2626;">*</span>';
        if (inputLast) inputLast.placeholder = 'นามสกุลจริง';
    }
}

function viewVoucherFromStatus(citizenId) {
    var panelVoucher = document.getElementById('panel-voucher');
    if (panelVoucher) {
        document.querySelectorAll('.enroll-tab-panel').forEach(function(panel) {
            panel.classList.remove('active');
        });
        panelVoucher.classList.add('active');
        window.scrollTo({top: panelVoucher.offsetTop - 50, behavior: 'smooth'});
    } else {
        window.location.href = 'index.php?page=enroll&tab=voucher&check_id=' + encodeURIComponent(citizenId);
    }
}
</script>