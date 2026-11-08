<?php
/**
 * หน้าหลักสูตรการศึกษา คณะพุทธศาสตร์ มจร วิทยาเขตอุบลราชธานี
 * แยกหลักสูตรออกเป็น ๓ ระดับ:
 * ๑. หลักสูตรพุทธศาสตรดุษฎีบัณฑิต สาขาวิชาพระพุทธศาสนา (ปริญญาเอก - พธ.ด.)
 * ๒. หลักสูตรพุทธศาสตรมหาบัณฑิต สาขาวิชาพระพุทธศาสนา (ปริญญาโท - พธ.ม.)
 * ๓. หลักสูตรพุทธศาสตรบัณฑิต สาขาวิชาพระพุทธศาสนา (ปริญญาตรี - พธ.บ.)
 */

$level = isset($_GET['level']) ? trim((string)$_GET['level']) : 'bachelor';
if (!in_array($level, ['phd', 'master', 'bachelor'])) {
    $level = 'bachelor';
}
?>

<div class="page-header-card">
    <div>
        <h1>หลักสูตรการศึกษา คณะพุทธศาสตร์</h1>
        <p style="color: #64748b; margin-top: 4px;">มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี</p>
    </div>
    <span class="page-header-badge" style="display: inline-flex; align-items: center; gap: 6px;">
        <i data-lucide="layers" style="width: 15px; height: 15px;"></i> ระดับ ตรี - โท - เอก
    </span>
</div>

<!-- =========================================================================
     Curriculum Degree Level Switcher Grid (Accessible Tabs)
     ========================================================================= -->
<div class="curriculum-switcher-grid" role="tablist" aria-label="เลือกระดับหลักสูตรการศึกษา">
    <!-- Tab 1: ปริญญาเอก (Ph.D.) -->
    <a href="index.php?page=product&level=phd" 
       id="tab-btn-phd" 
       class="curriculum-tab-card <?php echo ($level === 'phd') ? 'active' : ''; ?>" 
       role="tab" 
       aria-selected="<?php echo ($level === 'phd') ? 'true' : 'false'; ?>" 
       aria-controls="panel-phd"
       onclick="switchCurriculumLevel('phd', event)">
        <span class="deg-badge deg-badge-phd">
            <i data-lucide="award" style="width: 13px; height: 13px;"></i> ปริญญาเอก (พธ.ด.)
        </span>
        <div>
            <div class="curriculum-tab-title">หลักสูตรพุทธศาสตรดุษฎีบัณฑิต</div>
            <div class="curriculum-tab-desc">สาขาวิชาพระพุทธศาสนา (Doctor of Philosophy in Buddhist Studies) • ๔๘ หน่วยกิต</div>
        </div>
    </a>

    <!-- Tab 2: ปริญญาโท (M.A.) -->
    <a href="index.php?page=product&level=master" 
       id="tab-btn-master" 
       class="curriculum-tab-card <?php echo ($level === 'master') ? 'active' : ''; ?>" 
       role="tab" 
       aria-selected="<?php echo ($level === 'master') ? 'true' : 'false'; ?>" 
       aria-controls="panel-master"
       onclick="switchCurriculumLevel('master', event)">
        <span class="deg-badge deg-badge-master">
            <i data-lucide="book-open" style="width: 13px; height: 13px;"></i> ปริญญาโท (พธ.ม.)
        </span>
        <div>
            <div class="curriculum-tab-title">หลักสูตรพุทธศาสตรมหาบัณฑิต</div>
            <div class="curriculum-tab-desc">สาขาวิชาพระพุทธศาสนา (Master of Arts in Buddhist Studies) • ๓๖ หน่วยกิต</div>
        </div>
    </a>

    <!-- Tab 3: ปริญญาตรี (B.A.) -->
    <a href="index.php?page=product&level=bachelor" 
       id="tab-btn-bachelor" 
       class="curriculum-tab-card <?php echo ($level === 'bachelor') ? 'active' : ''; ?>" 
       role="tab" 
       aria-selected="<?php echo ($level === 'bachelor') ? 'true' : 'false'; ?>" 
       aria-controls="panel-bachelor"
       onclick="switchCurriculumLevel('bachelor', event)">
        <span class="deg-badge deg-badge-bachelor">
            <i data-lucide="graduation-cap" style="width: 13px; height: 13px;"></i> ปริญญาตรี (พธ.บ.)
        </span>
        <div>
            <div class="curriculum-tab-title">หลักสูตรพุทธศาสตรบัณฑิต</div>
            <div class="curriculum-tab-desc">สาขาวิชาพระพุทธศาสนา (Bachelor of Arts in Buddhist Studies) • ๑๓๒ หน่วยกิต มคอ.๒</div>
        </div>
    </a>
</div>

<!-- =========================================================================
     PANEL 1: หลักสูตรพุทธศาสตรดุษฎีบัณฑิต สาขาวิชาพระพุทธศาสนา (พธ.ด.)
     ========================================================================= -->
