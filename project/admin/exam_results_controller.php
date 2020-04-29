<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST['view_ids'])) {
    $s_id = $_POST['view_ids'];
    $es_id = $_POST['view_ides'];
    $tm_id = $_POST['view_idtm'];
    $delete_id = $_POST['delete_id'];
    $output = '';
    $sql1 = "SELECT * from tb_exam_results er
    inner join tb_choose_student cs on cs.cs_id = er.cs_id
    inner join tb_term tm on cs.tm_id = tm.tm_id
    inner join tb_student s on s.s_id = cs.s_id
    inner join tb_year y on y.y_id = s.y_id
    inner join tb_department d on d.d_id = s.d_id
    inner join tb_class c on c.c_id = s.c_id
    inner join tb_exam_set es on es.es_id = cs.es_id
    inner join tb_checkteach ck on ck.ck_id = es.ck_id
    inner join tb_teacher t on t.t_id = ck.t_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id
    where cs.s_id = '$s_id' and cs.es_id = '$es_id' and cs.tm_id = '$tm_id'
    order by er_time DESC ";
    $output .= '
    <div class="modal-header" align="center">
        <h4 class="modal-title">ผลการสอบ</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid myplr35">
            <div class="row">
    ';
    $rs1 = $con->query($sql1);
    while ($r1 = $rs1->fetch_object()) {
        $output .= '
                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                    <div class="alert alert-';
        if ($r1->er_results == 1) {
            $output .= 'success';
        } else {
            $output .= 'danger';
        }
        $output .= '" role="alert">
    <div class="row">
    <div class="col-md-6">
    <div class="row">
        <div class="col-md-12">
            <b>รหัสนักศึกษา</b> ' . $r1->s_id . '
        </div>
        <div class="col-md-12">
            <b>ชื่อนักศึกษา</b> ' . $r1->s_name . '
        </div>
        <div class="col-md-12">
            <b>แผนกวิชา</b> ' . $r1->d_name . '
        </div>
        <div class="col-md-6">
            <b>ระดับชั้น</b> ' . $r1->c_name . '
        </div>
        <div class="col-md-6">
            <b>กลุ่ม</b> ' . $r1->s_group . '
        </div>
        <div class="col-md-12">
            <b>ปีการศึกษา</b> ' . $r1->y_name . '
        </div>
    </div>
    </div>
    <div class="col-md-6">
    <div class="row">
                        <div class="col-md-12 text-center">
                            <b>!!! ผลการสอบ !!!</b>
                        </div>
                        <div class="col-md-12 text-center">
                            <b>คะแนนที่ได้</b>
                        </div>
                        <div class="col-md-12 text-center">
                        <b> ' . $r1->er_score . ' / ' . $r1->es_score . ' คะแนน</b>
                        </div>
                        <div class="col-md-12 text-center">
                            <b>' . $r1->er_time . '</b>
                        </div>
                        <div class="col-md-12 text-center"><b>';
        if ($r1->er_results == 1) {
            $output .= 'ผ่าน';
        } else {
            $output .= 'ไม่ผ่าน';
        }
        $output .= '</b></div></div></div></div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <b>วิชา</b> ' . $r1->sj_name . '
                            </div>
                            <div class="col-md-12">
                                <b>ชุดข้อสอบ</b> ' . $r1->es_name . '
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
                        </div>';
        if (isset($_POST["delete_id"])) {
            $output .= '
                        <div class="row">
                            <div class="col-md-12" align="right">
                            <br>
                                <form method="POST" action="exam_results_controller.php">
                                    <input type="hidden" name="delete" value="' . $r1->cs_id . '">
                                    <input type="hidden" name="view_idck" value="' . $delete_id . '">
                                    <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
                                </form>
                            </div>
                        </div>
                        ';
        }
        $output .= '
                    </div>
                </div>';
    }
    $output .= '
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
        ';
    echo $output;
}
if (isset($_POST['delete'])) {
    $cs_id = $_POST["delete"];
    $ck_id = $_POST["view_idck"];

    $sql1 = "DELETE from tb_exam_answer where cs_id = $cs_id";
    $con->query($sql1);

    $sql2 = "DELETE from tb_exam_results where cs_id = $cs_id";
    $con->query($sql2);

    $sql3 = "DELETE from tb_choose_student where cs_id = $cs_id";
    $con->query($sql3);

    $_SESSION['successdelete'] = $cs_id;
    header("location:exam_results_manage.php?ck_id=$ck_id");
}
