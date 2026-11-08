<?php
$cur = $_GET['page'] ?? 'home';
$lvl = $_GET['level'] ?? '';
?>
<aside class="sidebar">
    <div class="menu-title">
        <i data-lucide="book-marked" style="color: var(--primary-color);"></i>
        <span>เมนูหลัก</span>
    </div>
    
    <ul class="nav-menu">
        <li>
            <a href="index.php?page=home" class="<?php echo ($cur === 'home') ? 'active' : ''; ?>">
                <i data-lucide="home"></i> <span>หน้าหลัก</span>
            </a>
        </li>
        <li>
            <a href="index.php?page=service" class="<?php echo ($cur === 'service') ? 'active' : ''; ?>">
                <i data-lucide="graduation-cap"></i> <span>อาจารย์ประจำหลักสูตร</span>
            </a>
        </li>
        <li>
            <a href="index.php?page=product" class="<?php echo ($cur === 'product') ? 'active' : ''; ?>">
                <i data-lucide="award"></i> <span>หลักสูตรการศึกษา</span>
            </a>
            <ul class="nav-submenu">
                <li>
                    <a href="index.php?page=product&level=phd" class="<?php echo ($cur === 'product' && $lvl === 'phd') ? 'active-sub' : ''; ?>">
                        <i data-lucide="chevron-right" style="width: 12px; height: 12px;"></i> พุทธศาสตรดุษฎีบัณฑิต (เอก)
                    </a>
                </li>
                <li>
                    <a href="index.php?page=product&level=master" class="<?php echo ($cur === 'product' && $lvl === 'master') ? 'active-sub' : ''; ?>">
                        <i data-lucide="chevron-right" style="width: 12px; height: 12px;"></i> พุทธศาสตรมหาบัณฑิต (โท)
                    </a>
                </li>
                <li>
                    <a href="index.php?page=product&level=bachelor" class="<?php echo ($cur === 'product' && ($lvl === 'bachelor' || empty($lvl))) ? 'active-sub' : ''; ?>">
                        <i data-lucide="chevron-right" style="width: 12px; height: 12px;"></i> พุทธศาสตรบัณฑิต (ตรี)
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="index.php?page=schedule" class="<?php echo ($cur === 'schedule') ? 'active' : ''; ?>">
                <i data-lucide="calendar-days"></i> <span>ตารางเรียน / ตารางสอน</span>
            </a>
        </li>
        <li>
            <a href="index.php?page=textbooks" class="<?php echo ($cur === 'textbooks') ? 'active' : ''; ?>">
                <i data-lucide="book-open"></i> <span>ตำราเรียน / สื่อการสอน</span>
            </a>
        </li>
        <li>
            <a href="index.php?page=enroll" class="<?php echo ($cur === 'enroll') ? 'active' : ''; ?>">
                <i data-lucide="user-plus"></i> <span>สมัครเรียน / นิสิตใหม่</span>
            </a>
        </li>
        <li>
            <a href="index.php?page=aboutus" class="<?php echo ($cur === 'aboutus') ? 'active' : ''; ?>">
                <i data-lucide="info"></i> <span>เกี่ยวกับคณะพุทธศาสตร์</span>
            </a>
        </li>
        <li>
            <a href="index.php?page=contactus" class="<?php echo ($cur === 'contactus') ? 'active' : ''; ?>">
                <i data-lucide="map-pin"></i> <span>ติดต่อเรา</span>
            </a>
        </li>
    </ul>

    <!-- Quick Info Card in Sidebar -->
    <div class="sidebar-card">
        <h4 style="display: flex; align-items: center; gap: 6px;">
            <i data-lucide="bell" style="width: 16px; height: 16px; color: var(--primary-color);"></i>
            รับสมัครนิสิต
        </h4>
        <p style="color: #475569; margin-bottom: 10px;">เปิดรับสมัครนิสิตใหม่ ทั้งพระภิกษุ สามเณร และบุคคลทั่วไป</p>
        <a href="index.php?page=enroll" class="btn btn-primary" style="font-size: 0.85rem; padding: 6px 12px; width: 100%; justify-content: center; gap: 6px;">
            <i data-lucide="arrow-right-circle" style="width: 15px; height: 15px;"></i> ดูรายละเอียดสมัคร
        </a>
    </div>

    <div class="sidebar-card" style="background: #fffbeb; border: 1px solid #fde68a;">
        <h4 style="display: flex; align-items: center; gap: 6px; color: #92400e; margin-bottom: 6px;">
            <i data-lucide="phone-call" style="width: 16px; height: 16px; color: #b45309;"></i>
            ติดต่อสอบถาม
        </h4>
        <p style="color: #78350f; font-size: 0.8rem; line-height: 1.5; margin-bottom: 8px;">
            <strong>พระมหาวีระชาติ ธีรสิทฺโธ, ผศ.ดร.</strong><br>
            <span style="display: flex; align-items: center; gap: 4px; margin-top: 4px;">
                <i data-lucide="phone" style="width: 12px; height: 12px; color: #0284c7;"></i>
                <a href="tel:0817060363" style="color: #0284c7; text-decoration: none; font-weight: 600;">081-706-0363</a>
            </span>
            <span style="display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                <i data-lucide="message-circle" style="width: 12px; height: 12px; color: #16a34a;"></i>
                LINE: <a href="https://line.me/ti/p/~0817060363" target="_blank" rel="noopener noreferrer" style="color: #16a34a; text-decoration: none; font-weight: 600;">0817060363</a>
            </span>
            <span style="display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#1877f2" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                FB: <a href="https://www.facebook.com/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" style="color: #1877f2; text-decoration: none; font-weight: 600;">Dhirasiddho weerachat</a>
            </span>
        </p>
    </div>

    <!-- Facebook Page Card -->
    <div class="sidebar-card" style="background: #eff6ff; border: 1px solid #bfdbfe;">
        <h4 style="display: flex; align-items: center; gap: 6px; color: #1e40af; margin-bottom: 6px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#1877f2" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            Facebook หน่วยงาน
        </h4>
        <p style="color: #1e3a8a; font-size: 0.8rem; line-height: 1.5; margin-bottom: 8px;">
            มจร วิทยาเขตอุบลราชธานี
        </p>
        <a href="https://www.facebook.com/mcubon" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="font-size: 0.825rem; padding: 6px 10px; width: 100%; justify-content: center; gap: 6px; background: #1877f2; border-color: #1877f2;">
            <i data-lucide="external-link" style="width: 14px; height: 14px;"></i> ติดตามบน Facebook
        </a>
    </div>

    <div class="sidebar-card" style="background: #f1f5f9;">
        <h4 style="display: flex; align-items: center; gap: 6px;">
            <i data-lucide="clock" style="width: 16px; height: 16px; color: var(--primary-color);"></i>
            เวลาทำการ
        </h4>
        <p style="color: #64748b; font-size: 0.825rem; line-height: 1.5;">
            จันทร์ - ศุกร์: 08.30 - 16.30 น.<br>
            เสาร์ - อาทิตย์: 08.30 - 16.30 น.<br>
            (สำหรับการเรียนการสอน)
        </p>
    </div>
</aside>
