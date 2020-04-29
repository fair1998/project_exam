<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>เลือกข้อสอบ</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>
    <?php $es_id = $_GET["exam_set"];
    $query = "SELECT * from tb_exam_set es
    inner join tb_checkteach ck on ck.ck_id = es.ck_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id
    where ck.t_id = '$r->t_id' and es_id = '$es_id'";
    $result = $con->query($query);
    $row = $result->fetch_object(); ?>
    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mr-auto ml-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title m-b-30">
                                <button type="button" class="btn btn-info" onclick="window.location.href='exam_set_choose_exam.php?exam_set=<?= $es_id ?>'">
                                    Back
                                </button>
                                <a class="btn btn-success" href="exam_form_insert.php?exam_set=<?= $es_id ?>&checkteach=<?= $row->ck_id ?>">
                                    <i class="fas fa-plus"></i> Add exam
                                </a>
                                <h3 class="text-center title-2"><b>เลือกข้อสอบ</b></h3>
                            </div>
                            <div class="row">
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
                                            <form action="exam_set_choose_exam_insert.php?" method="GET">
                                                <select name="unit" class="form-control" id="unit">
                                                    <option value="">กรุณาเลือกหน่วย</option>
                                                    <?php
                                                    $unit = $_GET['unit'];
                                                    $sqlu = "SELECT * from tb_unit u
                                                    inner join tb_checkteach ck on ck.ck_id = u.ck_id
                                                    where u.ck_id = '$row->ck_id' order by u_unit ";
                                                    $rsu = $con->query($sqlu);
                                                    while ($ru = $rsu->fetch_object()) {
                                                    ?>
                                                        <option value="<?= $ru->u_id; ?>" <?php if ($unit == $ru->u_id) {
                                                                                                echo "selected";
                                                                                            } ?>>หน่วยที่ <?= $ru->u_unit; ?> <?= $ru->u_name; ?></option>
                                                    <?php }; ?>
                                                </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="hidden" name="exam_set" value="<?= $es_id ?>">
                                            <input type="text" name="search" class=" form-control">
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                            </form>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="exam_set_controller.php?random=random&ck_id=<?= $row->ck_id ?>&es_id=<?= $es_id ?>&es_count=<?= $row->es_count ?>&es_sum=<?= $row->es_sum ?>&unit=<?= $unit ?>" class="btn btn-warning form-control">
                                                <i class="fas fa-fw fa-sync"></i> Random
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="filters">
                                        <div class="table-responsive table--no-card m-b-30">
                                            <table class="table mytable_c table-borderless table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th style="width: 5%">หน่วย</th>
                                                        <th>คำถาม</th>
                                                        <th style="width: 12%">ใช้/ไม่ไช้</th>
                                                        <th style="width: 5%">view</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // page
                                                    $results_per_page = 25;
                                                    if (!isset($_GET['page'])) {
                                                        $page = 1;
                                                    } else {
                                                        $page = $_GET['page'];
                                                    }
                                                    $this_page_first_result = ($page - 1) * $results_per_page;

                                                    // search
                                                    $s_h = $_GET['search'];
                                                    if ($unit != '') {
                                                        $unitsql = " and e.u_id = '$unit'";
                                                    } else {
                                                        $unitsql = "";
                                                    }

                                                    // sql
                                                    $sql1 = "SELECT * from tb_exam e
                                                    inner join tb_unit u on u.u_id = e.u_id
                                                    where (e_qt like '%" . $s_h . "%')
                                                    and e.ck_id = '$row->ck_id' $unitsql
                                                    limit " . $this_page_first_result . "," . $results_per_page . "";
                                                    $rs1 = $con->query($sql1);
                                                    while ($r1 = $rs1->fetch_object()) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $r1->u_unit ?></td>
                                                            <td><?php echo nl2br(htmlspecialchars($r1->e_qt, ENT_QUOTES)); ?></td>
                                                            <td class="text-center">
                                                                <label class="switch switch-3d switch-primary mr-3">
                                                                    <input type="checkbox" class="switch-input" e_id="<?= $r1->e_id ?>" es_id="<?= $es_id ?>" <?php $sql2 = "SELECT * from tb_choose_exam where es_id = '$es_id' and e_id = '$r1->e_id'";
                                                                                                                                                                $rs2 = $con->query($sql2);
                                                                                                                                                                $r2 = $rs2->fetch_object();
                                                                                                                                                                if ($r2->e_id != '') {
                                                                                                                                                                    echo "checked ";
                                                                                                                                                                    echo "ce_id=$r2->ce_id ";
                                                                                                                                                                }
                                                                                                                                                                if ($row->es_sum == $row->es_count) {
                                                                                                                                                                    if ($r2->e_id == '') {
                                                                                                                                                                        echo 'disabled ';
                                                                                                                                                                    }
                                                                                                                                                                } ?>>
                                                                    <span class="switch-label"></span>
                                                                    <span class="switch-handle"></span>
                                                                </label>
                                                            </td>
                                                            <td>
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
                    <!-- page -->
                    <div>
                        <?php
                        $sql_page = "SELECT * from tb_exam e
                        inner join tb_unit u on u.u_id = e.u_id
                        where (e_qt like '%" . $s_h . "%')
                        and e.ck_id = '$row->ck_id' $unitsql";
                        $rs_page = $con->query($sql_page);
                        $number_of_results = mysqli_num_rows($rs_page);
                        $number_of_pages = ceil($number_of_results / $results_per_page);
                        if ($number_of_results > $results_per_page) {
                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-data__tool">
                                        <nav>
                                            <ul class="pagination">
                                                <?php for ($i = 1; $i <= $number_of_pages; $i++) { ?>
                                                    <li <?php if ($page == $i) echo 'class="page-item active"'; ?>>
                                                        <a class="page-link" href="exam_set_choose_exam_insert.php?exam_set=<?= $es_id ?>&page=<?php echo $i; ?>&search=<?php echo $s_h; ?>&unit=<?php echo $unit; ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php }; ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- end page -->
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
                var e_id = $(this).attr("e_id");
                var es_id = $(this).attr("es_id");
                var ce_id = $(this).attr("ce_id");
                var exam_check = "exam_check";
                var exam_uncheck = "exam_uncheck";
                if ($(this).is(":checked")) {
                    $.ajax({
                        url: "exam_set_controller.php",
                        method: "POST",
                        data: {
                            exam_check: exam_check,
                            e_id: e_id,
                            es_id: es_id
                        }
                    });
                    window.location.reload();
                } else if ($(this).is(":not(:checked)")) {
                    $.ajax({
                        url: "exam_set_controller.php",
                        method: "POST",
                        data: {
                            exam_uncheck: exam_uncheck,
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