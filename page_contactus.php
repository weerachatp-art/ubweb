<?php
/**
 * หน้าติดต่อเรา (Contact Us)
 * สาขาวิชาพระพุทธศาสนา คณะพุทธศาสตร์ มจร วิทยาเขตอุบลราชธานี
 * รองรับมาตรฐาน WCAG 2.1/2.2 AAA
 */

$is_vercel = !empty($_ENV['VERCEL']) || !empty($_SERVER['VERCEL']);
$msg_dir = $is_vercel ? sys_get_temp_dir() . '/data' : __DIR__ . '/data';
if (!is_dir($msg_dir)) {
    @mkdir($msg_dir, 0777, true);
}
$msg_file = $msg_dir . '/messages.json';
if ($is_vercel && !file_exists($msg_file) && file_exists(__DIR__ . '/data/messages.json')) {
    @copy(__DIR__ . '/data/messages.json', $msg_file);
}

$contact_success = '';
$contact_error = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_contact') {
    $sender_name    = trim($_POST['sender_name'] ?? '');
    $sender_contact = trim($_POST['sender_contact'] ?? '');
    $sender_subject = trim($_POST['sender_subject'] ?? 'general');
    $sender_message = trim($_POST['sender_message'] ?? '');

    if (empty($sender_name) || empty($sender_contact) || empty($sender_message)) {
        $contact_error = 'กรุณากรอกข้อมูลให้ครบถ้วนทุกช่อง (ชื่อ-ฉายา, เบอร์โทร/อีเมล, และข้อความ)';
    } else {
        $existing = [];
        if (file_exists($msg_file)) {
            $raw = @file_get_contents($msg_file);
            $existing = json_decode($raw, true) ?: [];
        }

        $ref_code = 'MCU-MSG-' . date('Ymd') . '-' . sprintf('%03d', count($existing) + 1);

        $new_msg = [
            'ref_code'   => $ref_code,
            'name'       => $sender_name,
            'contact'    => $sender_contact,
            'subject'    => $sender_subject,
            'message'    => $sender_message,
            'created_at' => date('Y-m-d H:i:s'),
            'status'     => 'unread'
        ];

        $existing[] = $new_msg;
        @file_put_contents($msg_file, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

        $contact_success = "ส่งข้อความติดต่อเรียบร้อยแล้ว! เจ้าหน้าที่จะติดต่อกลับโดยเร็วที่สุด (รหัสอ้างอิง: <strong>{$ref_code}</strong>)";
    }
}
?>

<div class="page-header-card">
    <div>
        <h1>ติดต่อคณะพุทธศาสตร์</h1>
        <p style="color: #64748b; margin-top: 4px;">มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี</p>
    </div>
    <span class="page-header-badge" style="display: inline-flex; align-items: center; gap: 6px;">
        <i data-lucide="phone-call" style="width: 15px; height: 15px;"></i> ติดต่อสอบถาม
    </span>
</div>

<?php if (!empty($contact_success)): ?>
    <div role="alert" style="background: #dcfce7; border-left: 5px solid #16a34a; color: #14532d; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i data-lucide="check-circle-2" style="width: 24px; height: 24px; color: #16a34a; flex-shrink: 0;"></i>
        <div><?php echo $contact_success; ?></div>
    </div>
<?php endif; ?>

<?php if (!empty($contact_error)): ?>
    <div role="alert" style="background: #fee2e2; border-left: 5px solid #dc2626; color: #7f1d1d; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i data-lucide="alert-triangle" style="width: 24px; height: 24px; color: #dc2626; flex-shrink: 0;"></i>
        <div><?php echo htmlspecialchars($contact_error); ?></div>
    </div>
<?php endif; ?>

