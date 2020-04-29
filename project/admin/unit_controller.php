<?php
session_start();
ob_start();
include("../connect.php");


if (isset($_POST["insert"])) {
    $ck_id = $_POST["insert"];
    $u_unit = $_POST["u_unit"];
    $u_name = $_POST["u_name"];

    $sqlup = "SELECT * from tb_unit where u_unit = '$u_unit' and ck_id = '$ck_id'";
    $rsup = $con->query($sqlup);
    $rup = mysqli_num_rows($rsup);
    if ($rup >= 1) {
        $_SESSION['errorinsert'] = $u_unit;
        $_SESSION['errorname'] = "หน่วย";
        header("location:unit_form_insert.php?ck_id=$ck_id");
        exit;
    }

    $sql = "INSERT into tb_unit(u_unit,u_name,ck_id)
            values('$u_unit','$u_name','$ck_id')";

    if ($con->query($sql)) {
        $_SESSION['successinsert'] = $u_unit;
        header("location:unit_manage.php?ck_id=$ck_id");
    }
}
if (isset($_POST["view"])) {
    $u_id = $_POST["view"];
    $ck_id = $_POST["ck_id"];
    $sql = "SELECT * from tb_unit u
    inner join tb_checkteach ck on ck.ck_id = u.ck_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id
    where u_id = '$u_id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">หน่วยการเรียน</h4>
                </div>
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>วิชา</strong></label>
                                        <input type="text" disabled value="' . $r->sj_name . '" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>หน่วย</strong></label>
                                        <input type="text" disabled value="หน่วยที่ ' . $r->u_unit . ' ' . $r->u_name . '" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <form action="unit_controller.php" method="POST">
                    <div class="modal-footer">
                        <input type="hidden" name="ck_id" value="' . $ck_id . '">
                        <input type="hidden" name="delete" value="' . $r->u_id . '">
                        <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["delete"])) {
    $ck_id = $_POST["ck_id"];
    $u_id = $_POST["delete"];

    $sql = "DELETE from tb_unit where u_id = '$u_id'";

    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $u_id;
        header("location:unit_manage.php?ck_id=$ck_id");
    }
}
if (isset($_POST["update"])) {
    $ck_id = $_POST["ck_id"];
    $u_id = $_POST["update"];
    $u_name = $_POST["u_name"];

    $sql = "UPDATE tb_unit set u_name = '$u_name' where u_id = '$u_id'";

    if ($con->query($sql)) {
        $_SESSION['successupdate'] = $u_id;
        header("location:unit_manage.php?ck_id=$ck_id");
    }
}
