<!-- Top Utility Bar with WCAG AAA Accessibility Toolbar -->
<div class="top-bar" role="region" aria-label="แถบข้อมูลสถาบันและเครื่องมือการเข้าถึง">
    <div class="top-bar-item">
        <span style="display: inline-flex; align-items: center; gap: 6px;">
            <i data-lucide="landmark" style="width: 16px; height: 16px; color: #fbbf24;"></i>
            <strong>มจร วิทยาเขตอุบลราชธานี</strong>
        </span>
        <span style="margin: 0 4px; color: #64748b;">|</span>
        <span style="display: inline-flex; align-items: center; gap: 6px;">
            <i data-lucide="calendar" style="width: 14px; height: 14px; color: #93c5fd;"></i>
            <?php 
            $thai_months = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            $day = date("j");
            $month = $thai_months[(int)date("n")];
            $year = (int)date("Y") + 543;
            echo "วัน" . ["อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์"][date("w")] . "ที่ $day $month $year";
            ?>
        </span>
    </div>

    <!-- Accessibility Tools (Font Size & Color Theme) -->
    <div class="top-bar-item">
        <div class="a11y-toolbar" role="toolbar" aria-label="เครื่องมือปรับแต่งการแสดงผล">
            <span class="a11y-label">ขนาดตัวอักษร:</span>
            <div class="a11y-btn-group">
                <button type="button" class="a11y-btn" data-font-size="normal" aria-label="ขนาดตัวอักษรปกติ" title="ขนาดตัวอักษรปกติ" aria-pressed="true">A</button>
                <button type="button" class="a11y-btn" data-font-size="medium" aria-label="ขนาดตัวอักษรปานกลาง" title="ขนาดตัวอักษรปานกลาง" aria-pressed="false">A+</button>
                <button type="button" class="a11y-btn" data-font-size="large" aria-label="ขนาดตัวอักษรใหญ่" title="ขนาดตัวอักษรใหญ่" aria-pressed="false">A++</button>
            </div>

            <span class="a11y-label" style="margin-left: 6px;">โหมดสี:</span>
            <div class="a11y-btn-group">
                <button type="button" class="a11y-btn" data-theme="normal" aria-label="โหมดสีปกติ" title="โหมดสีปกติ" aria-pressed="true">ปกติ</button>
                <button type="button" class="a11y-btn" data-theme="high-contrast" aria-label="โหมดความคมชัดสูง WCAG AAA" title="โหมดความคมชัดสูง (ขาว-ดำ-เหลือง)" aria-pressed="false">AAA</button>
                <button type="button" class="a11y-btn" data-theme="dark" aria-label="โหมดกลางคืน" title="โหมดมืด" aria-pressed="false">☾</button>
            </div>
        </div>

        <a href="https://www.facebook.com/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" style="color: #93c5fd; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 4px;" aria-label="Facebook Dhirasiddho weerachat (เปิดแท็บใหม่)">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> Facebook
        </a>

        <a href="index.php?page=contactus" style="color: #fef3c7; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 4px;">
            <i data-lucide="phone-call" style="width: 14px; height: 14px;"></i> ติดต่อเรา
        </a>
    </div>
</div>

<!-- Site Banner Header -->
<header class="site-header" role="banner">
    <div class="banner-container">
        <a href="index.php?page=home" title="หน้าหลัก คณะพุทธศาสตร์ มจร อุบลราชธานี" aria-label="หน้าหลัก คณะพุทธศาสตร์ มจร อุบลราชธานี">
            <img src="banner25682.jpg" alt="คณะพุทธศาสตร์ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี" class="banner-img">
        </a>
    </div>
</header>