<!-- Quick Contact Action Bar -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-bottom: 25px;">
    <a href="tel:045841860" class="info-card" style="text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 16px;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #e0f2fe; color: #0369a1; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i data-lucide="phone" style="width: 22px; height: 22px;"></i>
        </div>
        <div>
            <span style="font-size: 0.8rem; color: #64748b; display: block;">โทรศัพท์สำนักงาน</span>
            <strong style="color: #0369a1; font-size: 1rem;">045-841-860</strong>
        </div>
    </a>

    <a href="mailto:buddhism.ub@mcu.ac.th" class="info-card" style="text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 16px;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #fef3c7; color: #92400e; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i data-lucide="mail" style="width: 22px; height: 22px;"></i>
        </div>
        <div>
            <span style="font-size: 0.8rem; color: #64748b; display: block;">อีเมลติดต่อ</span>
            <strong style="color: #92400e; font-size: 0.95rem;">buddhism.ub@mcu.ac.th</strong>
        </div>
    </a>

    <a href="index.php?page=enroll" class="info-card" style="text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 16px;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #dcfce7; color: #166534; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i data-lucide="user-plus" style="width: 22px; height: 22px;"></i>
        </div>
        <div>
            <span style="font-size: 0.8rem; color: #64748b; display: block;">รับสมัครนิสิต</span>
            <strong style="color: #166534; font-size: 1rem;">สมัครเรียนออนไลน์ ๔ ขั้นตอน</strong>
        </div>
    </a>

    <a href="https://m.me/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" class="info-card" style="text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 16px; border-left: 4px solid #0084ff;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #e0f2fe; color: #0084ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#0084ff" aria-hidden="true"><path d="M12 0C5.373 0 0 4.974 0 11.111c0 3.498 1.744 6.614 4.469 8.654V24l4.088-2.242c1.092.302 2.246.464 3.443.464 6.627 0 12-4.975 12-11.111C24 4.974 18.627 0 12 0zm1.191 14.963l-3.055-3.26-5.964 3.26 6.559-6.963 3.13 3.26 5.889-3.26-6.559 6.963z"/></svg>
        </div>
        <div>
            <span style="font-size: 0.8rem; color: #64748b; display: block;">Messenger แชทสด</span>
            <strong style="color: #0084ff; font-size: 0.95rem;">คุยกับผู้บริหารทันใจ</strong>
        </div>
    </a>

    <a href="https://www.facebook.com/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" class="info-card" style="text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 16px;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: #1d4ed8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#1d4ed8" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </div>
        <div>
            <span style="font-size: 0.8rem; color: #64748b; display: block;">Facebook ติดต่อ</span>
            <strong style="color: #1d4ed8; font-size: 0.95rem;">Dhirasiddho weerachat</strong>
        </div>
    </a>

    <a href="https://www.google.com/maps/search/?api=1&query=มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย+วิทยาเขตอุบลราชธานี" target="_blank" rel="noopener noreferrer" class="info-card" style="text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 16px;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #fce7f3; color: #be185d; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i data-lucide="map-pin" style="width: 22px; height: 22px;"></i>
        </div>
        <div>
            <span style="font-size: 0.8rem; color: #64748b; display: block;">นำทาง GPS</span>
            <strong style="color: #be185d; font-size: 1rem;">เปิด Google Maps</strong>
        </div>
    </a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; margin-bottom: 30px;">
    <!-- Contact Details -->
    <div>
        <h2 style="font-size: 1.25rem; color: var(--secondary-color); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <i data-lucide="map-pin" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
            ข้อมูลสถานที่ติดต่อ
        </h2>

        <div class="info-card" style="margin-bottom: 15px;">
            <strong style="color: var(--secondary-color); display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                <i data-lucide="building" style="width: 16px; height: 16px; color: var(--primary-color);"></i>
                ที่ตั้งคณะพุทธศาสตร์:
            </strong>
            <p style="color: #475569; font-size: 0.925rem; line-height: 1.7;">
                คณะพุทธศาสตร์<br>
                มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี<br>
                หมู่ที่ 1 ตำบลกระโสบ อำเภอเมืองอุบลราชธานี จังหวัดอุบลราชธานี 34000
            </p>
        </div>

        <div class="info-card" style="margin-bottom: 15px; border-left: 4px solid var(--primary-color); background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%);">
            <div style="display: flex; gap: 14px; align-items: flex-start;">
                <div class="person-avatar" style="width: 70px; height: 70px; flex-shrink: 0; margin: 0;">
                    <img src="aj_veerachat.jpg" alt="ภาพถ่าย พระมหาวีระชาติ ธีรสิทฺโธ (เพ็งแจ่ม), ผศ.ดร." loading="lazy">
                </div>
                <div>
                    <span style="font-size: 0.75rem; background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 12px; font-weight: 700; display: inline-block; margin-bottom: 4px;">
                        อาจารย์ประจำหลักสูตร / ติดต่อสอบถาม
                    </span>
                    <h3 style="font-size: 1.05rem; color: var(--secondary-color); margin: 0 0 4px 0; font-weight: 700;">
                        พระมหาวีระชาติ ธีรสิทฺโธ, ผศ.ดร.
                    </h3>
                    <p style="color: #64748b; font-size: 0.825rem; margin: 0 0 8px 0;">
                        ผู้ช่วยศาสตราจารย์ ดร. / ประธานหลักสูตรพระพุทธศาสนา
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 4px; font-size: 0.85rem; color: #334155;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i data-lucide="phone" style="width: 14px; height: 14px; color: #0284c7;"></i>
                            <span><strong>โทร:</strong> <a href="tel:0817060363" style="color: #0284c7; text-decoration: none; font-weight: 700;">081-706-0363</a></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i data-lucide="mail" style="width: 14px; height: 14px; color: var(--primary-color);"></i>
                            <span><strong>Email:</strong> <a href="mailto:weerachat.pen@mcu.ac.th" style="color: var(--primary-color); text-decoration: none;">weerachat.pen@mcu.ac.th</a></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <i data-lucide="message-circle" style="width: 14px; height: 14px; color: #16a34a;"></i>
                            <span><strong>LINE ID:</strong> <a href="https://line.me/ti/p/~0817060363" target="_blank" rel="noopener noreferrer" style="color: #16a34a; text-decoration: none; font-weight: 700;">0817060363</a></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#1877f2" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            <span><strong>Facebook:</strong> <a href="https://www.facebook.com/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" style="color: #1877f2; text-decoration: none; font-weight: 700;">Dhirasiddho weerachat</a></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#0084ff" aria-hidden="true"><path d="M12 0C5.373 0 0 4.974 0 11.111c0 3.498 1.744 6.614 4.469 8.654V24l4.088-2.242c1.092.302 2.246.464 3.443.464 6.627 0 12-4.975 12-11.111C24 4.974 18.627 0 12 0zm1.191 14.963l-3.055-3.26-5.964 3.26 6.559-6.963 3.13 3.26 5.889-3.26-6.559 6.963z"/></svg>
                            <span><strong>Messenger:</strong> <a href="https://m.me/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" style="color: #0084ff; text-decoration: none; font-weight: 700;">แชทคุยสดทันที</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-card">
            <strong style="color: var(--secondary-color); display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                <i data-lucide="contact" style="width: 16px; height: 16px; color: var(--primary-color);"></i>
                ช่องทางติดต่ออื่นๆ:
            </strong>
            <div style="color: #475569; font-size: 0.9rem; line-height: 2;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="phone" style="width: 15px; height: 15px; color: var(--primary-color);"></i>
                    <span><strong>โทรศัพท์สำนักงาน:</strong> 045-841-860</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="printer" style="width: 15px; height: 15px; color: var(--primary-color);"></i>
                    <span><strong>โทรสาร:</strong> 045-841-861</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="mail" style="width: 15px; height: 15px; color: var(--primary-color);"></i>
                    <span><strong>อีเมลส่วนกลาง:</strong> <a href="mailto:buddhism.ub@mcu.ac.th" style="color: var(--primary-color); text-decoration: none;">buddhism.ub@mcu.ac.th</a></span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1877f2" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    <span><strong>Facebook ติดต่อ:</strong> <a href="https://www.facebook.com/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" style="color: #1877f2; text-decoration: none; font-weight: 600;">Dhirasiddho weerachat</a></span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1877f2" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    <span><strong>Facebook หน่วยงาน:</strong> <a href="https://www.facebook.com/mcubon" target="_blank" rel="noopener noreferrer" style="color: #1877f2; text-decoration: none; font-weight: 600;">มจร วิทยาเขตอุบลราชธานี</a></span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="clock" style="width: 15px; height: 15px; color: var(--primary-color);"></i>
                    <span><strong>วันเวลาทำการ:</strong> จันทร์ - ศุกร์ 08.30 - 16.30 น. (เสาร์-อาทิตย์ สำหรับการเรียนการสอน)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div>
        <h2 style="font-size: 1.25rem; color: var(--secondary-color); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <i data-lucide="mail-plus" style="width: 20px; height: 20px; color: var(--primary-color);"></i>
            ส่งข้อความสอบถามทางออนไลน์
        </h2>

        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 10px; padding: 22px; box-shadow: var(--box-shadow);">
            <form action="index.php?page=contactus" method="post">
                <input type="hidden" name="action" value="send_contact">

                <div class="form-group">
                    <label class="form-label" for="sender_name">ชื่อ - นามสกุล หรือ ฉายา (กรณีพระภิกษุ) <span style="color: #dc2626;">*</span></label>
                    <input type="text" id="sender_name" name="sender_name" class="form-control" placeholder="กรุณาระบุชื่อของท่าน" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="sender_contact">เบอร์โทรศัพท์ หรือ อีเมล <span style="color: #dc2626;">*</span></label>
                    <input type="text" id="sender_contact" name="sender_contact" class="form-control" placeholder="เช่น 081-234-5678 หรือ email@example.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="sender_subject">เรื่องที่ต้องการติดต่อ <span style="color: #dc2626;">*</span></label>
                    <select id="sender_subject" name="sender_subject" class="form-control" required>
                        <option value="สอบถามการสมัครเรียน / รับนิสิตใหม่">สอบถามการสมัครเรียน / รับนิสิตใหม่</option>
                        <option value="สอบถามข้อมูลหลักสูตร มคอ.๒">สอบถามข้อมูลหลักสูตร มคอ.๒</option>
                        <option value="ขอเอกสารทางการศึกษา / ตำราเรียน">ขอเอกสารทางการศึกษา / ตำราเรียน</option>
                        <option value="ติดต่อคณาจารย์ / อาจารย์ที่ปรึกษา">ติดต่อคณาจารย์ / อาจารย์ที่ปรึกษา</option>
                        <option value="เรื่องอื่นๆ ทั่วไป">เรื่องอื่นๆ ทั่วไป</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="sender_message">ข้อความรายละเอียด <span style="color: #dc2626;">*</span></label>
                    <textarea id="sender_message" name="sender_message" class="form-control" rows="4" placeholder="พิมพ์ข้อความที่ต้องการสอบถามที่นี่..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; gap: 8px;">
                    <i data-lucide="send" style="width: 16px; height: 16px;"></i> ส่งข้อความสอบถาม
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Campus Map info & Navigation Guide -->
<div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: 10px; padding: 22px; margin-bottom: 20px; box-shadow: var(--box-shadow);">
    <h3 style="color: var(--secondary-color); font-size: 1.15rem; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
        <i data-lucide="map" style="width: 22px; height: 22px; color: var(--primary-color);"></i>
        แผนที่และการเดินทางมายังมหาวิทยาลัย
    </h3>
    <p style="color: #475569; font-size: 0.925rem; line-height: 1.7; margin-bottom: 15px;">
        มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี ตั้งอยู่บนถนนสายอุบลราชธานี-ตระการพืชผล (บ้านดงแสนสุข ต.กระโสบ) ห่างจากตัวเมืองอุบลราชธานีประมาณ 12 กิโลเมตร มีป้ายบอกทางชัดเจน สะดวกต่อการเดินทางด้วยรถยนต์ส่วนตัวและรถโดยสารประจำทาง
    </p>

    <!-- Embedded OpenStreetMap Frame -->
    <div style="border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color); height: 350px; background: #f1f5f9; position: relative;">
        <iframe 
            width="100%" 
            height="100%" 
            frameborder="0" 
            scrolling="no" 
            marginheight="0" 
            marginwidth="0" 
            title="แผนที่ มจร วิทยาเขตอุบลราชธานี"
            src="https://www.openstreetmap.org/export/embed.html?bbox=104.8500%2C15.2800%2C104.9300%2C15.3400&amp;layer=mapnik&amp;marker=15.3050%2C104.8870">
        </iframe>
    </div>
    
    <div style="margin-top: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <small style="color: #64748b;">
            พิกัด: 15.3050, 104.8870 (บ้านดงแสนสุข ต.กระโสบ อ.เมือง จ.อุบลราชธานี)
        </small>
        <a href="https://www.google.com/maps/search/?api=1&query=มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย+วิทยาเขตอุบลราชธานี" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="font-size: 0.85rem; padding: 6px 14px; gap: 6px;">
            <i data-lucide="external-link" style="width: 14px; height: 14px;"></i> เปิดดูบน Google Maps ขนาดใหญ่
        </a>
    </div>
</div>
