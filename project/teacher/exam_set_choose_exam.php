<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>ข้อมูลเลือกข้อสอบ</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>
    <?php $es_id = $_GET["exam_set"] ?>
    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mr-auto ml-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title m-b-30">
                                <button type="button" class="btn btn-info" onclick="window.location.href='exam_set_manage.php'">
                                    Back
                                </button>
                                <a class="btn btn-success" href="exam_set_choose_exam_insert.php?exam_set=<?= $es_id ?>">
                                    <i class="fas fa-plus"></i> Choose exam
                                </a>
                                <h3 class="text-center title-2"><b>ข้อมูลเลือกข้อสอบ</b></h3>
                            </div>
                            <div class="row">
                                <?php
                                $query = "SELECT * from tb_exam_set es
                                inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                inner join tb_subject sj on sj.sj_id = ck.sj_id
                                where ck.t_id = '$r->t_id' and es_id = '$es_id'";
                                $result = $con->query($query);
                                $row = $result->fetch_object();
                                ?>
                                <div class="col-md-12 m-b-30">
                                    <div class="row text-center">
                                        <div class="col-lg-6">
                                            <label for="company" class=" form-control-label">วิชา</label><br>
                                            <label for="company" class=" form-control-label"><?= $row->sj_name ?></label>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="company" class=" form-control-label">ชุดข้อสอบ</label><br>
                                            <label for="company" class=" form-control-label"><?= $row->es_name ?></label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="company" class=" form-control-label">จำนวนข้อสอบ</label><br>
                                            <label for="company" class=" form-control-label"><?= $row->es_count ?>/<?= $row->es_sum ?></label>
                                        </div>
                                        <div class="col-lg-1">
                                            <label for="company" class=" form-control-label">คะแนน</label><br>
                                            <label for="company" class=" form-control-label"><?= $row->es_score ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 m-b-30">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <form action="exam_set_choose_exam.php?" method="GET">
                                                <input type="hidden" name="exam_set" value="<?= $es_id ?>">
                                                <input type="text" name="search" class=" form-control">
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="filters">
                                        <div class="table-responsive table--no-card m-b-30">
                                            <table class="table mytable_c table-borderless table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th style="width: 8%">ข้อ</th>
                                                        <th>คำถาม</th>
                                                        <th style="width: 5%">หน่วย</th>
                                                        <th style="width: 12%">ใช้/ไม่ไช้</th>
                                                        <th style="width: 5%">view</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $number = 0;

                                                    // search
                                                    $s_h = $_GET['search'];

                                                    // sql
                                                    $sql1 = "SELECT * from tb_choose_exam ce
                                                    inner join tb_exam_set es on ce.es_id = es.es_id
                                                    inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                                    inner join tb_exam e on ce.e_id = e.e_id
                                                    inner join tb_unit u on u.u_id = e.u_id
                                                    where (e.e_qt like '%" . $s_h . "%')
                                                    and ck.t_id = '$r->t_id'
                                                    and ce.es_id = '$es_id'";
                                                    $rs1 = $con->query($sql1);
                                                    while ($r1 = $rs1->fetch_object()) {
                                                        $number = $number + 1;
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $number ?>
                                                            <td><?php echo nl2br(htmlspecialchars($r1->e_qt, ENT_QUOTES)); ?></td>
                                                            <td class="text-center"><?= $r1->u_unit ?></td>
                                                            <td class="text-center">
                                                                <label class="switch switch-3d switch-primary mr-3">
                                                                    <input type="checkbox" class="switch-input" ce_id=<?= $r1->ce_id ?> checked>
                                                                    <span class="switch-label"></span>
                                                                    <span class="switch-handle"></span>
                                                                </label>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-primary view_data" id="<?= $r1->e_id ?>" data-toggle="modal" data-target="#viewdata">
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
                    $('#exam').html(data);
                }
            });
        });
        $(document).ready(function() {
            $('input[type="checkbox"]').click(function() {
                var ce_id = $(this).attr("ce_id");
                var es_id = <?= $es_id ?>;
                var uncheck = "uncheck";
                if ($(this).is(":not(:checked)")) {
                    $.ajax({
                        url: "exam_set_controller.php",
                        method: "POST",
                        data: {
                            exam_uncheck: uncheck,
                            ce_id: ce_id,
                            es_id: es_id
                        }
                    });
                    window.location.reload();
                }
            });
        });
    </script>

    <script src="../css_script/swal.js"></script>

</body>

</html>