<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>ทำการสอบ</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php $cs_id = $_GET["cs_id"] ?>

    <section class="welcome p-t-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="user-data m-b-30">
                        <?php
                        $sql1 = "SELECT * from tb_choose_student cs
                        inner join tb_exam_set es on es.es_id = cs.es_id
                        inner join tb_checkteach ck on ck.ck_id = es.ck_id
                        inner join tb_teacher t on t.t_id = ck.t_id
                        inner join tb_subject sj on sj.sj_id = ck.sj_id
                        inner join tb_choose_exam ce on ce.es_id = es.es_id
                        where cs_id = '$cs_id' and cs.s_id = '$r->s_id' and cs_status = 0 and es_status = 1 
                        ";
                        $rs1 = $con->query($sql1);
                        $r1 = $rs1->fetch_object();
                        ?>
                        <div class="filters m-b-20">
                            <div class="row">
                                <div class="col-md-9">
                                    <h4 class="pb-2 display-5">วิชา <?= $r1->sj_name ?></h4>
                                </div>
                                <div class="col-md-3 text-right">
                                    <h4 class="pb-2 display-5">รหัสวิชา <?= $r1->sj_id ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="filters m-b-20">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="pb-2 display-5">ชุดข้อสอบ <?= $r1->es_name ?></h4>
                                </div>
                                <div class="col-md-2 text-right">
                                    <h4 class="pb-2 display-5"> จำนวนข้อสอบ <?= $r1->es_sum ?></h4>
                                </div>
                                <div class="col-md-2 text-right">
                                    <h4 class="pb-2 display-5">คะแนน <?= $r1->es_score ?></h4>
                                </div>
                                <div class="col-md-2 text-right">
                                    <h4 class="pb-2 display-5">ครั้งที่ <?= $r1->cs_number ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="filters m-b-40">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="pb-2 display-5">อาจารย์ <?= $r1->t_name ?></h4>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="filters m-b-20">
                            <form action="exam_controller.php" method="post" class="form-horizontal">
                                <div class="row" style="font-size: 18px;">
                                    <?php
                                    $number = 0;
                                    $sql2 = "SELECT * from tb_choose_exam ce
                                            inner join tb_exam e on e.e_id = ce.e_id
                                            where ce.es_id = '$r1->es_id'";
                                    $rs2 = $con->query($sql2);
                                    while ($r2 = $rs2->fetch_object()) {
                                        $number = $number + 1;
                                    ?>
                                        <div class="col-md-6">
                                            <label class=" form-control-label"><strong><?= $number ?>. </strong><?php echo nl2br(htmlspecialchars($r2->e_qt, ENT_QUOTES)); ?></label>
                                            <?php if ($r2->e_qt_im != '') {
                                                echo '<br><img src="../images/' . $r2->e_qt_im . '">';
                                            } ?>
                                            <div class="form-check">
                                                <div class="radio">
                                                    <label for="radio1<?= $number ?>" class="form-check-label ">
                                                        <input type="radio" id="radio1<?= $number ?>" name="<?= $number ?>" value="1" class="form-check-input" required> ก. <?php echo nl2br(htmlspecialchars($r2->e_c1, ENT_QUOTES)); ?>
                                                    </label>
                                                </div>
                                                <?php if ($r2->e_c1_im != '') {
                                                    echo '<img src="../images/' . $r2->e_c1_im . '">';
                                                } ?>
                                                <div class="radio">
                                                    <label for="radio2<?= $number ?>" class="form-check-label ">
                                                        <input type="radio" id="radio2<?= $number ?>" name="<?= $number ?>" value="2" class="form-check-input"> ข. <?php echo nl2br(htmlspecialchars($r2->e_c2, ENT_QUOTES)); ?>
                                                    </label>
                                                </div>
                                                <?php if ($r2->e_c2_im != '') {
                                                    echo '<img src="../images/' . $r2->e_c2_im . '">';
                                                } ?>
                                                <div class="radio">
                                                    <label for="radio3<?= $number ?>" class="form-check-label ">
                                                        <input type="radio" id="radio3<?= $number ?>" name="<?= $number ?>" value="3" class="form-check-input"> ค. <?php echo nl2br(htmlspecialchars($r2->e_c3, ENT_QUOTES)); ?>
                                                    </label>
                                                </div>
                                                <?php if ($r2->e_c3_im != '') {
                                                    echo '<img src="../images/' . $r2->e_c3_im . '">';
                                                } ?>
                                                <div class="radio">
                                                    <label for="radio4<?= $number ?>" class="form-check-label ">
                                                        <input type="radio" id="radio4<?= $number ?>" name="<?= $number ?>" value="4" class="form-check-input"> ง. <?php echo nl2br(htmlspecialchars($r2->e_c4, ENT_QUOTES)); ?>
                                                    </label>
                                                </div>
                                                <?php if ($r2->e_c4_im != '') {
                                                    echo '<img src="../images/' . $r2->e_c4_im . '">';
                                                } ?>
                                            </div>
                                            <br>
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr>
                        </div>
                        <div class="filters m-b-20">
                            <div class="row">
                                <div class="col-md-12" align="right">
                                    <input type="hidden" name="exam_do" value="<?= $cs_id ?>">
                                    <input type="hidden" name="es_id" value="<?= $r1->es_id ?>">
                                    <input type="hidden" name="es_score" value="<?= $r1->es_score ?>">
                                    <input type="hidden" name="es_sum" value="<?= $r1->es_sum ?>">
                                    <button type="submit" onclick="return confirm('ยืนยันที่จะส่งคำตอบ หรือไม่?')" class="btn btn-outline-success btn-lg active">
                                        ส่งคำตอบ
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php"); ?>
    <?php include("../script.php"); ?>

</body>

</html>