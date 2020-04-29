<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST["view"])) {
    $output = '';
    $query = "SELECT * from tb_student s 
    inner join tb_department d on s.d_id = d.d_id
    inner join tb_class c on s.c_id = c.c_id
    inner join tb_year y on s.y_id = y.y_id
    WHERE s.s_id = '" . $_POST["view"] . "'";
    $result = $con->query($query);
    $output .= '<div class="container-fluid myplr35">
                    <div class="row">';
    while ($row = $result->fetch_object()) { 
        $output .= '
        <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
            <div class="form-group" align="center">
                <img src="../images/' . $row->s_image . '" height="30%" width="20%"/>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>รหัสประจำตัวนักศึกษา</strong></label>
                <input type="text" value="' . $row->s_id . '" disabled class="form-control">
            </div>
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>ระดับชั้น</strong></label>
                <input type="text" value="' . $row->c_name . '" disabled class="form-control">
            </div>
            <div class=" form-group">
                <label for="company" class=" form-control-label"><strong>แผนกวิชา</strong></label>
                <input type="text" value="' . $row->d_name . '" disabled class="form-control">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>ชื่อ-นามสกุล</strong></label>
                <input type="text" value="' . $row->s_name . '" disabled class="form-control">
            </div>
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>กลุ่ม</strong></label>
                <input type="text" value="' . $row->s_group . '" disabled class="form-control">
            </div>
            <div class="form-group">
                <label for="company" class=" form-control-label"><strong>ปีการศึกษา</strong></label>
                <input type="text" value="' . $row->y_name . '" disabled class="form-control">
            </div>
            
        </div>
        ';
        $output .= '</div></div>';
        $output .= '
        <div class="modal-footer">';
        if (isset($_POST["delete_id"])) {
            $output .= '    
            <form method="POST" action="student_controller.php">
                <input type="hidden" name="delete" value="delete">
                <input type="hidden" name="id" value="' . $row->s_id . '">
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
    $sql = "DELETE from tb_student where s_id = '" . $_POST['id'] . "'";
    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $_POST["id"];
        header("location:student_manage.php");
    }
}

if (isset($_POST["insert"])) {

    $ext = pathinfo(basename($_FILES['s_image']['name']), PATHINFO_EXTENSION);
    $new_image = 'img_' . uniqid() . "." . $ext;
    $image_path = "../images/";
    $upload_path = $image_path . $new_image;

    if ($ext == '') {
        $new_image = "ss1.jpg";
    }

    $sql = "insert into tb_student(s_id,s_password,s_name,c_id,s_group,d_id,y_id,s_image)
        values(
            '" . $_POST['s_id'] . "',
            '" . $_POST['s_password'] . "',
            '" . $_POST['s_name'] . "',
            '" . $_POST['c_id'] . "',
            '" . $_POST['s_group'] . "',
            '" . $_POST['d_id'] . "',
            '" . $_POST['y_id'] . "',
            '$new_image')";
    if ($con->query($sql)) {
        if ($new_image != '') {
            move_uploaded_file($_FILES['s_image']['tmp_name'], $upload_path);
        }
        $_SESSION['successinsert'] = $_POST['s_id'];
        header("location:student_manage.php");
    } else {
        $_SESSION['errorinsert'] = $_POST['s_id'];
        $_SESSION['errorname'] = "ไอดี";
        header("location:student_form_insert.php");
    }
}

if (isset($_POST["update"])) {


    if ($_FILES['s_image']['tmp_name'] != '') {
        $ext = pathinfo(basename($_FILES['s_image']['name']), PATHINFO_EXTENSION);
        $new_image = 'img_' . uniqid() . "." . $ext;
        $image_path = "../images/";
        $upload_path = $image_path . $new_image;
    }

    if ($_FILES['s_image']['tmp_name'] != '') {
        $sql = "update tb_student set
            s_password = '" . $_POST['s_password'] . "',
            s_name = '" . $_POST['s_name'] . "',
            c_id = '" . $_POST['c_id'] . "',
            s_group = '" . $_POST['s_group'] . "',
            d_id = '" . $_POST['d_id'] . "',
            y_id = '" . $_POST['y_id'] . "',
            s_image = '$new_image'
            where s_id = '" . $_POST['id'] . "'
        ";
    } else {
        $sql = "update tb_student set
            s_password = '" . $_POST['s_password'] . "',
            s_name = '" . $_POST['s_name'] . "',
            c_id = '" . $_POST['c_id'] . "',
            s_group = '" . $_POST['s_group'] . "',
            d_id = '" . $_POST['d_id'] . "',
            y_id = '" . $_POST['y_id'] . "'
            where s_id = '" . $_POST['id'] . "'
        ";
    }
    if ($con->query($sql)) {
        if ($new_image != '') {
            move_uploaded_file($_FILES['s_image']['tmp_name'], $upload_path);
        }
        $_SESSION['successupdate'] = $_POST['id'];
        header("location:student_manage.php");
    }
}
