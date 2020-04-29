<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST['view'])) {
    $id = $_POST['view'];
    $output = '';
    $query = "SELECT * from tb_admin WHERE a_id = '$id'";
    $result = $con->query($query);
    $output .= '
        <div class="modal-header" align="center">
            <h4 class="modal-title">ข้อมูลผู้ดูแลระบบ</h4>
        </div>
        <div class="modal-body">
        <div class="container-fluid myplr35">
            <div class="row">';
    while ($row = $result->fetch_object()) {
        $output .= '
        <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
            <div class="form-group" align="center">
                <img src="../images/' . $row->a_image . '" height="30%" width="20%"/>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>ไอดี</strong></label>
                <input type="text" value="' . $row->a_id . '" disabled class="form-control">
            </div>
            <div class=" form-group">
                <label for="company" class=" form-control-label"><strong>เบอร์โทรศัพท์</strong></label>
                <input type="text" value="' . $row->a_tel . '" disabled class="form-control">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>ชื่อ-นามสกุล</strong></label>
                <input type="text" value="' . $row->a_name . '" disabled class="form-control">
            </div>
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>อีเมล์</strong></label>
                <input type="text" value="' . $row->a_email . '" disabled class="form-control">
            </div>
        </div>
        </div>
        ';
        $output .= '</div></div>';
        $output .= '
        <div class="modal-footer">
            <form method="POST" action="admin_controller.php">
                <input type="hidden" name="delete" value="delete">
                <input type="hidden" name="id" value="' . $row->a_id . '">
                <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        ';
    }
    echo $output;
}

if (isset($_POST["insert"])) {

    $ext = pathinfo(basename($_FILES['a_image']['name']), PATHINFO_EXTENSION);
    $new_image = 'img_' . uniqid() . "." . $ext;
    $image_path = "../images/";
    $upload_path = $image_path . $new_image;

    if ($ext == '') {
        $new_image = "ss1.jpg";
    }

    $sql = "INSERT into tb_admin(a_id,a_password,a_name,a_email,a_tel,a_image)
        values(
            '" . $_POST['a_id'] . "',
            '" . $_POST['a_password'] . "',
            '" . $_POST['a_name'] . "',
            '" . $_POST['a_email'] . "',
            '" . $_POST['a_tel'] . "',
            '$new_image')";

    if ($con->query($sql)) {
        if ($ext != '') {
            // move_uploaded_file($a_image_path, "image/" . $a_image);
            move_uploaded_file($_FILES['a_image']['tmp_name'], $upload_path);
        }
        $_SESSION['successinsert'] = $_POST['a_id'];
        header("location:admin_manage.php");
    } else {
        $_SESSION['errorinsert'] = $_POST['a_id'];
        $_SESSION['errorname'] = "ไอดี";
        header("location:admin_form_insert.php");
    }
}

if (isset($_POST["update"])) {

    if ($_FILES['a_image']['tmp_name'] != '') {
        $ext = pathinfo(basename($_FILES['a_image']['name']), PATHINFO_EXTENSION);
        $new_image = 'img_' . uniqid() . "." . $ext;
        $image_path = "../image/";
        $upload_path = $image_path . $new_image;
    }

    if ($_FILES['a_image']['tmp_name'] != '') {
        $sql = "update tb_admin set
            a_password = '" . $_POST['a_password'] . "',
            a_name = '" . $_POST['a_name'] . "',
            a_email = '" . $_POST['a_email'] . "',
            a_tel = '" . $_POST['a_tel'] . "',
            a_image = '$new_image'
            where a_id = '" . $_POST['id'] . "'
        ";
    } else {
        $sql = "update tb_admin set
            a_password = '" . $_POST['a_password'] . "',
            a_name = '" . $_POST['a_name'] . "',
            a_email = '" . $_POST['a_email'] . "',
            a_tel = '" . $_POST['a_tel'] . "'
            where a_id = '" . $_POST['id'] . "'
        ";
    }
    if ($con->query($sql)) {
        if ($ext != '') {
            move_uploaded_file($_FILES['a_image']['tmp_name'], $upload_path);
        }
        $_SESSION['successupdate'] = $_POST['id'];
        header("location:admin_manage.php");
    }
}

if (isset($_POST["delete"])) {
    $sql = "DELETE from tb_admin where a_id = '" . $_POST['id'] . "'";
    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $_POST["id"];
        header("location:admin_manage.php");
    }
}
