<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>nkpbuddhism.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body>
<table width="100%" border="1">
  <tr>
    <td colspan="2"><div align="left">

    <!-- Header -->
    <?php include("header.php"); ?>

    </div></td>
  </tr>
  <tr>
    <td width="24%"><div align="left">

    <!-- Menu -->
    <?php include("menu.php"); ?>

    </div></td>
    <td width="76%">

    <!-- Container -->
    <?php 
    switch ($_GET["page"]) {

    case "home":
        echo "Home";
        include("page_home.php");
        break;

    case "subjects":
        echo "Home -> Subjects : วิชา ตารางเรียน";
        include("page_subjects.php");
        break;

    case "teachers":
        echo "Home -> Teachers : อาจารย์สอนสาขาวิชาพระพุทธศาสนา";
        include("page_teachers.php");
        break;

    case "textbooks":
        echo "Home -> Textbooks : หนังสือเรียน ตำราเรียน";
        include("page_textbooks.php");
        break;


    case "pali":
        echo "Home -> Pali: หนังสือเรียนบาลีไวยากรณ์ Pali Grammar";
        include("page_pali.php");
        break;

    case "pali2":
        echo "Home -> Pali: หนังสือเรียนบาลี Pali Books";
        include("page_pali2.php");
        break;




    case "dhamma":
        echo "Home -> Dhamma books: หนังสือเรียนนักธรรมและธรรมศึกษา ชั้นตรี ชั้นโท ชั้นเอก";
        include("page_dhamma.php");
        break;

    case "buddhism":
        echo "Home -> Buddhism: หนังสือพระพุทธศาสนาภาคภาษาอังกฤษ Buddhism in English";
        include("page_buddhism.php");
        break;

    case "tipitaka":
        echo "Home -> Tipitaka Scripture: คัมภีร์พระไตรปิฎก";
        include("page_tipitaka.php");
        break;
        
    case "elearning":
        echo "Home -> e-learning : วีดีโอสอน ...เรียนตามอัธยาศัย...Videos on demand...digitally on request.";
        include("page_elearning.php");
        break;



case "program":
        echo "Home -> program learn : เรียนเขียนโปรแกรมมิ่ง";
        include("page_program.php");
        break;

case "english learn":
        echo "Home -> English learn from website : เรียนภาษาอังกฤษจากเว็บไซต์ ศึกษาด้วยตนเอง";
        include("page_english_learn.php");
        break;

case "computer learn":
        echo "Home -> computer learn : เรียนคอมพิวเตอร์";
        include("page_computer_learn.php");
        break;

case "english":
        echo "Home -> English : เว็บภาคภาษาอังกฤษ";
        include("page_english.php");
        break;

case "aitechnology":
        echo "Home -> AI Technology : เรียนรู้เทคโนโลยีเอไอ";
        include("page_aitechnology.php");
        break;


    case "aboutus":
        echo "Home -> About Us เกี่ยวกับพวกเรา";
        include("page_aboutus.php");
        break;
    case "contactus":
        echo "Home -> Contact Us ติดต่อพวกเรา";
        include("page_contactus.php");
        break;
    case "admin":
        echo "Home -> Admin : ผู้ดูแลและออกแบบเว็บไซต์";
        include("page_admin.php");
        break;
        default:
        echo "Home";
        include("page_slideshow.php");
    }
    ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">

    <!-- Footer -->
    <?php include("footer.php"); ?>

    </div></td>
  </tr>
</table>
</body>
</html>