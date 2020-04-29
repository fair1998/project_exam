<?php
include("../connect.php");
$id = $_SESSION['id'];
$sql = "select * from tb_admin where a_id = '$id'";
$rs = $con->query($sql);
$r = $rs->fetch_object();
error_reporting(error_reporting() & ~E_NOTICE);
?>

<div class="page-wrapper">

    <!-- header mobile-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="index.php">
                        <img src="../images/logo.png" />
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
                        <a href="admin_manage.php">
                            จัดการข้อมูลผู้ดูแลระบบ</a>
                    </li>
                    <li>
                        <a href="teacher_manage.php">
                            จัดการข้อมูลอาจารย์</a>
                    </li>
                    <li>
                        <a href="student_manage.php">
                            จัดการข้อมูลนักศึกษา</a>
                    </li>
                    <li>
                        <a href="subject_manage.php">
                            จัดการข้อมูลวิชา</a>
                    </li>
                    <li>
                        <a href="checkteach_manage.php">
                            ลงทะเบียนการสอน</a>
                    </li>
                    <li>
                        <a href="unit_select.php">
                            จัดการรข้อมูลหน่วยการเรียน</a>
                    </li>
                    <li>
                        <a href="exam_select.php">
                            จัดการข้อมูลข้อสอบ</a>
                    </li>
                    <li>
                        <a href="exam_set_select.php">
                            จัดการข้อมูลชุดข้อสอบ</a>
                    </li>
                    <li>
                        <a href="exam_results_select.php">
                            ผลการสอบนักศึกษา</a>
                    </li>
                    <li>
                        <a href="statistic_manage.php">
                            สถิติการสอบ</a>
                    </li>
                    <li>
                        <a href="system_manage.php">
                            จัดการข้อมูลระบบ</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- end header mobile-->

    <!-- menu sidebar-->
    <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
            <a href="index.php">
                <img src="../images/logo.png" />
            </a>
        </div>
        <div class="menu-sidebar__content js-scrollbar1" style="background-image:url('../images/imagesidebar.jpg')">
            <nav class="navbar-sidebar">
                <ul class="list-unstyled navbar__list">
                    <li>
                        <a href="admin_manage.php">
                            จัดการข้อมูลผู้ดูแลระบบ</a>
                    </li>
                    <li>
                        <a href="teacher_manage.php">
                            จัดการข้อมูลอาจารย์</a>
                    </li>
                    <li>
                        <a href="student_manage.php">
                            จัดการข้อมูลนักศึกษา</a>
                    </li>
                    <li>
                        <a href="subject_manage.php">
                            จัดการข้อมูลวิชา</a>
                    </li>
                    <li>
                        <a href="checkteach_manage.php">
                            ลงทะเบียนการสอน</a>
                    </li>
                    <li>
                        <a href="unit_select.php">
                            จัดการรข้อมูลหน่วยการเรียน</a>
                    </li>
                    <li>
                        <a href="exam_select.php">
                            จัดการข้อมูลข้อสอบ</a>
                    </li>
                    <li>
                        <a href="exam_set_select.php">
                            จัดการข้อมูลชุดข้อสอบ</a>
                    </li>
                    <li>
                        <a href="exam_results_select.php">
                            ผลการสอบนักศึกษา</a>
                    </li>
                    <li>
                        <a href="statistic_select.php">
                            สถิติการสอบ</a>
                    </li>
                    <li>
                        <a href="system_manage.php">
                            จัดการข้อมูลระบบ</a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <!-- end menu sidebar-->

    <!-- page container-->
    <div class="page-container">

        <!-- header desktop-->
        <header class="header-desktop">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap ">
                        <h3>ระบบสอบออนไลน์วิทยาลัยเทคนิคอุบลราชธานี</h3>
                        <div class="header-button">
                            <div class="noti-wrap">
                                <!-- ซ่อน -->
                            </div>
                            <div class="account-wrap">
                                <div class="account-item clearfix js-item-menu">
                                    <div class="image">
                                        <img src="../images/<?= $r->a_image ?>" />
                                    </div>
                                    <div class="content">
                                        <a class="js-acc-btn" href=""><b><?= $r->a_name ?></b></a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="image">
                                                <img src="../images/<?= $r->a_image ?>" />
                                            </div>
                                            <div class="content">
                                                <h5 class="name">
                                                    <label><?= $r->a_name ?></label>
                                                </h5>
                                                <span class="email"><?= $r->a_email ?></span>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__footer">
                                            <a href="profile_form_update.php">
                                                <i class="zmdi zmdi-account"></i>Edit Profile
                                            </a>
                                        </div>
                                        <div class="account-dropdown__footer">
                                            <a href="../logout.php?a=logout_a">
                                                <i class="zmdi zmdi-power"></i>Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- end header desktop-->

        <!-- main content-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">