<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST['update'])) {

    $s_id = $_POST['s_id'];
    $s_password = $_POST['s_password'];
    $old_s_password = $_POST['old_s_password'];
    $new_s_password = $_POST['new_s_password'];
    $s_image = $_FILES['s_image']['tmp_name'];

    if ($s_password == '') {
        $password = $old_s_password;
    } else {
        $sqlup = "SELECT * from tb_student where s_id = '$s_id'";
        $rs = $con->query($sqlup);
        $r = $rs->fetch_object();
        if ($s_password != $r->s_password) {
            $_SESSION['errorupdate'] = $s_id;
            header("location:profile_form_update.php");
            exit;
        } else {
            $password = $new_s_password;
        }
    }



    if ($s_image != '') {
        $ext = pathinfo(basename($_FILES['s_image']['name']), PATHINFO_EXTENSION);
        $new_image = 'img_' . uniqid() . "." . $ext;
        $image_path = "../images/";
        $upload_path = $image_path . $new_image;
    }

    if ($s_image != '') {
        $sql = "update tb_student set
    s_password = '$password',
    s_image = '$new_image'
    where s_id = '$s_id'
    ";
    } else {
        $sql = "update tb_student set s_password = '$password' where s_id = '$s_id'
    ";
    }

    if ($con->query($sql)) {
        if ($ext != '') {
            move_uploaded_file($s_image, $upload_path);
        }
        $_SESSION['successupdate'] = "$s_id";
        header("location:profile_form_update.php");
    }
}
