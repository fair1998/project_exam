<?php
session_start();
ob_start();
include("../connect.php");
$id = $_SESSION['id'];
$sql = "SELECT * from tb_student
where s_id = '$id'";
$rs = $con->query($sql);
$r = $rs->fetch_object();

if (isset($_POST["exam_do"])) {
    date_default_timezone_set("Asia/Bangkok");
    $cs_id = $_POST["exam_do"];
    $es_id = $_POST["es_id"];
    $es_score = $_POST["es_score"];
    $es_sum = $_POST["es_sum"];
    $er_time = date("Y-m-d H:i:s");

    $score = $es_score / $es_sum;

    $sql0 = "SELECT * from tb_choose_exam ce 
    inner join tb_exam e  on e.e_id = ce.e_id
    where ce.es_id = '$es_id'";
    $rs0 = $con->query($sql0);
    $er_score = 0;
    $er_correct = 0;
    $er_wrong = 0;
    $i = 1;
    while ($r0 = $rs0->fetch_object()) {
        $c = $_POST[$i];
        $sql1 = "INSERT into tb_exam_answer(cs_id,e_id,ea_aw)values('$cs_id','$r0->e_id','$c')";
        $con->query($sql1);
        if ($r0->e_aw == $c) {
            $er_score = $er_score + $score;
            $er_correct = $er_correct + 1;
        }else{
            $er_wrong = $er_wrong + 1;
        }
        $i++;
    }

    $criterion = $es_score / 2;
    if ($er_score >= $criterion) {
        $er_results = 1;
    } else {
        $er_results = 0;
    }

    $sql2 = "INSERT into tb_exam_results(cs_id,er_score,er_results,er_correct,er_wrong,er_time)
    values('$cs_id','$er_score','$er_results','$er_correct','$er_wrong','$er_time')";
    $con->query($sql2);
    $sql3 = "UPDATE tb_choose_student set cs_status = 1 where cs_id = '$cs_id'";
    $con->query($sql3);

    $sql4 = "SELECT * from tb_exam_results where cs_id = '$cs_id'";
    $rs4 = $con->query($sql4);
    $r4 = $rs4->fetch_object();
    if ($r4 != '') {
        header("location:results.php?er_id=$r4->er_id");
    }
}
if (isset($_POST['view'])) {
    $er_id = $_POST['view'];
    $output = '';
    $sql1 = "SELECT * from tb_exam_results er
    inner join tb_choose_student cs on cs.cs_id = er.cs_id
    inner join tb_term tm on cs.tm_id = tm.tm_id
    inner join tb_student s on s.s_id = cs.s_id
    inner join tb_exam_set es on es.es_id = cs.es_id
    inner join tb_checkteach ck on ck.ck_id = es.ck_id
    inner join tb_teacher t on t.t_id = ck.t_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id
    where er.er_id = '$er_id' and s.s_id = '$r->s_id'
    ";
    $rs1 = $con->query($sql1);
    $r1 = $rs1->fetch_object();
    $output .= '
    <div class="modal-header" align="center">
        <h4 class="modal-title">ผลการสอบ</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid myplr35">
            <div class="row">
                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                    <div class="alert alert-';
    if ($r1->er_results == 1) {
        $output .= 'success';
    } else {
        $output .= 'danger';
    }
    $output .= '" role="alert">
                        <h1 class="text-center">!!! ผลการสอบ !!!</h1><br>
                        <h2 class="text-center">คะแนนที่ได้</h2><br>
                        <h1 class="text-center">' . $r1->er_score . ' / ' . $r1->es_score . ' คะแนน</h1><br>
                        <h2 class="text-center">' . $r1->er_time . '</h2><br>
                        <h2 class="text-center">-----------------------</h2>
                        <h2 class="text-center">';
    if ($r1->er_results == 1) {
        $output .= 'ผ่าน';
    } else {
        $output .= 'ไม่ผ่าน';
    }
    $output .= '</h2>
                        <h2 class="text-center">-----------------------</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <b>วิชา</b> ' . $r1->sj_name . '
                            </div>
                            <div class="col-md-12">
                                <b>ชุดข้อสอบ</b> ' . $r1->es_name . '
                            </div>
                            <div class="col-md-12">
                                <b>อาจารย์ผู้ออกข้อสอบ</b> ' . $r1->t_name . '
                            </div>
                            <div class="col-md-6">
                                <b>ตอบถูก</b> ' . $r1->er_correct . ' ข้อ
                            </div>
                            <div class="col-md-6">
                                <b>ตอบผิด</b> ' . $r1->er_wrong . ' ข้อ
                            </div>
                            <div class="col-md-3">
                                <b>ภาคเรียน</b> ' . $r1->tm_name . '
                            </div>
                            <div class="col-md-3 text-center">
                                <b>จำนวนข้อสอบ</b> ' . $r1->es_sum . '
                            </div>
                            <div class="col-md-3 text-center">
                                <b>คะแนนเต็ม</b> ' . $r1->es_score . '
                            </div>
                            <div class="col-md-3 text-center">
                                <b>สอบครั้งที่</b> ' . $r1->cs_number . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
        ';
    echo $output;
}
if (isset($_POST["choose_term"])) {
    $output = '';
    $sql1 = "SELECT * from tb_exam_results er
    inner join tb_choose_student cs on cs.cs_id = er.cs_id
    inner join tb_term tm on cs.tm_id = tm.tm_id
    where s_id = '$r->s_id' GROUP BY cs.tm_id";
    $rs1 = $con->query($sql1);
    $output .= '
        <option value="">กรุณาเลือกภาคเรียน</option>
        ';
    while ($r1 = $rs1->fetch_object()) {
        $output .= '
        <option value="' . $r1->tm_id . '">' . $r1->tm_name . '</option>
        ';
    }
    echo $output;
}
if (isset($_POST["choose_subject"])) {
    if ($_POST["term"] != '') {
        $term_id = $_POST["term"];
        $term = "and cs.tm_id = '$term_id'";
    }

    $output = '';
    $sql1 = "SELECT * from tb_exam_results er
    inner join tb_choose_student cs on cs.cs_id = er.cs_id
    inner join tb_exam_set es on es.es_id = cs.es_id
    inner join tb_checkteach ck on ck.ck_id = es.ck_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id
    where s_id = '$r->s_id' $term group by ck.sj_id";
    $rs1 = $con->query($sql1);
    $output .= '
        <option value="">กรุณาเลือกวิชา</option>
        ';
    while ($r1 = $rs1->fetch_object()) {
        $output .= '
        <option value="' . $r1->sj_id . '">' . $r1->sj_name . '</option>
        ';
    }
    echo $output;
}
if (isset($_POST["choose_exam_set"])) {

    if ($_POST["term"] != '') {
        $term_id = $_POST["term"];
        $term = "and cs.tm_id = '$term_id'";
    }

    if ($_POST["subject"] != '') {
        $subject_id = $_POST["subject"];
        $subject = "and ck.sj_id = '$subject_id'";
    }

    $output = '';
    $sql1 = "SELECT * from tb_exam_results er
    inner join tb_choose_student cs on cs.cs_id = er.cs_id
    inner join tb_exam_set es on es.es_id = cs.es_id
    inner join tb_checkteach ck on ck.ck_id = es.ck_id
    where s_id = '$r->s_id' $term $subject GROUP BY cs.es_id";
    $rs1 = $con->query($sql1);
    $output .= '
        <option value="">กรุณาเลือกชุดข้อสอบ</option>
        ';
    while ($r1 = $rs1->fetch_object()) {
        $output .= '
        <option value="' . $r1->es_id . '">' . $r1->es_name . '</option>
        ';
    }
    echo $output;
}
