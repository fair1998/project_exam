<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST["view"])) {
    $es_id = $_POST["view"];
    $sql = "SELECT * from tb_exam_set es
    inner join tb_checkteach ck on ck.ck_id = es.ck_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id
    where es_id = '$es_id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">ชุดข้อสอบ</h4>
                </div>
                <form action="exam_set_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>วิชา</strong></label>
                                        <input type="text" disabled value="' . $r->sj_name . '" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>ชุดข้อสอบ	</strong></label>
                                        <input type="text" disabled value="' . $r->es_name . '" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>จำนวนข้อสอบ</strong></label>
                                        <input type="text" disabled value="' . $r->es_count . '/' . $r->es_sum . '" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>คะแนน</strong></label>
                                        <input type="text" disabled value="' . $r->es_score . '" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="delete" value="' . $r->es_id . '">
                        <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["insert"])) {
    $ck_id = $_POST["insert"];
    $es_name = $_POST['es_name'];
    $es_score = $_POST['es_score'];
    $es_sum = $_POST['es_sum'];

    $sql = "INSERT into tb_exam_set(es_name,es_score,es_sum,ck_id)
            values('$es_name','$es_score','$es_sum','$ck_id')";

    if ($con->query($sql)) {
        $_SESSION['successinsert'] = $ck_id;
        header("location:exam_set_manage.php");
    }
}
if (isset($_POST["update"])) {

    $es_id = $_POST["update"];
    $es_name = $_POST['es_name'];
    $es_score = $_POST['es_score'];
    $es_sum = $_POST['es_sum'];

    $sql = "UPDATE tb_exam_set set
    es_name = '$es_name',
    es_score = '$es_score',
    es_sum = '$es_sum'
    where es_id = '$es_id'";

    if ($con->query($sql)) {
        $_SESSION['successupdate'] = $es_id;
        header("location:exam_set_manage.php");
    }
}
if (isset($_POST["delete"])) {

    $es_id = $_POST["delete"];

    $sql = "DELETE from tb_exam_set where es_id = '$es_id'";

    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $es_id;
        header("location:exam_set_manage.php");
    }
}
if (isset($_POST["open_close"])) {

    $es_id = $_POST["open_close"];
    $status = $_POST["status"];

    $sql = "UPDATE tb_exam_set set
    es_status = '$status'
    where es_id = '$es_id'";

    $con->query($sql);
}
if (isset($_POST["exam_check"])) {

    $e_id = $_POST['e_id'];
    $es_id = $_POST['es_id'];

    $sql = "INSERT into tb_choose_exam(e_id,es_id)values('$e_id','$es_id')";
    $con->query($sql);

    $sql1 = "UPDATE tb_exam_set set es_count = es_count + 1 where es_id = '$es_id'";
    $con->query($sql1);
}
if (isset($_POST["exam_uncheck"])) {

    $ce_id = $_POST['ce_id'];
    $es_id = $_POST['es_id'];

    $sql = "DELETE from tb_choose_exam where ce_id = '$ce_id'";
    $con->query($sql);

    $sql1 = "UPDATE tb_exam_set set es_count = es_count - 1 where es_id = '$es_id'";
    $con->query($sql1);
}
if (isset($_GET["random"])) {
    $ck_id = $_GET["ck_id"];
    $es_id = $_GET["es_id"];
    $es_count = $_GET["es_count"];
    $es_sum = $_GET["es_sum"];
    $unit = $_GET["unit"];

    $number = $es_sum - $es_count;

    if ($number != $es_sum) {
        if ($number >= 0) {
            $sql3 = "SELECT * from tb_choose_exam where es_id = '$es_id'";
            $rs3 = $con->query($sql3);
            while ($r3 = $rs3->fetch_object()) {
                $sql4 = "DELETE from tb_choose_exam where es_id = '$es_id' and e_id = '$r3->e_id'";
                $con->query($sql4);
                $sql5 = "UPDATE tb_exam_set set es_count = es_count - 1 where es_id = '$es_id'";
                $con->query($sql5);
            }
        }
    }
    if ($unit != '') {
        $unitsql = " and u_id = '$unit'";
    } else {
        $unitsql = "";
    }

    $sql = "SELECT * from tb_exam where ck_id = '$ck_id' $unitsql ORDER BY RAND() LIMIT $es_sum ";
    $rs = $con->query($sql);
    while ($r = $rs->fetch_object()) {
        $sql1 = "INSERT into tb_choose_exam(e_id,es_id)values('$r->e_id','$es_id')";
        $con->query($sql1);

        $sql2 = "UPDATE tb_exam_set set es_count = es_count + 1 where es_id = '$es_id'";
        $con->query($sql2);
    }

    header("location:exam_set_choose_exam.php?exam_set=$es_id");
}
if (isset($_POST["student_check"])) {

    $s_id = $_POST['s_id'];
    $es_id = $_POST['es_id'];
    $cs_number = $_POST["cs_number"];
    $tm_id = $_POST["tm_id"];

    $sql = "INSERT into tb_choose_student(s_id,es_id,cs_number,tm_id)values('$s_id','$es_id','$cs_number','$tm_id')";
    $con->query($sql);
}
if (isset($_POST["student_uncheck"])) {

    $cs_id = $_POST['cs_id'];

    $sql = "DELETE from tb_choose_student where cs_id = '$cs_id'";
    $con->query($sql);
}
if (isset($_POST["select_all"])) {
    $es_id = $_POST["es_id"];
    $page = $_POST["page"];
    $s_h = $_POST["s_h"];
    $dep = $_POST["dep"];
    $myclass = $_POST["myclass"];
    $group = $_POST["group"];
    $year = $_POST["year"];
    $cs_number = $_POST["cs_number"];
    $tm_id = $_POST["tm_id"];

    $results_per_page = 50;
    $this_page_first_result = ($page - 1) * $results_per_page;

    if ($dep != '') {
        $depsql = "and d_id = '$dep'";
    } else {
        $depsql = "";
    }
    if ($myclass != '') {
        $myclasssql = "and c_id = '$myclass'";
    } else {
        $myclasssql = "";
    }
    if ($group != '') {
        $groupsql = "and s_group = '$group'";
    } else {
        $groupsql = "";
    }
    if ($year != '') {
        $yearsql = "and y_id = '$year'";
    } else {
        $yearsql = "";
    }

    $sql1 = "SELECT * from tb_student
    where (s_id like '%" . $s_h . "%'
    ||s_name like '%" . $s_h . "%')
    $depsql $myclasssql $groupsql $yearsql
    limit " . $this_page_first_result . "," . $results_per_page . "";
    $rs1 = $con->query($sql1);
    while ($r1 = $rs1->fetch_object()) {
        $sql3 = "SELECT * from tb_choose_student
        where es_id = '$es_id' and s_id = '$r1->s_id' and cs_number = '$cs_number' and tm_id = '$tm_id'";
        $rs3 = $con->query($sql3);
        $r3 = mysqli_num_rows($rs3);
        if ($r3 <= 0) {
            $sql2 = "INSERT into tb_choose_student(s_id,es_id,cs_number,tm_id)values('$r1->s_id','$es_id','$cs_number','$tm_id')";
            $con->query($sql2);
        }
    }
}
if (isset($_POST["cancel_all"])) {
    $es_id = $_POST["es_id"];
    $s_h = $_POST["s_h"];
    $dep = $_POST["dep"];
    $myclass = $_POST["myclass"];
    $group = $_POST["group"];
    $year = $_POST["year"];
    $term = $_POST["term"];

    if ($dep != '') {
        $depsql = "and s.d_id = '$dep'";
    } else {
        $depsql = "";
    }
    if ($myclass != '') {
        $myclasssql = "and s.c_id = '$myclass'";
    } else {
        $myclasssql = "";
    }
    if ($group != '') {
        $groupsql = "and s.s_group = '$group'";
    } else {
        $groupsql = "";
    }
    if ($year != '') {
        $yearsql = "and s.y_id = '$year'";
    } else {
        $yearsql = "";
    }
    if ($term != '') {
        $termsql = "and cs.tm_id = '$term'";
    } else {
        $termsql = "";
    }

    $sql3 = "SELECT * from tb_choose_student cs
    inner join tb_student s on s.s_id = cs.s_id
    inner join tb_class c on s.c_id = c.c_id
    inner join tb_department d on s.d_id = d.d_id
    inner join tb_term tm on tm.tm_id = cs.tm_id
    where (s.s_id like '%" . $s_h . "%'
    ||s.s_name like '%" . $s_h . "%')
    and cs.es_id='$es_id' and cs_status='0'
    $depsql $myclasssql $groupsql $yearsql $termsql";
    $rs3 = $con->query($sql3);
    while ($r3 = $rs3->fetch_object()) {
        $sql4 = "DELETE from tb_choose_student where cs_id = '$r3->cs_id'";
        $con->query($sql4);
    }
}
