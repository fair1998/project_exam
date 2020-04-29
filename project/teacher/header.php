<?php
include("../connect.php");
$id = $_SESSION['id'];
$sql = "SELECT * from tb_teacher t
inner join tb_department d on d.d_id = t.d_id 
where t_id = '$id'";
$rs = $con->query($sql);
$r = $rs->fetch_object();
error_reporting(error_reporting() & ~E_NOTICE);
?>

<div class="page-wrapper">
    <!-- HEADER DESKTOP-->
    <header class="header-desktop3 d-none d-lg-block">
        <div class="section__content section__content--p35">
            <div class="header3-wrap">
                <div class="header__logo">
                    <a href="index.php">
                        <img src="../images/logo-white.png" />
                    </a>
                </div>
                <div class="header__navbar">
                    <ul class="list-unstyled">
                        <li>
                            <a href="unit_manage.php">
                                <span class="bot-line"></span>จัดการหน่วยการเรียน
                            </a>
                        </li>
                        <li>
                            <a href="exam_set_manage.php">
                                <span class="bot-line"></span>จัดการชุดข้อสอบ
                            </a>
                        </li>
                        <li>
                            <a href="exam_manage.php">
                                <span class="bot-line"></span>จัดการข้อสอบ
                            </a>
                        </li>
                        <li>
                            <a href="results_manage.php">
                                <span class="bot-line"></span>ผลการสอบ
                            </a>
                        </li>
                        <li>
                            <a href="statistic_manage.php">
                                <span class="bot-line"></span>สถิติการสอบ
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="header__tool">
                    <div class="account-wrap">
                        <div class="account-item account-item--style2 clearfix js-item-menu">
                            <div class="image">
                                <img src="../images/<?= $r->t_image ?>" />
                            </div>
                            <div class="content">
                                <a class="js-acc-btn"><?= $r->t_name ?></a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <img src="../images/<?= $r->t_image ?>" />
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <?= $r->t_name ?>
                                        </h5>
                                        <span class="email"><?= $r->d_name ?></span>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="profile_form_update.php">
                                        <i class="zmdi zmdi-account"></i>Edit Profile
                                    </a>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="../logout.php?s=logout_s">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END HEADER DESKTOP-->

    <!-- HEADER MOBILE-->
    <header class="header-mobile header-mobile-2 d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="index.html">
                        <img src="../images/logo-white.png" alt="CoolAdmin" />
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <li>
                        <a href="chart.html">
                            <i class="fas fa-chart-bar"></i>Charts</a>
                    </li>
                    <li>
                        <a href="chart.html">
                            <i class="fas fa-chart-bar"></i>Charts</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="sub-header-mobile-2 d-block d-lg-none">
        <div class="header__tool">
            <div class="account-wrap">
                <div class="account-item account-item--style2 clearfix js-item-menu">
                    <div class="image">
                        <img src="../images/avatar-01.jpg" />
                    </div>
                    <div class="content">
                        <a class="js-acc-btn" href="#">john doe</a>
                    </div>
                    <div class="account-dropdown js-dropdown">
                        <div class="info clearfix">
                            <div class="image">
                                <a href="#">
                                    <img src="../images/avatar-01.jpg" />
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="name">
                                    <a href="#">john doe</a>
                                </h5>
                                <span class="email">johndoe@example.com</span>
                            </div>
                        </div>
                        <div class="account-dropdown__footer">
                            <a href="#">
                                <i class="zmdi zmdi-account"></i>Edit Profile</a>
                        </div>
                        <div class="account-dropdown__footer">
                            <a href="#">
                                <i class="zmdi zmdi-power"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END HEADER MOBILE -->

    <!-- PAGE CONTENT-->
    <div class="page-content--bgf7">