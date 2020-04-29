<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST["view"])) {

    $id = $_POST["view"];

    $output = '';
    $query = "SELECT * from tb_subject WHERE sj_id = '$id'";
    $result = $con->query($query);
    $output .= '<div class="container-fluid myplr35">
                    <div class="row">';
    $row = $result->fetch_object();
    if ($row->sj_class == 1) {
        $class = "ปวช";
    } elseif ($row->sj_class == 2) {
        $class = "ปวส";
    } else {
        $class = "ป.ตรี";
    }
    $output .= '
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="company" class=" form-control-label"><strong>รหัสวิชา</strong></label>
                    <input type="text" value="' . $row->sj_id . '" Disabled class="form-control">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="company" class=" form-control-label"><strong>หน่วยกิต</strong></label>
                    <input type="text" value="' . $row->sj_credit . '" Disabled class="form-control">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="company" class=" form-control-label"><strong>ระดับชั้น</strong></label>
                    <input type="text" value="' . $class . '" Disabled class="form-control">
                </div>
            </div>
            <div class="col col-lg-12">
                <div class="form-group">
                    <label for="company" class=" form-control-label"><strong>ชื่อวิชา</strong></label>
                    <textarea rows="2"  Disabled class="form-control">' . $row->sj_name . '</textarea>
                </div>
            </div>
        ';
    $output .= '</div></div>';
    $output .= '
        <div class="modal-footer">';
    if (isset($_POST["delete_id"])) {
        $output .= '    
            <form method="POST" action="subject_controller.php">
                <input type="hidden" name="delete" value="delete">
                <input type="hidden" name="id" value="' . $row->sj_id . '">
                <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
            </form>
            ';
    }
    $output .= '
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        ';
    echo $output;
}
if (isset($_POST["delete"])) {
    $id = $_POST['id'];
    $sql = "DELETE from tb_subject where sj_id = '$id'";
    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $id;
        header("location:subject_manage.php");
    }
}

if (isset($_POST["insert"])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $credit = $_POST['credit'];
    $class = $_POST['class'];

    $sql = "INSERT into tb_subject(sj_id,sj_name,sj_credit,sj_class)
            values('$id','$name','$credit','$class')";

    if ($con->query($sql)) {
        $_SESSION['successinsert'] = $id;
        header("location:subject_manage.php");
    } else {
        $_SESSION['errorinsert'] = $id;
        $_SESSION['errorname'] = "รหัสวิชา";
        header("location:subject_form_insert.php");
    }
}

if (isset($_POST["update"])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $credit = $_POST['credit'];
    $class = $_POST['class'];

    $sql = "UPDATE tb_subject set 
        sj_name = '$name',
        sj_credit = '$credit',
        sj_class = '$class'
        where sj_id = '$id'";

    if ($con->query($sql)) {
        $_SESSION['successupdate'] = $id;
        header("location:subject_manage.php");
    }
}
