<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST["view"])) {

    $id = $_POST['view'];

    $output = '';
    $query = "SELECT * from tb_teacher t 
    inner join tb_department d on t.d_id = d.d_id
    WHERE t_id = '$id'";
    $result = $con->query($query);

    $output .= '<div class="container-fluid myplr35">
                    <div class="row">';
    while ($row = $result->fetch_object()) {
        $output .= '
        <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
            <div class="form-group" align="center">
                <img src="../images/' . $row->t_image . '" height="30%" width="20%"/>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>รหัสประจำตัวอาจารย์</strong></label>
                <input type="text" value="' . $row->t_id . '" disabled class="form-control">
            </div>
            
            <div class=" form-group">
                <label for="company" class=" form-control-label"><strong>แผนกวิชา</strong></label>
                <input type="text" value="' . $row->d_name . '" disabled class="form-control">
            </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
            <label for="company" class=" form-control-label"><strong>ชื่อ-นามสกุล</strong></label>
            <input type="text" value="' . $row->t_name . '" disabled class="form-control">
        </div>
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>เบอร์โทรศัพท์</strong></label>
                <input type="text" value="' . $row->t_tel . '" disabled class="form-control">
            </div>
        </div>
        ';
        $output .= '</div></div>';
        $output .= '
        <div class="modal-footer">';
        if (isset($_POST["delete_id"])) {
            $output .= '    
            <form method="POST" action="teacher_controller.php">
                <input type="hidden" name="delete" value="delete">
                <input type="hidden" name="id" value="' . $row->t_id . '">
                <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
            </form>
            ';
        }
        $output .= '
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        ';
    }
    echo $output;
}

if (isset($_POST["delete"])) {
    $id = $_POST['id'];
    $sql = "DELETE from tb_teacher where t_id = '$id'";
    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $id;
        header("location:teacher_manage.php");
    }
}

if (isset($_POST["insert"])) {

    $id = $_POST['id'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $d_id = $_POST['d_id'];

    $ext = pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION);
    $new_image = 'img_' . uniqid() . "." . $ext;
    $image_path = "../images/";
    $upload_path = $image_path . $new_image;

    if ($ext == '') {
        $new_image = "ss1.jpg";
    }

    $sql = "INSERT into tb_teacher(t_id,t_password,t_name,t_tel,d_id,t_image)
            values('$id','$password','$name','$tel','$d_id','$new_image')";

    if ($con->query($sql)) {
        if ($new_image != '') {
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
        }
        $_SESSION['successinsert'] = $id;
        header("location:teacher_manage.php");
    } else {
        $_SESSION['errorinsert'] = $id;
        $_SESSION['errorname'] = "ไอดี";
        header("location:teacher_form_insert.php");
    }
}

if (isset($_POST["update"])) {

    $id = $_POST['id'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $d_id = $_POST['d_id'];

    if ($_FILES['image']['tmp_name'] != '') {
        $ext = pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION);
        $new_image = 'img_' . uniqid() . "." . $ext;
        $image_path = "../images/";
        $upload_path = $image_path . $new_image;
    }

    if ($_FILES['image']['tmp_name'] != '') {
        $sql = "UPDATE tb_teacher set 
        t_password = '$password',
        t_name = '$name',
        t_tel = '$tel',
        d_id = '$d_id',
        t_image = '$new_image'
        where t_id = '$id'";
    } else {
        $sql = "UPDATE tb_teacher set
        t_password = '$password',
        t_name = '$name',
        t_tel = '$tel',
        d_id = '$d_id'
        where t_id = '$id'";
    }
    if ($con->query($sql)) {
        if ($ext != '') {
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
        }
        $_SESSION['successupdate'] = $id;
        header("location:teacher_manage.php");
    }
}