<section id="panel-phd" class="curriculum-panel <?php echo ($level === 'phd') ? 'active' : ''; ?>" role="tabpanel" aria-labelledby="tab-btn-phd">
    <!-- Header Card -->
    <div style="background: linear-gradient(135deg, #831843 0%, #4c0519 100%); color: #ffffff; border-radius: 12px; padding: 24px; margin-bottom: 25px; border-left: 6px solid #f472b6;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
            <div>
                <span style="background: rgba(255,255,255,0.2); color: #fdf2f8; font-size: 0.8rem; font-weight: 700; padding: 3px 10px; border-radius: 15px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                    <i data-lucide="award" style="width: 14px; height: 14px;"></i> ระดับบัณฑิตศึกษาขั้นสูง (ปริญญาเอก)
                </span>
                <h2 style="font-size: 1.5rem; color: #ffffff; margin: 0 0 6px 0;">หลักสูตรพุทธศาสตรดุษฎีบัณฑิต สาขาวิชาพระพุทธศาสนา</h2>
                <p style="color: #fbcfe8; margin: 0; font-size: 0.95rem;">
                    Doctor of Philosophy Program in Buddhist Studies (Ph.D.) | คณะพุทธศาสตร์ มจร วิทยาเขตอุบลราชธานี
                </p>
            </div>
            <a href="index.php?page=enroll&level=phd" class="btn btn-primary" style="background: #f43f5e; border-color: #f43f5e; gap: 6px;">
                <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i> สมัครเข้าศึกษาปริญญาเอก
            </a>
        </div>
    </div>

    <!-- Quick Overview Cards -->
    <div class="card-grid" style="margin-bottom: 25px;">
        <div class="info-card">
            <h3 style="font-size: 1.05rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="graduation-cap" style="width: 20px; height: 20px; color: #be185d;"></i>
                ชื่อปริญญาและสาขาวิชา
            </h3>
            <p style="color: #475569; font-size: 0.9rem; line-height: 1.8;">
                <strong>ชื่อเต็ม (ไทย):</strong> พุทธศาสตรดุษฎีบัณฑิต (พระพุทธศาสนา)<br>
                <strong>ชื่อย่อ (ไทย):</strong> พธ.ด. (พระพุทธศาสนา)<br>
                <strong>ชื่อเต็ม (อังกฤษ):</strong> Doctor of Philosophy (Buddhist Studies)<br>
                <strong>ชื่อย่อ (อังกฤษ):</strong> Ph.D. (Buddhist Studies)<br>
                <strong>วิชาเอก:</strong> พระพุทธศาสนา (Buddhist Studies)
            </p>
        </div>

        <div class="info-card">
            <h3 style="font-size: 1.05rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="layers" style="width: 20px; height: 20px; color: #be185d;"></i>
                จำนวนหน่วยกิตและระยะเวลาศึกษา
            </h3>
            <p style="color: #475569; font-size: 0.9rem; line-height: 1.8;">
                <strong>จำนวนหน่วยกิตรวม:</strong> <span style="color: #be185d; font-weight: 700; font-size: 1.1rem;">๔๘ หน่วยกิต</span><br>
                <strong>ระยะเวลาศึกษา:</strong> ๓ ปีการศึกษา (๖ ภาคการศึกษา) ไม่เกิน ๖ ปี<br>
                <strong>แผนการศึกษา:</strong> แบบ ๑.๑ (วิจัยล้วน) และ แบบ ๒.๑ (ศึกษาวิชา + ดุษฎีนิพนธ์)<br>
                <strong>วัน-เวลาเรียน:</strong> วันเสาร์ - วันอาทิตย์ (เหมาะสำหรับพระสังฆาธิการและผู้ทำงาน)
            </p>
        </div>
    </div>

    <!-- Philosophy & Highlights -->
    <div style="background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%); border: 1px solid #fbcfe8; border-radius: 10px; padding: 22px; margin-bottom: 25px;">
        <h3 style="font-size: 1.25rem; color: #831843; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
            <i data-lucide="sparkles" style="width: 22px; height: 22px; color: #be185d;"></i>
            ปรัชญาของหลักสูตรดุษฎีบัณฑิต (Philosophy)
        </h3>
        <p style="color: #701a75; font-size: 0.95rem; line-height: 1.8; margin-bottom: 12px;">
            "ผลิตดุษฎีบัณฑิตให้มีความเป็นเลิศทางวิชาการด้านพระพุทธศาสนา มีความเชี่ยวชาญในการวิจัยขั้นสูง บูรณาการพุทธธรรมกับศาสตร์สากล และสามารถสร้างองค์ความรู้ใหม่เพื่อการพัฒนาจิตใจ สังคม และมนุษยชาติอย่างยั่งยืน"
        </p>
        <div style="border-top: 1px dashed #f472b6; padding-top: 12px; margin-top: 12px; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px;">
            <div style="font-size: 0.85rem; color: #831843;">
                <strong>🔬 Advanced Research:</strong> สร้างผลงานวิจัยและดุษฎีนิพนธ์ที่ตีพิมพ์ในฐานข้อมูลระดับสากล
            </div>
            <div style="font-size: 0.85rem; color: #831843;">
                <strong>📚 In-depth Tipitaka:</strong> วิเคราะห์พระไตรปิฎก อรรถกถา ฎีกา เชิงวิพากษ์และเปรียบเทียบ
            </div>
            <div style="font-size: 0.85rem; color: #831843;">
                <strong>🌐 Global Buddhist Leadership:</strong> พัฒนาภาวะผู้นำทางจิตวิญญาณและปัญญาระดับนานาชาติ
            </div>
        </div>
    </div>

    <!-- Doctoral PLOs -->
    <h3 style="font-size: 1.25rem; margin-bottom: 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="target" style="width: 20px; height: 20px; color: #be185d;"></i>
        ผลลัพธ์การเรียนรู้ของหลักสูตรดุษฎีบัณฑิต (PLOs)
    </h3>
    <div class="card-grid" style="margin-bottom: 25px;">
        <div class="info-card" style="border-left: 4px solid #be185d;">
            <strong style="color: #be185d;">PLO 1 (องค์ความรู้พุทธศาสตร์ขั้นสูง):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">สังเคราะห์และอธิบายองค์ความรู้พระไตรปิฎกและพุทธปรัชญาขั้นสูง พร้อมทั้งเชื่อมโยงกับกระแสความคิดปรัชญาสากลร่วมสมัยได้อย่างลึกซึ้ง</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #831843;">
            <strong style="color: #831843;">PLO 2 (การสร้างนวัตกรรมและความรู้ใหม่):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">ออกแบบและดำเนินงานวิจัยเชิงลึก สร้างทฤษฎีหรือองค์ความรู้ใหม่ทางพระพุทธศาสนาเพื่อแก้ไขปัญหาสังคมและมนุษยชาติ</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #0284c7;">
            <strong style="color: #0284c7;">PLO 3 (ภาวะผู้นำทางปัญญาและจริยธรรม):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">มีจริยธรรมการวิจัยระดับสากล มีความซื่อสัตย์ทางวิชาการ และแสดงออกถึงความเป็นผู้นำทางปัญญาในการชี้นำสังคม</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #059669;">
            <strong style="color: #059669;">PLO 4 (การตีพิมพ์และเผยแพร่สากล):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">สื่อสาร ถ่ายทอด และตีพิมพ์เผยแพร่ดุษฎีนิพนธ์ในวารสารวิชาการระดับชาติ (TCI กลุ่ม ๑) หรือนานาชาติ (Scopus/WoS)</p>
        </div>
    </div>

    <!-- Curriculum Structure Table (Ph.D.) -->
    <h3 style="font-size: 1.25rem; margin-bottom: 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="file-spreadsheet" style="width: 20px; height: 20px; color: #be185d;"></i>
        โครงสร้างหลักสูตรดุษฎีบัณฑิต (รวม ๔๘ หน่วยกิต)
    </h3>
    <div class="custom-table-container" style="margin-bottom: 25px;">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>หมวดวิชา</th>
                    <th style="width: 140px; text-align: center;">แบบ ๑.๑</th>
                    <th style="width: 140px; text-align: center;">แบบ ๒.๑</th>
                    <th>รายละเอียดและเงื่อนไข</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>๑. หมวดวิชาเสริมพื้นฐาน</strong></td>
                    <td style="text-align: center;">(ไม่นับหน่วยกิต)</td>
                    <td style="text-align: center;">(ไม่นับหน่วยกิต)</td>
                    <td>ภาษาบาลี / ภาษาอังกฤษ สำหรับระดับดุษฎีบัณฑิต (ประเมิน S/U)</td>
                </tr>
                <tr>
                    <td><strong>๒. หมวดวิชาบังคับ</strong></td>
                    <td style="text-align: center; color: #64748b;">-</td>
                    <td style="text-align: center; font-weight: 600; color: #be185d;">๙ หน่วยกิต</td>
                    <td>สัมมนาพระไตรปิฎกวิเคราะห์, ระเบียบวิธีวิจัยขั้นสูง, พุทธปรัชญาและศาสตร์ร่วมสมัย</td>
                </tr>
                <tr>
                    <td><strong>๓. หมวดวิชาเลือก</strong></td>
                    <td style="text-align: center; color: #64748b;">-</td>
                    <td style="text-align: center; font-weight: 600; color: #be185d;">๓ หน่วยกิต</td>
                    <td>เลือกเรียน ๑ รายวิชาจากกลุ่มสัมมนาเฉพาะทางหรือ AI กับพระพุทธศาสนา</td>
                </tr>
                <tr>
                    <td><strong>๔. ดุษฎีนิพนธ์ (Dissertation)</strong></td>
                    <td style="text-align: center; font-weight: 700; color: #831843;">๔๘ หน่วยกิต</td>
                    <td style="text-align: center; font-weight: 700; color: #831843;">๓๖ หน่วยกิต</td>
                    <td>ทำวิจัยเชิงลึก สร้างองค์ความรู้ใหม่ พร้อมตีพิมพ์เผยแพร่ตามเกณฑ์มาตรฐาน สป.อว.</td>
                </tr>
                <tr style="background: #fdf2f8; font-weight: 700;">
                    <td style="text-align: right;">รวมตลอดหลักสูตร:</td>
                    <td style="text-align: center; color: #831843; font-size: 1.05rem;">๔๘ หน่วยกิต</td>
                    <td style="text-align: center; color: #831843; font-size: 1.05rem;">๔๘ หน่วยกิต</td>
                    <td style="color: #831843;">สำเร็จการศึกษาระดับปริญญาเอก (พธ.ด.)</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Ph.D. Study Plan Details -->
    <details style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 25px; padding: 14px 18px;" open>
        <summary style="font-weight: 600; color: #831843; cursor: pointer; display: flex; align-items: center; justify-content: space-between;">
            <span>รายวิชาสัมมนาและดุษฎีนิพนธ์ (แบบ ๒.๑)</span>
            <span style="font-size: 0.8rem; background: #fdf2f8; color: #be185d; padding: 2px 8px; border-radius: 4px;">รายละเอียดวิชา</span>
        </summary>
        <div style="margin-top: 14px; font-size: 0.9rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 10px;">
                <div class="course-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);">
                    <strong>๘๐๑ ๑๐๑</strong> พระไตรปิฎกวิเคราะห์ขั้นสูง (Advanced Analysis of Tipitaka) ๓(๓-๐-๖)
                </div>
                <div class="course-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);">
                    <strong>๘๐๑ ๑๐๒</strong> ระเบียบวิธีวิจัยขั้นสูงทางพระพุทธศาสนา (Advanced Research Methodology) ๓(๓-๐-๖)
                </div>
                <div class="course-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);">
                    <strong>๘๐๑ ๑๐๓</strong> สัมมนาพุทธปรัชญาและศาสตร์ร่วมสมัย (Seminar on Buddhist Philosophy) ๓(๓-๐-๖)
                </div>
                <div class="course-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);">
                    <strong>๘๐๑ ๒๐๔</strong> สัมมนาพระพุทธศาสนากับการพัฒนาสังคมโลก (Buddhism & Global Development) ๓(๓-๐-๖)
                </div>
                <div class="course-item" style="padding: 10px 14px; background: #fdf2f8; border-radius: 6px; border: 1px solid #fbcfe8; grid-column: 1 / -1;">
                    <strong>๘๐๑ ๕๐๐</strong> ดุษฎีนิพนธ์ (Dissertation) ๓๖ หน่วยกิต (แบบ ๒.๑) / ๔๘ หน่วยกิต (แบบ ๑.๑)
                </div>
            </div>
        </div>
    </details>
