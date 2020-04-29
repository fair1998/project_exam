<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>อัตราการตอบถูก</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>
    <?php
    $es_id = $_GET['exam_set'];
    $query = "SELECT * from tb_exam_set es
    inner join tb_checkteach ck on ck.ck_id = es.ck_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id
    where ck.t_id = '$r->t_id' and es.es_id = '$es_id'";
    $result = $con->query($query);
    $row = $result->fetch_object();

    $sql2 = "SELECT COUNT(*) AS full from tb_exam_results er
    inner join tb_choose_student cs on cs.cs_id = er.cs_id
    WHERE es_id = '$row->es_id'";
    $rs2 = $con->query($sql2);
    $r2 = $rs2->fetch_object();
    $full = $r2->full;

    $sql3 = "SELECT COUNT(*) AS past from tb_exam_results er
    inner join tb_choose_student cs on cs.cs_id = er.cs_id
    WHERE es_id = '$row->es_id' AND er_results = '1'";
    $rs3 = $con->query($sql3);
    $r3 = $rs3->fetch_object();
    $past = $r3->past;

    $sql4 = "SELECT COUNT(*) AS not_passed from tb_exam_results er
    inner join tb_choose_student cs on cs.cs_id = er.cs_id
    WHERE es_id = '$row->es_id' AND er_results = '0'";
    $rs4 = $con->query($sql4);
    $r4 = $rs4->fetch_object();
    $not_passed = $r4->not_passed;

    if ($full != 0) {
        $ave = ($past / $full) * 100;
    } else {
        $ave = 0;
    }
    ?>
    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mr-auto ml-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title m-b-30">
                                <button type="button" class="btn btn-info m-b-20" onclick="window.location.href='statistic_manage.php'">
                                    Back
                                </button>
                                <h3 class="text-center m-b-20">อัตราการตอบถูก</h3>
                                <h4 class="text-center m-b-20">วิชา : <?= $row->sj_name ?></h4>
                                <h4 class="text-center m-b-20">ชุดข้อสอบ : <?= $row->es_name ?></h4>
                                <div class="row text-center">
                                    <div class="col-lg-3">
                                        <label class=" form-control-label"><b>อัตราการสอบผ่าน</b></label><br>
                                        <label class=" form-control-label"><?php echo number_format($ave) ?>%</label>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class=" form-control-label"><b>ทั้งหมด</b></label><br>
                                        <label class=" form-control-label"><?= $full ?></label>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class=" form-control-label"><b>ผ่าน</b></label><br>
                                        <label class=" form-control-label"><?= $past ?></label>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class=" form-control-label"><b>ไม่ผ่าน</b></label><br>
                                        <label class=" form-control-label"><?= $not_passed ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="filters">
                                        <div class="table-responsive table--no-card m-b-30">
                                            <table class="table mytable_c table-borderless table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th style="width: 7%">ข้อ</th>
                                                        <th>คำถาม</th>
                                                        <th style="width: 12%">อัตราการตอบถูก</th>
                                                        <th style="width: 5%">View</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $number = 0;

                                                    // sql
                                                    $sql1 = "SELECT * from  tb_choose_exam ce
                                                    inner join tb_exam e on e.e_id = ce.e_id
                                                    WHERE es_id = '$row->es_id'";
                                                    $rs1 = $con->query($sql1);
                                                    while ($r1 = $rs1->fetch_object()) {
                                                        $number = $number + 1;
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $number ?></td>
                                                            <td><?php echo nl2br(htmlspecialchars($r1->e_qt, ENT_QUOTES)); ?></td>
                                                            <?php
                                                            $sqlsm = "SELECT COUNT(*) AS s_m FROM tb_exam_answer ea
                                                            INNER JOIN tb_choose_student cs ON cs.cs_id = ea.cs_id
                                                            where e_id = '$r1->e_id' and es_id = '$row->es_id'";
                                                            $rssm = $con->query($sqlsm);
                                                            $rsm = $rssm->fetch_object();

                                                            $sum = $rsm->s_m;

                                                            $sqlea = "SELECT COUNT(*) AS c_a FROM tb_exam_answer ea
                                                            INNER JOIN tb_choose_student cs ON cs.cs_id = ea.cs_id
                                                            where e_id = '$r1->e_id' and es_id = '$row->es_id' and ea_aw = '$r1->e_aw'";
                                                            $rsea = $con->query($sqlea);
                                                            $rea = $rsea->fetch_object();

                                                            $correct_answer = $rea->c_a;

                                                            if ($sum != 0) {
                                                                $aw = ($correct_answer / $sum) * 100;
                                                            } else {
                                                                $aw = 0;
                                                            }

                                                            ?>
                                                            <td class="text-center"><?php echo number_format($aw) ?>%</td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-primary view_data" id="<?= $r1->e_id ?>" sum="<?= $sum ?>" es_id="<?= $row->es_id ?>" data-toggle="modal" data-target="#viewdata">
                                                                    <i class="fas fa-fw fa-eye"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include("footer.php"); ?>

    <!-- modal -->
    <div class="modal fade" id="viewdata" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="exam">

            </div>
        </div>
    </div>
    <!-- end modal -->

    <?php include("../script.php"); ?>

    <!-- script -->
    <script>
        $(document).on('click', '.view_data', function() {
            var view_id = $(this).attr("id");
            var sum = $(this).attr("sum");
            var es_id = $(this).attr("es_id");
            $.ajax({
                url: "statistic_controller.php",
                method: "POST",
                data: {
                    view: view_id,
                    sum: sum,
                    es_id: es_id
                },
                success: function(data) {
                    $('#exam').html(data);
                }
            });
        });
    </script>
    <!-- end script -->
</body>

</html>