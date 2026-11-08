<?php
require_once __DIR__ . '/counter.php';
$visitor_count = get_visitor_count();
?>
<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-info">
            <h4>คณะพุทธศาสตร์</h4>
            <p>มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี</p>
            <p style="margin-top: 4px; font-size: 0.8rem; color: #94a3b8;">
                Faculty of Buddhism, Mahachulalongkornrajavidyalaya University, Ubon Ratchathani Campus
            </p>
            <p style="margin-top: 6px; font-size: 0.8rem; color: #cbd5e1; display: flex; align-items: center; gap: 5px;">
                <i data-lucide="map-pin" style="width: 14px; height: 14px; color: var(--accent-color);"></i>
                หมู่ที่ 1 ตำบลกระโสบ อำเภอเมืองอุบลราชธานี จังหวัดอุบลราชธานี 34000
            </p>
        </div>

        <div class="footer-counter">
            <div class="visitor-badge">
                <i data-lucide="users" style="width: 24px; height: 24px; color: #fbbf24;"></i>
                <div>
                    <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">ผู้เข้าชมเว็บไซต์</div>
                    <div class="counter-number"><?php echo number_format($visitor_count); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <p>© <?php echo (int)date("Y") + 543; ?> คณะพุทธศาสตร์ มจร วิทยาเขตอุบลราชธานี. สงวนลิขสิทธิ์ทุกประการ.</p>
        <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
            <a href="https://www.facebook.com/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" style="color: #93c5fd; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem;" aria-label="Facebook Dhirasiddho weerachat (เปิดแท็บใหม่)">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                <span>Facebook: Dhirasiddho weerachat</span>
            </a>
            <span style="color: #475569;">|</span>
            <a href="https://www.facebook.com/mcubon" target="_blank" rel="noopener noreferrer" style="color: #93c5fd; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem;" aria-label="Facebook มจร วิทยาเขตอุบลราชธานี (เปิดแท็บใหม่)">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                <span>Facebook มจร อุบลฯ</span>
            </a>
        </div>
    </div>
</footer>

<!-- Floating Facebook Connect Widget -->
<div class="fb-floating-container" id="fbFloatingWidget">
    <div class="fb-pulse" aria-hidden="true"></div>
    <button type="button" class="fb-floating-btn" id="fbFloatingToggle" aria-expanded="false" aria-controls="fbPopoverMenu" aria-label="เชื่อมต่อ Facebook และ Messenger" title="เชื่อมต่อ Facebook / Messenger">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="#ffffff" aria-hidden="true">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
        </svg>
    </button>

    <div class="fb-popover" id="fbPopoverMenu" role="dialog" aria-label="เมนูเชื่อมต่อ Facebook">
        <div class="fb-popover-header">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 0.95rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#ffffff" aria-hidden="true">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                <span>เชื่อมต่อ Facebook</span>
            </div>
            <button type="button" id="fbPopoverClose" style="background: none; border: none; color: #ffffff; cursor: pointer; font-size: 1.1rem; line-height: 1; padding: 2px 6px;" aria-label="ปิดกล่อง Facebook">✕</button>
        </div>
        <div class="fb-popover-body">
            <!-- พระมหาวีระชาติ ธีรสิทฺโธ -->
            <div class="fb-contact-item">
                <div style="font-size: 0.75rem; color: #92400e; font-weight: 700; margin-bottom: 2px;">อาจารย์ประจำหลักสูตร / ติดต่อสอบถาม</div>
                <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">Dhirasiddho weerachat</div>
                <div style="font-size: 0.775rem; color: #64748b; margin-bottom: 8px;">พระมหาวีระชาติ ธีรสิทฺโธ, ผศ.ดร.</div>
                <div style="display: flex; gap: 6px;">
                    <a href="https://m.me/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" class="fb-btn-action fb-btn-action-primary" style="flex: 1;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.373 0 0 4.974 0 11.111c0 3.498 1.744 6.614 4.469 8.654V24l4.088-2.242c1.092.302 2.246.464 3.443.464 6.627 0 12-4.975 12-11.111C24 4.974 18.627 0 12 0zm1.191 14.963l-3.055-3.26-5.964 3.26 6.559-6.963 3.13 3.26 5.889-3.26-6.559 6.963z"/></svg> แชท Messenger
                    </a>
                    <a href="https://www.facebook.com/dhirasiddho.weerachat" target="_blank" rel="noopener noreferrer" class="fb-btn-action fb-btn-action-secondary">
                        ดูโปรไฟล์
                    </a>
                </div>
            </div>

            <!-- มจร วิทยาเขตอุบลราชธานี -->
            <div class="fb-contact-item">
                <div style="font-size: 0.75rem; color: #1e40af; font-weight: 700; margin-bottom: 2px;">เพจหน่วยงานทางการ</div>
                <div style="font-weight: 700; color: #0f172a; font-size: 0.9rem;">มจร วิทยาเขตอุบลราชธานี</div>
                <div style="font-size: 0.775rem; color: #64748b; margin-bottom: 8px;">คณะพุทธศาสตร์ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย</div>
                <a href="https://www.facebook.com/mcubon" target="_blank" rel="noopener noreferrer" class="fb-btn-action fb-btn-action-secondary" style="width: 100%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="#1877f2" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg> ติดตามข่าวสารบนเพจ
                </a>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    var fbToggle = document.getElementById('fbFloatingToggle');
    var fbMenu = document.getElementById('fbPopoverMenu');
    var fbClose = document.getElementById('fbPopoverClose');

    if (fbToggle && fbMenu) {
        fbToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            var isOpen = fbMenu.classList.contains('active');
            if (isOpen) {
                fbMenu.classList.remove('active');
                fbToggle.setAttribute('aria-expanded', 'false');
            } else {
                fbMenu.classList.add('active');
                fbToggle.setAttribute('aria-expanded', 'true');
            }
        });

        if (fbClose) {
            fbClose.addEventListener('click', function(e) {
                e.stopPropagation();
                fbMenu.classList.remove('active');
                fbToggle.setAttribute('aria-expanded', 'false');
            });
        }

        document.addEventListener('click', function(e) {
            var widget = document.getElementById('fbFloatingWidget');
            if (widget && !widget.contains(e.target)) {
                fbMenu.classList.remove('active');
                fbToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
})();
</script>