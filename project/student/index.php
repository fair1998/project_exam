<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>หน้าหลัก</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>

    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2"><b>รายการที่ต้องสอบ</b></h3>
                            </div>
                            <hr>
                            <div class="filters">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table mytable_c table-borderless table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>ชื่อชุดข้อสอบ</th>
                                                <th>อาจารย์</th>
                                                <th>จำนวนข้อสอบ</th>
                                                <th>คะแนน</th>
                                                <th>ครั้งที่</th>
                                                <th style="width: 5%">สอบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // sql
                                            $sql1 = "SELECT * from tb_choose_student cs
                                            inner join tb_exam_set es on es.es_id = cs.es_id
                                            inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                            inner join tb_teacher t on t.t_id = ck.t_id
                                            where cs.s_id = '$r->s_id' and cs_status = 0 and es_status = 1";
                                            $rs1 = $con->query($sql1);
                                            while ($r1 = $rs1->fetch_object()) {
                                            ?>
                                                <tr class="text-center">
                                                    <td><?= $r1->es_name ?></td>
                                                    <td><?= $r1->t_name ?></td>
                                                    <td><?= $r1->es_sum ?></td>
                                                    <td><?= $r1->es_score ?></td>
                                                    <td><?= $r1->cs_number ?></td>
                                                    <td>
                                                        <a href="exam_do.php?cs_id=<?= $r1->cs_id ?>" class="btn btn-info">
                                                            <i class="fas fa-fw fa-hand-point-down"></i>
                                                        </a>
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
                <div class="col-lg-4">
                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                        <div class="au-card-title" style="background-image:url('../images/bg-title-01.jpg');">
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                สอบ 4 รายการล่าสุด</h3>
                        </div>
                        <div class="js-scrollbar3">
                            <?php
                            $sql2 = "SELECT * from tb_exam_results er
                            inner join tb_choose_student cs on cs.cs_id = er.cs_id
                            inner join tb_exam_set es on es.es_id = cs.es_id
                            where cs.s_id = '$r->s_id' order by er.er_id DESC LIMIT 0,4
                            ";
                            $rs2 = $con->query($sql2);
                            while ($r2 = $rs2->fetch_object()) {
                            ?>
                                <div class="au-task__item au-task__item--<?php if ($r2->er_results == 1) {
                                                                                echo "success";
                                                                            } else {
                                                                                echo "danger";
                                                                            } ?>">
                                    <div class="au-task__item-inner">
                                        <h5 class="task">
                                            <button class="view_data" id="<?= $r2->er_id ?>" data-toggle="modal" data-target="#viewdata">
                                                <b>ชุด </b><?= $r2->es_name ?></button>
                                        </h5>
                                        <span class="time"><?= $r2->er_time ?> สอบครั้งที่ <?= $r2->cs_number ?></span>
                                    </div>
                                </div>
                            <?php } ?>
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
            <div class="modal-content" id="mydetail">

            </div>
        </div>
    </div>
    <!-- end modal -->

    <?php include("../script.php"); ?>

    <!-- script -->
    <script>
        $(document).on('click', '.view_data', function() {
            var view_id = $(this).attr("id");
            $.ajax({
                url: "exam_controller.php",
                method: "POST",
                data: {
                    view: view_id
                },
                success: function(data) {
                    $('#mydetail').html(data);
                }
            });
        });
    </script>
    <!-- end script -->
</body>

</html>