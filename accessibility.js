/**
 * Accessibility & Institutional Interactive Engine (WCAG 2.1 AAA Standard)
 * สาขาวิชาพระพุทธศาสนา มจร วิทยาเขตอุบลราชธานี
 */

(function () {
    'use strict';

    // --- Font Resizer Engine ---
    const FONT_KEY = 'mcu_font_size';
    const THEME_KEY = 'mcu_color_theme';

    function setFontSize(size) {
        document.body.classList.remove('font-normal', 'font-medium', 'font-large');
        if (size === 'medium') {
            document.body.classList.add('font-medium');
        } else if (size === 'large') {
            document.body.classList.add('font-large');
        } else {
            document.body.classList.add('font-normal');
        }
        localStorage.setItem(FONT_KEY, size);

        // Update aria pressed
        document.querySelectorAll('[data-font-size]').forEach(btn => {
            btn.setAttribute('aria-pressed', btn.getAttribute('data-font-size') === size ? 'true' : 'false');
        });
    }

    // --- Color Theme Engine (High Contrast AAA & Dark Mode) ---
    function setTheme(theme) {
        document.body.classList.remove('theme-high-contrast', 'theme-dark');
        if (theme === 'high-contrast') {
            document.body.classList.add('theme-high-contrast');
        } else if (theme === 'dark') {
            document.body.classList.add('theme-dark');
        }
        localStorage.setItem(THEME_KEY, theme);

        document.querySelectorAll('[data-theme]').forEach(btn => {
            btn.setAttribute('aria-pressed', btn.getAttribute('data-theme') === theme ? 'true' : 'false');
        });
    }

    // Initialize saved preferences
    function initPreferences() {
        const savedFont = localStorage.getItem(FONT_KEY) || 'normal';
        setFontSize(savedFont);

        const savedTheme = localStorage.getItem(THEME_KEY) || 'normal';
        setTheme(savedTheme);
    }

    // --- Back To Top Engine ---
    function initBackToTop() {
        let btt = document.getElementById('backToTopBtn');
        if (!btt) {
            btt = document.createElement('button');
            btt.id = 'backToTopBtn';
            btt.className = 'back-to-top-btn';
            btt.setAttribute('aria-label', 'เลื่อนกลับขึ้นด้านบนสุด');
            btt.title = 'เลื่อนกลับขึ้นด้านบนสุด';
            btt.innerHTML = '<span aria-hidden="true">▲</span>';
            document.body.appendChild(btt);

            btt.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                btt.classList.add('visible');
            } else {
                btt.classList.remove('visible');
            }
        }, { passive: true });
    }

    // --- Real-time Course Search & Filter (for page_product.php) ---
    function initCourseSearch() {
        const searchInput = document.getElementById('courseSearchInput');
        if (!searchInput) return;

        const countDisplay = document.getElementById('courseSearchResultCount');

        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            const courseItems = document.querySelectorAll('.course-item');
            let matched = 0;

            courseItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (!query || text.includes(query)) {
                    item.style.display = '';
                    matched++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Open detail wrappers when searching
            document.querySelectorAll('details').forEach(d => {
                if (query) {
                    d.open = true;
                }
            });

            if (countDisplay) {
                if (query) {
                    countDisplay.textContent = `พบ ${matched} รายวิชาที่ตรงกับคำค้น`;
                    countDisplay.style.display = 'inline-block';
                } else {
                    countDisplay.textContent = '';
                    countDisplay.style.display = 'none';
                }
            }
        });
    }

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', onReady);
    } else {
        onReady();
    }

    function onReady() {
        initPreferences();
        initBackToTop();
        initCourseSearch();

        // Attach accessibility button handlers
        document.querySelectorAll('[data-font-size]').forEach(btn => {
            btn.addEventListener('click', function () {
                setFontSize(this.getAttribute('data-font-size'));
            });
        });

        document.querySelectorAll('[data-theme]').forEach(btn => {
            btn.addEventListener('click', function () {
                setTheme(this.getAttribute('data-theme'));
            });
        });
    }

    // Expose for external controls if needed
    window.mcuAccessibility = {
        setFontSize: setFontSize,
        setTheme: setTheme
    };
})();