</section>

<!-- =========================================================================
     PANEL 2: หลักสูตรพุทธศาสตรมหาบัณฑิต สาขาวิชาพระพุทธศาสนา (พธ.ม.)
     ========================================================================= -->
<section id="panel-master" class="curriculum-panel <?php echo ($level === 'master') ? 'active' : ''; ?>" role="tabpanel" aria-labelledby="tab-btn-master">
    <!-- Header Card -->
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); color: #ffffff; border-radius: 12px; padding: 24px; margin-bottom: 25px; border-left: 6px solid #60a5fa;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
            <div>
                <span style="background: rgba(255,255,255,0.2); color: #eff6ff; font-size: 0.8rem; font-weight: 700; padding: 3px 10px; border-radius: 15px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                    <i data-lucide="book-open" style="width: 14px; height: 14px;"></i> ระดับบัณฑิตศึกษา (ปริญญาโท)
                </span>
                <h2 style="font-size: 1.5rem; color: #ffffff; margin: 0 0 6px 0;">หลักสูตรพุทธศาสตรมหาบัณฑิต สาขาวิชาพระพุทธศาสนา</h2>
                <p style="color: #bfdbfe; margin: 0; font-size: 0.95rem;">
                    Master of Arts Program in Buddhist Studies (M.A.) | คณะพุทธศาสตร์ มจร วิทยาเขตอุบลราชธานี
                </p>
            </div>
            <a href="index.php?page=enroll&level=master" class="btn btn-primary" style="background: #2563eb; border-color: #2563eb; gap: 6px;">
                <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i> สมัครเข้าศึกษาปริญญาโท
            </a>
        </div>
    </div>

    <!-- Quick Overview Cards -->
    <div class="card-grid" style="margin-bottom: 25px;">
        <div class="info-card">
            <h3 style="font-size: 1.05rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="graduation-cap" style="width: 20px; height: 20px; color: #1d4ed8;"></i>
                ชื่อปริญญาและสาขาวิชา
            </h3>
            <p style="color: #475569; font-size: 0.9rem; line-height: 1.8;">
                <strong>ชื่อเต็ม (ไทย):</strong> พุทธศาสตรมหาบัณฑิต (พระพุทธศาสนา)<br>
                <strong>ชื่อย่อ (ไทย):</strong> พธ.ม. (พระพุทธศาสนา)<br>
                <strong>ชื่อเต็ม (อังกฤษ):</strong> Master of Arts (Buddhist Studies)<br>
                <strong>ชื่อย่อ (อังกฤษ):</strong> M.A. (Buddhist Studies)<br>
                <strong>วิชาเอก:</strong> พระพุทธศาสนา (Buddhist Studies)
            </p>
        </div>

        <div class="info-card">
            <h3 style="font-size: 1.05rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="layers" style="width: 20px; height: 20px; color: #1d4ed8;"></i>
                จำนวนหน่วยกิตและระยะเวลาศึกษา
            </h3>
            <p style="color: #475569; font-size: 0.9rem; line-height: 1.8;">
                <strong>จำนวนหน่วยกิตรวม:</strong> <span style="color: #1d4ed8; font-weight: 700; font-size: 1.1rem;">๓๖ หน่วยกิต</span><br>
                <strong>ระยะเวลาศึกษา:</strong> ๒ ปีการศึกษา (๔ ภาคการศึกษา) ไม่เกิน ๕ ปี<br>
                <strong>แผนการศึกษา:</strong> แผน ก แบบ ก ๒ (ทำวิทยานิพนธ์) และ แผน ข (สารนิพนธ์/ค้นคว้าอิสระ)<br>
                <strong>การจัดการเรียนการสอน:</strong> วันเสาร์ - วันอาทิตย์ และภาคปกติ
            </p>
        </div>
    </div>

    <!-- Philosophy & Highlights -->
    <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe; border-radius: 10px; padding: 22px; margin-bottom: 25px;">
        <h3 style="font-size: 1.25rem; color: #1e3a8a; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
            <i data-lucide="sparkles" style="width: 22px; height: 22px; color: #2563eb;"></i>
            ปรัชญาของหลักสูตรมหาบัณฑิต (Philosophy)
        </h3>
        <p style="color: #1e40af; font-size: 0.95rem; line-height: 1.8; margin-bottom: 12px;">
            "มุ่งผลิตมหาบัณฑิตให้มีความรู้ความเข้าใจในหลักธรรมทางพระพุทธศาสนาอย่างลึกซึ้ง มีทักษะการค้นคว้าวิจัยขั้นสูง และสามารถประยุกต์ใช้พุทธธรรมเพื่อแก้ไขปัญหาสังคมร่วมสมัยได้อย่างมีประสิทธิภาพและเปี่ยมด้วยคุณธรรม"
        </p>
        <div style="border-top: 1px dashed #60a5fa; padding-top: 12px; margin-top: 12px; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px;">
            <div style="font-size: 0.85rem; color: #1e3a8a;">
                <strong>📖 Systematic Tipitaka Analysis:</strong> ศึกษาพระไตรปิฎกอย่างเป็นระบบตามแนวทางคัมภีร์ดั้งเดิม
            </div>
            <div style="font-size: 0.85rem; color: #1e3a8a;">
                <strong>💡 Applied Buddhist Ethics:</strong> ประยุกต์หลักจริยธรรมพุทธเพื่อแก้ปัญหาสังคม จริยธรรมการแพทย์ และสิ่งแวดล้อม
            </div>
            <div style="font-size: 0.85rem; color: #1e3a8a;">
                <strong>📊 Research Proficiency:</strong> ทักษะการวิจัยทางวิชาการและวิทยานิพนธ์ระดับมาตรฐาน
            </div>
        </div>
    </div>

    <!-- Master PLOs -->
    <h3 style="font-size: 1.25rem; margin-bottom: 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="target" style="width: 20px; height: 20px; color: #1d4ed8;"></i>
        ผลลัพธ์การเรียนรู้ของหลักสูตรมหาบัณฑิต (PLOs)
    </h3>
    <div class="card-grid" style="margin-bottom: 25px;">
        <div class="info-card" style="border-left: 4px solid #1d4ed8;">
            <strong style="color: #1d4ed8;">PLO 1 (ความรู้ในคัมภีร์และพุทธปรัชญา):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">อธิบาย วิเคราะห์ และตีความคัมภีร์พระไตรปิฎกและพุทธปรัชญาเถรวาทได้อย่างถูกต้องตามหลักวิชาการ</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #0284c7;">
            <strong style="color: #0284c7;">PLO 2 (การวิจัยทางพระพุทธศาสนา):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">ดำเนินงานวิจัยทางพระพุทธศาสนาอย่างเป็นระบบถูกต้องตามระเบียบวิธีวิจัย และนำผลการวิจัยไปใช้ประโยชน์ได้จริง</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #059669;">
            <strong style="color: #059669;">PLO 3 (การประยุกต์ธรรมและพัฒนาสังคม):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">ประยุกต์หลักธรรมเพื่อการชี้นำทางความคิด สื่อสารธรรมะเชิงสร้างสรรค์ และเสริมสร้างสุขภาวะทางปัญญาแก่ชุมชน</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #d97706;">
            <strong style="color: #d97706;">PLO 4 (จริยธรรมวิชาการและการสื่อสาร):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">มีจรรยาบรรณของนักวิชาการ และสามารถนำเสนอผลงานวิชาการในเวทีประชุมวิชาการหรือวารสารทางวิชาการ</p>
        </div>
    </div>

    <!-- Curriculum Structure Table (Master) -->
    <h3 style="font-size: 1.25rem; margin-bottom: 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="file-spreadsheet" style="width: 20px; height: 20px; color: #1d4ed8;"></i>
        โครงสร้างหลักสูตรมหาบัณฑิต (รวม ๓๖ หน่วยกิต)
    </h3>
    <div class="custom-table-container" style="margin-bottom: 25px;">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>หมวดวิชา</th>
                    <th style="width: 140px; text-align: center;">แผน ก แบบ ก ๒</th>
                    <th style="width: 140px; text-align: center;">แผน ข</th>
                    <th>รายละเอียดและกลุ่มวิชา</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>๑. หมวดวิชาเสริมพื้นฐาน</strong></td>
                    <td style="text-align: center;">(ไม่นับหน่วยกิต)</td>
                    <td style="text-align: center;">(ไม่นับหน่วยกิต)</td>
                    <td>ภาษาบาลี / ภาษาอังกฤษ สำหรับบัณฑิตศึกษา (ประเมิน S/U)</td>
                </tr>
                <tr>
                    <td><strong>๒. หมวดวิชาบังคับ</strong></td>
                    <td style="text-align: center; font-weight: 600; color: #1d4ed8;">๑๒ หน่วยกิต</td>
                    <td style="text-align: center; font-weight: 600; color: #1d4ed8;">๑๒ หน่วยกิต</td>
                    <td>พระไตรปิฎกวิเคราะห์, วิธีวิทยาการวิจัย, พุทธปรัชญาเปรียบเทียบ, วิปัสสนากรรมฐาน</td>
                </tr>
                <tr>
                    <td><strong>๓. หมวดวิชาเลือก</strong></td>
                    <td style="text-align: center; font-weight: 600; color: #1d4ed8;">๑๒ หน่วยกิต</td>
                    <td style="text-align: center; font-weight: 600; color: #1d4ed8;">๑๘ หน่วยกิต</td>
                    <td>เลือกเรียนจากกลุ่มวิชาพุทธธรรมประยุกต์และพระพุทธศาสนากับสังคม</td>
                </tr>
                <tr>
                    <td><strong>๔. วิทยานิพนธ์ / ค้นคว้าอิสระ</strong></td>
                    <td style="text-align: center; font-weight: 700; color: #1e3a8a;">๑๒ หน่วยกิต (วิทยานิพนธ์)</td>
                    <td style="text-align: center; font-weight: 700; color: #1e3a8a;">๖ หน่วยกิต (สารนิพนธ์)</td>
                    <td>จัดทำวิทยานิพนธ์ หรือ การค้นคว้าอิสระ + สอบประมวลความรู้ (Comprehensive Exam)</td>
                </tr>
                <tr style="background: #eff6ff; font-weight: 700;">
                    <td style="text-align: right;">รวมตลอดหลักสูตร:</td>
                    <td style="text-align: center; color: #1e3a8a; font-size: 1.05rem;">๓๖ หน่วยกิต</td>
                    <td style="text-align: center; color: #1e3a8a; font-size: 1.05rem;">๓๖ หน่วยกิต</td>
                    <td style="color: #1e3a8a;">สำเร็จการศึกษาระดับปริญญาโท (พธ.ม.)</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Master Study Plan Details -->
    <details style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 25px; padding: 14px 18px;" open>
        <summary style="font-weight: 600; color: #1e3a8a; cursor: pointer; display: flex; align-items: center; justify-content: space-between;">
            <span>รายวิชาหมวดบังคับและวิทยานิพนธ์ (แผน ก แบบ ก ๒)</span>
            <span style="font-size: 0.8rem; background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 4px;">รายละเอียดวิชา</span>
        </summary>
        <div style="margin-top: 14px; font-size: 0.9rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 10px;">
                <div class="course-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);">
                    <strong>๖๐๑ ๑๐๑</strong> พระไตรปิฎกวิเคราะห์ (Analytical Study of Tipitaka) ๓(๓-๐-๖)
                </div>
                <div class="course-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);">
                    <strong>๖๐๑ ๑๐๒</strong> วิธีวิทยาการวิจัยทางพระพุทธศาสนา (Research Methodology) ๓(๓-๐-๖)
                </div>
                <div class="course-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);">
                    <strong>๖๐๑ ๑๐๓</strong> พุทธปรัชญาเปรียบเทียบ (Comparative Buddhist Philosophy) ๓(๓-๐-๖)
                </div>
                <div class="course-item" style="padding: 10px 14px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);">
                    <strong>๖๐๑ ๑๐๔</strong> การปฏิบัติวิปัสสนากรรมฐานขั้นสูง (Advanced Vipassana Practice) ๓(๒-๒-๕)
                </div>
                <div class="course-item" style="padding: 10px 14px; background: #eff6ff; border-radius: 6px; border: 1px solid #bfdbfe; grid-column: 1 / -1;">
                    <strong>๖๐๑ ๓๐๐</strong> วิทยานิพนธ์ (Thesis) ๑๒ หน่วยกิต (แผน ก) / <strong>๖๐๑ ๓๐๑</strong> สารนิพนธ์ ๖ หน่วยกิต (แผน ข)
                </div>
            </div>
        </div>
    </details>
