<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST['update'])) {

    $a_id = $_POST['a_id'];
    $a_password = $_POST['a_password'];
    $old_a_password = $_POST['old_a_password'];
    $new_a_password = $_POST['new_a_password'];
    $a_name = $_POST['a_name'];
    $a_email = $_POST['a_email'];
    $a_tel = $_POST['a_tel'];
    $a_image = $_FILES['a_image']['tmp_name'];

    if ($a_password == '') {
        $password = $old_a_password;
    } else {
        $sqlup = "SELECT * from tb_admin where a_id = '$a_id'";
        $rs = $con->query($sqlup);
        $r = $rs->fetch_object();
        if ($a_password != $r->a_password) {
            $_SESSION['errorupdate'] = $a_id;
            header("location:profile_form_update.php");
            exit;
        } else {
            $password = $new_a_password;
        }
    }



    if ($a_image != '') {
        $ext = pathinfo(basename($_FILES['a_image']['name']), PATHINFO_EXTENSION);
        $new_image = 'img_' . uniqid() . "." . $ext;
        $image_path = "../images/";
        $upload_path = $image_path . $new_image;
    }

    if ($a_image != '') {
        $sql = "update tb_admin set
    a_password = '$password',
    a_name = '$a_name',
    a_email = '$a_email',
    a_tel = '$a_tel',
    a_image = '$new_image'
    where a_id = '$a_id'
    ";
    } else {
        $sql = "update tb_admin set
    a_password = '$password',
    a_name = '$a_name',
    a_email = '$a_email',
    a_tel = '$a_tel'
    where a_id = '$a_id'
    ";
    }

    if ($con->query($sql)) {
        if ($ext != '') {
            move_uploaded_file($a_image, $upload_path);
        }
        $_SESSION['successupdate'] = "$a_id";
        header("location:profile_form_update.php");
    }
}
