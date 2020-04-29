<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>ผลสอบ</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>
    <?php
    $er_id = $_GET["er_id"];
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
    ?>
    <section class="statistic-chart">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mr-auto ml-auto">
                    <div class="alert alert-<?php
                                            if ($r1->er_results == 1) {
                                                echo "success";
                                            } else {
                                                echo "danger";
                                            } ?>" role="alert">
                        <h1 class="text-center">!!! ผลการสอบ !!!</h1><br>
                        <h2 class="text-center">คะแนนที่ได้</h2><br>
                        <h1 class="text-center"><?= $r1->er_score ?> / <?= $r1->es_score ?> คะแนน</h1><br>
                        <h2 class="text-center"><?= $r1->er_time ?></h2><br>
                        <h2 class="text-center">-----------------------</h2>
                        <h2 class="text-center"><?php
                                                if ($r1->er_results == 1) {
                                                    echo "ผ่าน";
                                                } else {
                                                    echo "ไม่ผ่าน";
                                                } ?></h2>
                        <h2 class="text-center">-----------------------</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <b>วิชา</b> <?= $r1->sj_name ?>
                            </div>
                            <div class="col-md-12">
                                <b>ชุดข้อสอบ</b> <?= $r1->es_name ?>
                            </div>
                            <div class="col-md-12">
                                <b>อาจารย์ผู้ออกข้อสอบ</b> <?= $r1->t_name ?>
                            </div>
                            <div class="col-md-6">
                                <b>ตอบถูก</b> <?= $r1->er_correct ?>
                            </div>
                            <div class="col-md-6">
                                <b>ตอบผิด</b> <?= $r1->er_wrong ?>
                            </div>
                            <div class="col-md-3">
                                <b>ภาคเรียน</b> <?= $r1->tm_name; ?>
                            </div>
                            <div class="col-md-3 text-center">
                                <b>จำนวนข้อสอบ</b> <?= $r1->es_sum ?>
                            </div>
                            <div class="col-md-3 text-center">
                                <b>คะแนนเต็ม</b> <?= $r1->es_score ?>
                            </div>
                            <div class="col-md-3 text-center">
                                <b>สอบครั้งที่</b> <?= $r1->cs_number ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <h1 align="center"><a href="index.php">กลับไปหน้าแรก</a></h1>
        </div>
    </section>

    <?php include("footer.php"); ?>
    <?php include("../script.php"); ?>
</body>

</html>