</section>

<!-- =========================================================================
     PANEL 3: หลักสูตรพุทธศาสตรบัณฑิต สาขาวิชาพระพุทธศาสนา (พธ.บ.)
     ========================================================================= -->
<section id="panel-bachelor" class="curriculum-panel <?php echo ($level === 'bachelor') ? 'active' : ''; ?>" role="tabpanel" aria-labelledby="tab-btn-bachelor">
    <!-- Header Card -->
    <div style="background: linear-gradient(135deg, #78350f 0%, #451a03 100%); color: #ffffff; border-radius: 12px; padding: 24px; margin-bottom: 25px; border-left: 6px solid #fbbf24;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
            <div>
                <span style="background: rgba(255,255,255,0.2); color: #fef3c7; font-size: 0.8rem; font-weight: 700; padding: 3px 10px; border-radius: 15px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                    <i data-lucide="award" style="width: 14px; height: 14px;"></i> ระดับปริญญาตรี (มคอ.๒ ปรับปรุง ๒๕๗๐)
                </span>
                <h2 style="font-size: 1.5rem; color: #ffffff; margin: 0 0 6px 0;">หลักสูตรพุทธศาสตรบัณฑิต สาขาวิชาพระพุทธศาสนา</h2>
                <p style="color: #fde68a; margin: 0; font-size: 0.95rem;">
                    Bachelor of Arts Program in Buddhist Studies (B.A.) | คณะพุทธศาสตร์ มจร วิทยาเขตอุบลราชธานี
                </p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="มจร.วิทยาเขตอุบลราชธานี มคอ.2 สาขาวิชาพระพุทธศาสนา ปรับปรุง ๒๕๗๐.pdf" target="_blank" class="btn btn-outline" style="border-color: #fbbf24; color: #fbbf24; gap: 6px;">
                    <i data-lucide="download" style="width: 16px; height: 16px;"></i> เล่ม มคอ.๒ (PDF)
                </a>
                <a href="index.php?page=enroll&level=bachelor" class="btn btn-primary" style="background: #d97706; border-color: #d97706; gap: 6px;">
                    <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i> สมัครเข้าศึกษาปริญญาตรี
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Overview Cards -->
    <div class="card-grid" style="margin-bottom: 25px;">
        <div class="info-card">
            <h3 style="font-size: 1.05rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="graduation-cap" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
                ชื่อปริญญาและสาขาวิชา
            </h3>
            <p style="color: #475569; font-size: 0.9rem; line-height: 1.8;">
                <strong>ชื่อเต็ม (ไทย):</strong> พุทธศาสตรบัณฑิต (พระพุทธศาสนา)<br>
                <strong>ชื่อย่อ (ไทย):</strong> พธ.บ. (พระพุทธศาสนา)<br>
                <strong>ชื่อเต็ม (อังกฤษ):</strong> Bachelor of Arts (Buddhist Studies)<br>
                <strong>ชื่อย่อ (อังกฤษ):</strong> B.A. (Buddhist Studies)<br>
                <strong>วิชาเอก:</strong> พระพุทธศาสนา (Buddhist Studies)
            </p>
        </div>

        <div class="info-card">
            <h3 style="font-size: 1.05rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i data-lucide="layers" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
                จำนวนหน่วยกิตและระยะเวลาศึกษา
            </h3>
            <p style="color: #475569; font-size: 0.9rem; line-height: 1.8;">
                <strong>จำนวนหน่วยกิตรวม:</strong> <span style="color: var(--primary-color); font-weight: 700; font-size: 1.1rem;">๑๓๒ หน่วยกิต</span><br>
                <strong>ระยะเวลาศึกษา:</strong> ๔ ปีการศึกษา (ระบบทวิภาค)<br>
                <strong>การจัดการเรียนการสอน:</strong> ในเวลาราชการ และ นอกเวลาราชการ (เสาร์-อาทิตย์)<br>
                <strong>รูปแบบการศึกษา:</strong> ชั้นเรียน (Onsite) ควบคู่ทางไกลอินเทอร์เน็ต (Online)
            </p>
        </div>
    </div>

    <!-- Philosophy & Highlights according to TQF 2 -->
    <div style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fde68a; border-radius: 10px; padding: 22px; margin-bottom: 25px;">
        <h3 style="font-size: 1.25rem; color: #92400e; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
            <i data-lucide="sparkles" style="width: 22px; height: 22px; color: #b45309;"></i>
            ปรัชญาของหลักสูตรบัณฑิต (มคอ.๒ ๒๕๗๐)
        </h3>
        <p style="color: #78350f; font-size: 0.95rem; line-height: 1.8; margin-bottom: 12px;">
            "จัดการศึกษาพระพุทธศาสนาประยุกต์กับศาสตร์สมัยใหม่ เพื่อผลิตบัณฑิตให้มีความรู้ มีคุณธรรม มีทักษะการใช้เทคโนโลยีดิจิทัลและปัญญาประดิษฐ์ (AI) ในการเผยแผ่พระพุทธศาสนา เพื่อพัฒนาจิตใจและสังคมอย่างยั่งยืน"
        </p>
        <div style="border-top: 1px dashed #d97706; padding-top: 12px; margin-top: 12px; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px;">
            <div style="font-size: 0.85rem; color: #92400e;">
                <strong>🌟 Interdisciplinary Integration:</strong> บูรณาการพุทธธรรมกับวิทยาศาสตร์ สังคมศาสตร์ และจิตวิทยา
            </div>
            <div style="font-size: 0.85rem; color: #92400e;">
                <strong>🤖 Buddhist Innovators & AI:</strong> สร้างพุทธนวัตกรและประยุกต์ใช้ AI ในการเผยแผ่
            </div>
            <div style="font-size: 0.85rem; color: #92400e;">
                <strong>🧘 Practical Meditation:</strong> ฝึกวิปัสสนากัมมัฏฐานเข้มข้นต่อเนื่อง ๔ ปี (กรรมฐาน ๑-๔)
            </div>
            <div style="font-size: 0.85rem; color: #92400e;">
                <strong>🪔 Local Wisdom:</strong> อารยธรรมลุ่มน้ำโขง-ชี-มูล และภูมิปัญญาเทียนพรรษาศึกษา
            </div>
        </div>
    </div>

    <!-- Program Learning Outcomes (PLOs) -->
    <h3 style="font-size: 1.25rem; margin-bottom: 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="target" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
        ผลลัพธ์การเรียนรู้ที่คาดหวังของหลักสูตรบัณฑิต (PLOs) ตาม มคอ.๒
    </h3>
    <div class="card-grid" style="margin-bottom: 25px;">
        <div class="info-card" style="border-left: 4px solid #b45309;">
            <strong style="color: var(--primary-color);">PLO 1 (บูรณาการศาสตร์):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">ประยุกต์ใช้หลักพุทธธรรมและองค์ความรู้ทางพระพุทธศาสนาร่วมกับศาสตร์สมัยใหม่ ในการอธิบายและรับมือกับสถานการณ์ทางสังคมร่วมสมัย</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #1e3a8a;">
            <strong style="color: var(--secondary-color);">PLO 2 (การสื่อสารเผยแผ่):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">ดำเนินกระบวนการสื่อสารพุทธธรรมประยุกต์อย่างถูกต้อง สอดคล้องกับบริบทของสังคมและกลุ่มเป้าหมายที่หลากหลาย เพื่อการเผยแผ่และแก้ไขปัญหาสังคม</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #059669;">
            <strong style="color: #059669;">PLO 3 (จริยธรรมพุทธ):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">ยึดมั่นและปฏิบัติตนตามหลักจริยธรรมพุทธศาสน์อย่างสม่ำเสมอ พร้อมทั้งแสดงความรับผิดชอบต่อตนเอง สังคม และการดำเนินชีวิตประจำวัน</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #7c3aed;">
            <strong style="color: #7c3aed;">PLO 4 (ภาวะผู้นำ & พหุวัฒนธรรม):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">แสดงภาวะผู้นำและทำงานร่วมกับผู้อื่นในสังคมที่มีความหลากหลาย ด้วยความเคารพในความแตกต่าง เพื่อสร้างความร่วมมือและพัฒนาตนเองตลอดชีวิต</p>
        </div>
        <div class="info-card" style="border-left: 4px solid #d97706; grid-column: 1 / -1;">
            <strong style="color: #d97706;">PLO 5 (เทคโนโลยีดิจิทัล & พุทธนวัตกรรม):</strong>
            <p style="font-size: 0.875rem; color: #475569; margin-top: 4px;">ประยุกต์ใช้เทคโนโลยีดิจิทัล สารสนเทศ ปัญญาประดิษฐ์ (AI) และพุทธนวัตกรรม ในการสืบค้น สื่อสาร และเผยแผ่พระพุทธศาสนาอย่างถูกต้องและมีจริยธรรม</p>
        </div>
    </div>

    <!-- Curriculum Structure Table (Bachelor) -->
    <h3 style="font-size: 1.25rem; margin-bottom: 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="file-spreadsheet" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
        โครงสร้างหลักสูตรบัณฑิต (จำนวนหน่วยกิตรวม ๑๓๒ หน่วยกิต)
    </h3>
    <div class="custom-table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>หมวดวิชา</th>
                    <th style="width: 150px; text-align: center;">จำนวนหน่วยกิต</th>
                    <th>รายละเอียดกลุ่มวิชา</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background: #f8fafc;">
                    <td><strong>๑. หมวดวิชาศึกษาทั่วไป</strong></td>
                    <td style="text-align: center; font-weight: 600; color: var(--secondary-color);">๒๔ หน่วยกิต</td>
                    <td>
                        - วิชาบังคับ ๑๘ หน่วยกิต<br>
                        - วิชาเลือก ๖ หน่วยกิต
                    </td>
                </tr>
                <tr style="background: #ffffff;">
                    <td><strong>๒. หมวดวิชาเฉพาะ</strong></td>
                    <td style="text-align: center; font-weight: 600; color: var(--primary-color);">๑๐๒ หน่วยกิต</td>
                    <td>
                        - ๒.๑ วิชากลุ่มพระพุทธศาสนา (๓๐ หน่วยกิต)<br>
                        - ๒.๒ วิชาแกนพระพุทธศาสนา (๓๓ หน่วยกิต)<br>
                        - ๒.๓ วิชาเฉพาะด้านพระพุทธศาสนา (๓๓ หน่วยกิต)<br>
                        - ๒.๔ วิชาเลือกเฉพาะสาขาพระพุทธศาสนา (๖ หน่วยกิต)
                    </td>
                </tr>
                <tr style="background: #f8fafc;">
                    <td><strong>๓. หมวดวิชาเลือกเสรี</strong></td>
                    <td style="text-align: center; font-weight: 600; color: #059669;">๖ หน่วยกิต</td>
                    <td>เลือกเรียนรายวิชาใดๆ ที่เปิดสอนในมหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย</td>
                </tr>
                <tr style="background: #fef3c7; font-weight: 700;">
                    <td style="text-align: right;">รวมตลอดหลักสูตร</td>
                    <td style="text-align: center; color: #92400e; font-size: 1.05rem;">๑๓๒ หน่วยกิต</td>
                    <td style="color: #92400e;">สำเร็จการศึกษาตามเกณฑ์ มคอ.๒</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Detailed Courses by Category -->
    <h3 style="font-size: 1.25rem; margin-top: 30px; margin-bottom: 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="book-marked" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
        บัญชีรายวิชาในหลักสูตรตาม มคอ.๒
    </h3>

    <!-- Live Course Search Box (AAA Usability Feature) -->
    <div class="search-box-wrapper" style="margin-bottom: 20px;">
        <i data-lucide="search" class="search-box-icon" style="width: 20px; height: 20px;"></i>
        <input type="text" id="courseSearchInput" class="form-control" placeholder="พิมพ์ค้นหารหัสวิชา หรือชื่อวิชา เช่น AI, พระไตรปิฎก, บาลี, กรรมฐาน, เทียนพรรษา, มนุษย์..." aria-label="ค้นหารายวิชาในหลักสูตรตาม มคอ.๒">
        <div id="courseSearchResultCount" style="display: none; margin-top: 6px; font-size: 0.85rem; color: var(--primary-color); font-weight: 600;"></div>
    </div>

    <!-- Group 1: General Education -->
    <details style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 12px; padding: 12px 18px;" open>
        <summary style="font-weight: 600; color: var(--secondary-color); cursor: pointer; display: flex; align-items: center; justify-content: space-between;">
            <span>๑. หมวดวิชาศึกษาทั่วไป (๒๔ หน่วยกิต)</span>
            <span style="font-size: 0.8rem; background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 4px;">วิชาบังคับ ๑๘ นก. + วิชาเลือก ๖ นก.</span>
        </summary>
        <div style="margin-top: 12px; font-size: 0.9rem;">
            <strong style="color: var(--primary-color);">๑.๑ วิชาบังคับ (๑๘ หน่วยกิต):</strong>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 8px; margin: 8px 0 16px 0;">
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๑๐๑</strong> มนุษย์กับสังคม ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๑๐๒</strong> กฎหมายทั่วไป ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๑๐๓</strong> คอมพิวเตอร์และเทคโนโลยีดิจิทัล ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๒๐๔</strong> ภาษาอังกฤษเพื่อการสื่อสาร ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๒๐๕</strong> ปรัชญาเบื้องต้น ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๒๐๖</strong> คณิตศาสตร์และสถิติเพื่อการวิจัย ๓(๓-๐-๖)</div>
            </div>
            <strong style="color: var(--primary-color);">๑.๒ ตัวอย่างวิชาเลือกศึกษาทั่วไป (เลือกเรียน ๖ หน่วยกิต):</strong>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 8px; margin-top: 8px;">
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๑๐๙</strong> จิตวิทยาเพื่อการพัฒนาตน ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๑๑๒</strong> วิทยาศาสตร์และเทคโนโลยีสมัยใหม่ ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๒๒๘</strong> สันติศึกษา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๒๓๑</strong> การรู้เท่าทันสื่อ ๓(๓-๐-๖)</div>
            </div>
        </div>
    </details>

    <!-- Group 2: Buddhist Group Courses -->
    <details style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 12px; padding: 12px 18px;" open>
        <summary style="font-weight: 600; color: var(--secondary-color); cursor: pointer; display: flex; align-items: center; justify-content: space-between;">
            <span>๒.๑ วิชากลุ่มพระพุทธศาสนา (๓๐ หน่วยกิต)</span>
            <span style="font-size: 0.8rem; background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px;">วิชาบังคับพื้นฐาน มจร</span>
        </summary>
        <div style="margin-top: 12px; font-size: 0.9rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 8px;">
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๑๓๔</strong> วรรณกรรมพระพุทธศาสนา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๑๓๕</strong> พระไตรปิฎกศึกษา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๑๓๖</strong> ภาษาบาลี ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๒๓๗</strong> ประวัติพระพุทธศาสนา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๒๓๘</strong> เทศกาลและพิธีกรรมพระพุทธศาสนา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๐๐๐ ๒๓๙</strong> ธรรมะภาคภาษาอังกฤษ ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 6px;"><strong>๐๐๐ ๑๔๐</strong> กรรมฐาน ๑ ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 6px;"><strong>๐๐๐ ๒๔๑</strong> กรรมฐาน ๒ ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 6px;"><strong>๐๐๐ ๓๔๒</strong> กรรมฐาน ๓ ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 6px;"><strong>๐๐๐ ๔๔๓</strong> กรรมฐาน ๔ ๓(๒-๒-๕)</div>
            </div>
        </div>
    </details>

    <!-- Group 3: Core Major Courses -->
    <details style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 12px; padding: 12px 18px;" open>
        <summary style="font-weight: 600; color: var(--secondary-color); cursor: pointer; display: flex; align-items: center; justify-content: space-between;">
            <span>๒.๒ วิชาแกนพระพุทธศาสนา (๓๓ หน่วยกิต)</span>
            <span style="font-size: 0.8rem; background: #fce7f3; color: #9d174d; padding: 2px 8px; border-radius: 4px;">วิชาแกนหลักสูตร</span>
        </summary>
        <div style="margin-top: 12px; font-size: 0.9rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 8px;">
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๑๑</strong> หลักพุทธธรรม ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๑๒</strong> พุทธปรัชญาเถรวาท ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๑๓</strong> ธรรมบทศึกษา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๑๔</strong> วิสุทธิมรรคศึกษา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๑๕</strong> ชาดกศึกษา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๑๖</strong> พระพุทธศาสนามหายาน ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๔๑๗</strong> พุทธศิลปกรรม ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๔๑๘</strong> ภาษาอังกฤษสำหรับพระพุทธศาสนา ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๔๑๙</strong> มังคลัตถทีปนีศึกษา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๔๒๐</strong> การศึกษาอิสระทางพระพุทธศาสนา ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๔๒๑</strong> สัมมนาพระพุทธศาสนา ๓(๒-๒-๕)</div>
            </div>
        </div>
    </details>

    <!-- Group 4: Specific/Applied Buddhism Courses -->
    <details style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 12px; padding: 12px 18px;" open>
        <summary style="font-weight: 600; color: var(--secondary-color); cursor: pointer; display: flex; align-items: center; justify-content: space-between;">
            <span>๒.๓ วิชาเฉพาะด้านพระพุทธศาสนาประยุกต์ & AI (๓๓ หน่วยกิต)</span>
            <span style="font-size: 0.8rem; background: #dcfce7; color: #15803d; padding: 2px 8px; border-radius: 4px;">วิชาเอกบังคับสมัยใหม่</span>
        </summary>
        <div style="margin-top: 12px; font-size: 0.9rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 8px;">
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๑๐๑</strong> พระพุทธศาสนากับวิทยาศาสตร์ ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๑๐๒</strong> พระพุทธศาสนากับสังคมสงเคราะห์ ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๑๐๓</strong> นิเทศศาสตร์ในพระไตรปิฎก ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๑๐๔</strong> ศึกษาศาสตร์ในพระไตรปิฎก ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๒๐๕</strong> พระพุทธศาสนากับนิเวศวิทยา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๒๐๖</strong> จิตวิทยาในพระไตรปิฎก ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๐๗</strong> รัฐศาสตร์ในพระไตรปิฎก ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๐๘</strong> พระพุทธศาสนากับสิทธิมนุษยชน ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๐๙</strong> พระพุทธศาสนากับการพัฒนาที่ยั่งยืน ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #ecfdf5; border: 1.5px solid #10b981; border-radius: 6px;"><strong>๑๐๑ ๓๑๐</strong> พระพุทธศาสนากับเทคโนโลยีปัญญาประดิษฐ์ (AI) ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #ecfdf5; border: 1.5px solid #10b981; border-radius: 6px;"><strong>๑๐๑ ๓๒๑/๓๓๑</strong> พุทธนวัตกรรมเพื่อการเผยแผ่พระพุทธศาสนา ๓(๒-๒-๕)</div>
            </div>
        </div>
    </details>

    <!-- Group 5: Major Electives & Local Wisdom -->
    <details style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 25px; padding: 12px 18px;">
        <summary style="font-weight: 600; color: var(--secondary-color); cursor: pointer; display: flex; align-items: center; justify-content: space-between;">
            <span>๒.๔ วิชาเลือกเฉพาะสาขา & ภูมิปัญญาท้องถิ่น (เลือกเรียน ๖ หน่วยกิต)</span>
            <span style="font-size: 0.8rem; background: #ede9fe; color: #6d28d9; padding: 2px 8px; border-radius: 4px;">อัตลักษณ์อีสานใต้</span>
        </summary>
        <div style="margin-top: 12px; font-size: 0.9rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 8px;">
                <div class="course-item" style="padding: 8px 12px; background: #fffbeb; border-radius: 6px; border: 1px solid #fde68a;"><strong>๑๐๑ ๓๙๘</strong> ภูมิปัญญาท้องถิ่นเทียนพรรษาศึกษา ๓(๑-๒-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #fffbeb; border-radius: 6px; border: 1px solid #fde68a;"><strong>๑๐๑ xxx</strong> อารยธรรมชุมชนโบราณลุ่มน้ำโขง-ชี-มูลศึกษา ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๒๒</strong> เปรียบเทียบพระพุทธศาสนาเถรวาทกับมหายาน ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๒๓</strong> พระพุทธศาสนากับสังคมไทย ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๓๒๖</strong> พระพุทธศาสนากับสันติภาพ ๓(๓-๐-๖)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๔๓๒</strong> พระพุทธศาสนากับศาสตร์พระราชา ๓(๒-๒-๕)</div>
                <div class="course-item" style="padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--border-color);"><strong>๑๐๑ ๔๓๔</strong> ประวัติศาสตร์พระพุทธศาสนาในประเทศไทย ๓(๓-๐-๖)</div>
            </div>
        </div>
    </details>

    <!-- 4-Year Study Plan -->
    <h3 style="font-size: 1.25rem; margin-bottom: 15px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="calendar-range" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
        แผนการศึกษาตลอดหลักสูตร ๔ ปี (Study Plan)
    </h3>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 16px; margin-bottom: 30px;">
        <!-- Year 1 -->
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; padding: 16px;">
            <h4 style="font-size: 1rem; color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 6px; margin-bottom: 10px;">
                ชั้นปีที่ ๑ (รวม ๓๖ หน่วยกิต)
            </h4>
            <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">ภาคการศึกษาที่ ๑ (๑๘ หน่วยกิต):</p>
            <ul style="font-size: 0.8rem; color: #475569; margin-left: 18px; line-height: 1.6; margin-bottom: 10px;">
                <li>๐๐๐ ๑๐๑ มนุษย์กับสังคม (๓)</li>
                <li>๐๐๐ ๑๐๒ กฎหมายทั่วไป (๓)</li>
                <li>๐๐๐ xxx วิชาเลือกศึกษาทั่วไป (๓)</li>
                <li>๐๐๐ ๑๓๖ ภาษาบาลี (๓)</li>
                <li>๐๐๐ ๑๔๐ กรรมฐาน ๑ (๓)</li>
                <li>๑๐๑ ๓๑๑ หลักพุทธธรรม (๓)</li>
            </ul>
            <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">ภาคการศึกษาที่ ๒ (๑๘ หน่วยกิต):</p>
            <ul style="font-size: 0.8rem; color: #475569; margin-left: 18px; line-height: 1.6;">
                <li>๐๐๐ ๒๐๖ คณิตศาสตร์และสถิติเพื่อการวิจัย (๓)</li>
                <li>๐๐๐ xxx วิชาเลือกศึกษาทั่วไป (๓)</li>
                <li>๐๐๐ ๒๓๗ ประวัติพระพุทธศาสนา (๓)</li>
                <li>๐๐๐ ๒๓๙ ธรรมะภาคภาษาอังกฤษ (๓)</li>
                <li>๑๐๑ ๓๑๕ ชาดกศึกษา (๓)</li>
                <li>๑๐๑ ๑๐๑ พระพุทธศาสนากับวิทยาศาสตร์ (๓)</li>
            </ul>
        </div>

        <!-- Year 2 -->
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; padding: 16px;">
            <h4 style="font-size: 1rem; color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 6px; margin-bottom: 10px;">
                ชั้นปีที่ ๒ (รวม ๓๖ หน่วยกิต)
            </h4>
            <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">ภาคการศึกษาที่ ๑ (๑๘ หน่วยกิต):</p>
            <ul style="font-size: 0.8rem; color: #475569; margin-left: 18px; line-height: 1.6; margin-bottom: 10px;">
                <li>๐๐๐ ๑๐๓ คอมพิวเตอร์และเทคโนโลยีดิจิทัล (๓)</li>
                <li>๐๐๐ ๒๐๔ ภาษาอังกฤษเพื่อการสื่อสาร (๓)</li>
                <li>๐๐๐ ๒๓๘ เทศกาลและพิธีกรรมพระพุทธศาสนา (๓)</li>
                <li>๐๐๐ ๒๔๑ กรรมฐาน ๒ (๓)</li>
                <li>๑๐๑ ๓๑๓ ธรรมบทศึกษา (๓)</li>
                <li>๑๐๑ ๑๐๒ พระพุทธศาสนากับสังคมสงเคราะห์ (๓)</li>
            </ul>
            <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">ภาคการศึกษาที่ ๒ (๑๘ หน่วยกิต):</p>
            <ul style="font-size: 0.8rem; color: #475569; margin-left: 18px; line-height: 1.6;">
                <li>๐๐๐ ๒๐๕ ปรัชญาเบื้องต้น (๓)</li>
                <li>๐๐๐ ๑๓๕ พระไตรปิฎกศึกษา (๓)</li>
                <li>๐๐๐ ๑๓๔ วรรณกรรมพระพุทธศาสนา (๓)</li>
                <li>๑๐๑ ๔๑๙ มังคลัตถทีปนีศึกษา (๓)</li>
                <li>๑๐๑ ๒๐๖ จิตวิทยาในพระไตรปิฎก (๓)</li>
                <li>๑๐๑ ๓๐๗ รัฐศาสตร์ในพระไตรปิฎก (๓)</li>
            </ul>
        </div>

        <!-- Year 3 -->
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; padding: 16px;">
            <h4 style="font-size: 1rem; color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 6px; margin-bottom: 10px;">
                ชั้นปีที่ ๓ (รวม ๓๓ หน่วยกิต)
            </h4>
            <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">ภาคการศึกษาที่ ๑ (๑๘ หน่วยกิต):</p>
            <ul style="font-size: 0.8rem; color: #475569; margin-left: 18px; line-height: 1.6; margin-bottom: 10px;">
                <li>๐๐๐ ๓๔๒ กรรมฐาน ๓ (๓)</li>
                <li>๑๐๑ ๓๑๒ พุทธปรัชญาเถรวาท (๓)</li>
                <li>๑๐๑ ๓๑๔ วิสุทธิมรรคศึกษา (๓)</li>
                <li>๑๐๑ ๒๐๕ พระพุทธศาสนากับนิเวศวิทยา (๓)</li>
                <li>๑๐๑ ๓๐๘ พระพุทธศาสนากับสิทธิมนุษยชน (๓)</li>
                <li>๑๐๑ xxx วิชาเลือกเฉพาะสาขา (๓)</li>
            </ul>
            <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">ภาคการศึกษาที่ ๒ (๑๕ หน่วยกิต):</p>
            <ul style="font-size: 0.8rem; color: #475569; margin-left: 18px; line-height: 1.6;">
                <li>๑๐๑ ๓๑๖ พระพุทธศาสนามหายาน (๓)</li>
                <li>๑๐๑ ๑๐๔ ศึกษาศาสตร์ในพระไตรปิฎก (๓)</li>
                <li>๑๐๑ ๓๐๙ พระพุทธศาสนากับการพัฒนาที่ยั่งยืน (๓)</li>
                <li><strong>๑๐๑ ๓๑๐ พระพุทธศาสนากับ AI (๓)</strong></li>
                <li>๑๐๑ xxx วิชาเลือกเฉพาะสาขา (๓)</li>
            </ul>
        </div>

        <!-- Year 4 -->
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; padding: 16px;">
            <h4 style="font-size: 1rem; color: var(--primary-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 6px; margin-bottom: 10px;">
                ชั้นปีที่ ๔ (รวม ๒๗ หน่วยกิต)
            </h4>
            <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">ภาคการศึกษาที่ ๑ (๑๕ หน่วยกิต):</p>
            <ul style="font-size: 0.8rem; color: #475569; margin-left: 18px; line-height: 1.6; margin-bottom: 10px;">
                <li>๐๐๐ ๔๔๓ กรรมฐาน ๔ (๓)</li>
                <li>๑๐๑ ๔๑๘ ภาษาอังกฤษสำหรับพระพุทธศาสนา (๓)</li>
                <li>๑๐๑ ๑๐๓ นิเทศศาสตร์ในพระไตรปิฎก (๓)</li>
                <li><strong>๑๐๑ ๓๒๑/๓๓๑ พุทธนวัตกรรมเพื่อการเผยแผ่ (๓)</strong></li>
                <li>xxx xxx วิชาเลือกเสรี (๓)</li>
            </ul>
            <p style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">ภาคการศึกษาที่ ๒ (๑๒ หน่วยกิต):</p>
            <ul style="font-size: 0.8rem; color: #475569; margin-left: 18px; line-height: 1.6;">
                <li>๑๐๑ ๔๑๗ พุทธศิลปกรรม (๓)</li>
                <li>๑๐๑ ๔๒๐ การศึกษาอิสระทางพระพุทธศาสนา (๓)</li>
                <li>๑๐๑ ๔๒๑ สัมมนาพระพุทธศาสนา (๓)</li>
                <li>xxx xxx วิชาเลือกเสรี (๓)</li>
            </ul>
        </div>
    </div>

    <!-- Career Opportunities according to TQF 2 -->
    <h3 style="font-size: 1.25rem; margin-bottom: 12px; color: var(--secondary-color); display: flex; align-items: center; gap: 8px;">
        <i data-lucide="briefcase" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
        อาชีพที่สามารถประกอบได้หลังสำเร็จการศึกษาตาม มคอ.๒
    </h3>
    <div class="card-grid">
        <div class="info-card">
            <h4 style="color: var(--primary-color); margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                <i data-lucide="compass" style="width: 16px; height: 16px;"></i> ฝ่ายศาสนกิจและการเผยแผ่
            </h4>
            <p style="font-size: 0.875rem; color: #475569; line-height: 1.7;">พระสังฆาธิการ, พระธรรมทูต, เจ้าอาวาส, พระวิทยากรบรรยายธรรม, พระวิปัสสนาจารย์, พุทธนวัตกรด้านสื่อธรรมะ</p>
        </div>
        <div class="info-card">
            <h4 style="color: var(--primary-color); margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                <i data-lucide="book-open-check" style="width: 16px; height: 16px;"></i> ฝ่ายวิชาการและการศึกษา
            </h4>
            <p style="font-size: 0.875rem; color: #475569; line-height: 1.7;">ครู อาจารย์สอนวิชาพระพุทธศาสนาและสังคมศึกษา, นักวิชาการศาสนา, นักวิจัยทางพระพุทธศาสนาและปรัชญา</p>
        </div>
        <div class="info-card">
            <h4 style="color: var(--primary-color); margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                <i data-lucide="building-2" style="width: 16px; height: 16px;"></i> ฝ่ายพัฒนาสังคมและองค์กร
            </h4>
            <p style="font-size: 0.875rem; color: #475569; line-height: 1.7;">นักพัฒนาชุมชน, เจ้าหน้าที่องค์กรสาธารณประโยชน์ (NGOs), ผู้ปฏิบัติงานในสำนักงานพระพุทธศาสนาแห่งชาติและกรมการศาสนา</p>
        </div>
    </div>
</section>

<!-- =========================================================================
     JavaScript for Reactive Degree Level Tab Switching & Course Search
     ========================================================================= -->
<script>
function switchCurriculumLevel(lvl, evt) {
    if (evt) {
        evt.preventDefault();
    }

    var validLevels = ['phd', 'master', 'bachelor'];
    if (validLevels.indexOf(lvl) === -1) {
        lvl = 'bachelor';
    }

    // Toggle panels
    validLevels.forEach(function(item) {
        var panel = document.getElementById('panel-' + item);
        var btn = document.getElementById('tab-btn-' + item);
        if (panel) {
            if (item === lvl) {
                panel.classList.add('active');
            } else {
                panel.classList.remove('active');
            }
        }
        if (btn) {
            if (item === lvl) {
                btn.classList.add('active');
                btn.setAttribute('aria-selected', 'true');
            } else {
                btn.classList.remove('active');
                btn.setAttribute('aria-selected', 'false');
            }
        }
    });

    // Update URL history without reloading
    if (window.history && window.history.pushState) {
        var newUrl = 'index.php?page=product&level=' + lvl;
        window.history.pushState({ level: lvl }, '', newUrl);
    }

    // Re-init lucide icons for newly displayed panel
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
}

// Live course search for Bachelor's curriculum
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('courseSearchInput');
    var resultCount = document.getElementById('courseSearchResultCount');
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        var term = this.value.trim().toLowerCase();
        var courseItems = document.querySelectorAll('#panel-bachelor .course-item');
        var matched = 0;

        if (term === '') {
            courseItems.forEach(function(item) {
                item.style.display = '';
                item.style.background = '';
            });
            if (resultCount) resultCount.style.display = 'none';
            return;
        }

        courseItems.forEach(function(item) {
            var text = item.textContent.toLowerCase();
            if (text.indexOf(term) !== -1) {
                item.style.display = '';
                item.style.background = '#fef3c7';
                matched++;
            } else {
                item.style.display = 'none';
            }
        });

        if (resultCount) {
            resultCount.style.display = 'block';
            resultCount.textContent = 'พบรายวิชาที่ตรงกัน ' + matched + ' วิชา';
        }
    });
});
</script>
