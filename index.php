<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security Headers (AAA Web Security Standard)
if (!headers_sent()) {
    header("X-Content-Type-Options: nosniff");
    header("X-Frame-Options: SAMEORIGIN");
    header("X-XSS-Protection: 1; mode=block");
    header("Referrer-Policy: strict-origin-when-cross-origin");
}

// Route definitions with titles and corresponding views
$pages = [
    'home' => [
        'title' => 'หน้าหลัก',
        'file'  => 'page_home.php'
    ],
    'service' => [
        'title' => 'อาจารย์ประจำหลักสูตร',
        'file'  => 'page_service.php'
    ],
    'product' => [
        'title' => 'หลักสูตรการศึกษา',
        'file'  => 'page_product.php'
    ],
    'schedule' => [
        'title' => 'ตารางเรียน / ตารางสอน',
        'file'  => 'page_schedule.php'
    ],
    'textbooks' => [
        'title' => 'ตำราเรียน / เอกสารวิชาการ',
        'file'  => 'page_textbooks.php'
    ],
    'enroll' => [
        'title' => 'สมัครเรียน / รับนิสิตใหม่',
        'file'  => 'page_enroll.php'
    ],
    'aboutus' => [
        'title' => 'เกี่ยวกับคณะพุทธศาสตร์',
        'file'  => 'page_aboutus.php'
    ],
    'contactus' => [
        'title' => 'ติดต่อเรา',
        'file'  => 'page_contactus.php'
    ]
];

// Sanitize and validate page parameter
$page_key = isset($_GET['page']) ? trim((string)$_GET['page']) : 'home';
if (!array_key_exists($page_key, $pages)) {
    $page_key = 'home';
}

$current_page = $pages[$page_key];
$page_title = $current_page['title'] . " | คณะพุทธศาสตร์ มจร วิทยาเขตอุบลราชธานี";
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="คณะพุทธศาสตร์ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี (มคอ.๒ ปรับปรุง ๒๕๗๐)">
    <meta name="keywords" content="คณะพุทธศาสตร์, พระพุทธศาสนา, มจร, อุบลราชธานี, พุทธศาสตรบัณฑิต, มคอ.2">
    <meta name="theme-color" content="#92400e">

    <!-- Open Graph & Social Sharing -->
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="คณะพุทธศาสตร์ มจร วิทยาเขตอุบลราชธานี หลักสูตรพุทธศาสตรบัณฑิต ๑๓๒ หน่วยกิต">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="th_TH">

    <link rel="stylesheet" href="style.css">

    <!-- Schema.org JSON-LD (Semantic Web & SEO) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "คณะพุทธศาสตร์ มหาวิทยาลัยมหาจุฬาลงกรณราชวิทยาลัย วิทยาเขตอุบลราชธานี",
      "alternateName": "Faculty of Buddhism, MCU Ubon Ratchathani Campus",
      "url": "http://localhost/ubweb/",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "หมู่ที่ 1 ตำบลกระโสบ",
        "addressLocality": "อำเภอเมืองอุบลราชธานี",
        "addressRegion": "จังหวัดอุบลราชธานี",
        "postalCode": "34000",
        "addressCountry": "TH"
      },
      "telephone": "+66-45-841-860"
    }
    </script>
</head>
<body class="font-normal">

<!-- Skip to Content Link for WCAG AAA Screen Readers & Keyboard Users -->
<a href="#main-content" class="skip-to-content">ข้ามไปยังเนื้อหาหลัก (Skip to Content)</a>

<div class="page-wrapper">
    <!-- Header Section -->
    <?php include __DIR__ . "/header.php"; ?>

    <!-- Main Content Layout -->
    <div class="main-layout">
        <!-- Sidebar Navigation -->
        <?php include __DIR__ . "/menu.php"; ?>

        <!-- Content Area -->
        <main id="main-content" class="content-area" role="main">
            <!-- Breadcrumbs -->
            <nav class="breadcrumb-bar" aria-label="แถบนำทางตำแหน่งปัจจุบัน">
                <a href="index.php?page=home" style="display: inline-flex; align-items: center; gap: 5px;">
                    <i data-lucide="home" style="width: 16px; height: 16px;"></i> หน้าแรก
                </a>
                <?php if ($page_key !== 'home'): ?>
                    <span class="breadcrumb-separator" style="display: inline-flex; align-items: center;" aria-hidden="true">
                        <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
                    </span>
                    <span class="breadcrumb-current" aria-current="page"><?php echo htmlspecialchars($current_page['title']); ?></span>
                <?php endif; ?>
            </nav>

            <!-- Page View Content -->
            <?php 
            $view_file = __DIR__ . '/' . $current_page['file'];
            if (file_exists($view_file)) {
                include $view_file;
            } else {
                echo "<p style='color:red;'>ไม่พบเนื้อหาของหน้านี้</p>";
            }
            ?>
        </main>
    </div>

    <!-- Footer Section -->
    <?php include __DIR__ . "/footer.php"; ?>
</div>

<!-- Lucide Icons Script -->
<script src="lucide.min.js"></script>
<script>
    lucide.createIcons();
</script>

<!-- Accessibility & Interactive Engine (AAA Standard) -->
<script src="accessibility.js"></script>

</body>
</html>