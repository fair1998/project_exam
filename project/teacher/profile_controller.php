<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST['update'])) {

    $t_id = $_POST['t_id'];
    $tel = $_POST['tel'];
    $t_password = $_POST['t_password'];
    $old_t_password = $_POST['old_t_password'];
    $new_t_password = $_POST['new_t_password'];
    $t_image = $_FILES['t_image']['tmp_name'];

    if ($t_password == '') {
        $password = $old_t_password;
    } else {
        $sqlup = "SELECT * from tb_teacher where t_id = '$t_id'";
        $rs = $con->query($sqlup);
        $r = $rs->fetch_object();
        if ($t_password != $r->t_password) {
            $_SESSION['errorupdate'] = $t_id;
            header("location:profile_form_update.php");
            exit;
        } else {
            $password = $new_t_password;
        }
    }



    if ($t_image != '') {
        $ext = pathinfo(basename($_FILES['t_image']['name']), PATHINFO_EXTENSION);
        $new_image = 'img_' . uniqid() . "." . $ext;
        $image_path = "../images/";
        $upload_path = $image_path . $new_image;
    }

    if ($t_image != '') {
        $sql = "update tb_teacher set
        t_password = '$password',
        t_tel = '$tel',
        t_image = '$new_image'
        where t_id = '$t_id'
        ";
    } else {
        $sql = "update tb_teacher set 
        t_tel = '$tel',
        t_password = '$password' 
        where t_id = '$t_id'
    ";
    }
    if ($con->query($sql)) {
        if ($ext != '') {
            move_uploaded_file($t_image, $upload_path);
        }
        $_SESSION['successupdate'] = "$t_id";
        header("location:profile_form_update.php");
    }
}
