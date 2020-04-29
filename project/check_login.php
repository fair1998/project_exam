<?php
session_start();
ob_start();

include("connect.php");


if ($_POST['id_id']) {
    $id = $_POST['id_id'];
    $sql = "INSERT into tbxxx(xxx)values('$id'";

    $con->query($sql);
}

// Admin
$a_id = $_POST['a_id'];
$a_password = $_POST['a_password'];
if (isset($a_id) and isset($a_password)) {
    $sql = "select * from tb_admin where a_id = '$a_id' and a_password = '$a_password'";
    $rs = $con->query($sql);
    $row = mysqli_num_rows($rs);
    if ($row >= 1) {
        if ($r = $rs->fetch_object()) {
            $_SESSION['id'] = $r->a_id;
            header("location:admin");
        }
    } else {
        $_SESSION['error'] = "ข้อผิดพลาด";
        header("location:login_a.php");
    }
}
//teacher
$t_id = $_POST['t_id'];
$t_password = $_POST['t_password'];
if (isset($t_id) and isset($t_password)) {
    $sql = "select * from tb_teacher where t_id = '$t_id' and t_password = '$t_password'";
    $rs = $con->query($sql);
    $row = mysqli_num_rows($rs);
    if ($row >= 1) {
        if ($r = $rs->fetch_object()) {
            $_SESSION['id'] = $r->t_id;
            header("location:teacher");
        }
    } else {
        $_SESSION['error'] = "ข้อผิดพลาด";
        header("location:login_t.php");
    }
}
// Student
$s_id = $_POST['s_id'];
$s_password = $_POST['s_password'];
if (isset($s_id) and isset($s_password)) {
    $sql = "select * from tb_student where s_id = '$s_id' and s_password = '$s_password'";
    $rs = $con->query($sql);
    $row = mysqli_num_rows($rs);
    if ($row >= 1) {
        if ($r = $rs->fetch_object()) {
            $_SESSION['id'] = $r->s_id;
            header("location:student");
        }
    } else {
        $_SESSION['error'] = "ข้อผิดพลาด";
        header("location:login_s.php");
    }
}
