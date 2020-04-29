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

    <?php
    $ck_id = $_GET["ck_id"];
    $es_id = $_GET["es_id"];
    ?>

    <!-- content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="user-data m-b-30">

                <!-- row 1 -->
                <div class="filters m-b-30">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3 class="title-3">
                                Choose exam
                            </h3>
                        </div>
                        <div class="col-lg-6" align="right">
                            <button type="button" class="btn btn-info" onclick="window.location.href='exam_set_choose_exam.php?ck_id=<?php echo $ck_id ?>&es_id=<?php echo $es_id ?>'">
                                Back
                            </button>
                            <a href="exam_form_insert.php?ck_id=<?= $ck_id ?>&es_id=<?= $es_id ?>" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add exam
                            </a>
                        </div>
                    </div>
                </div>
                <!-- end row 1 -->

                <!-- row 2 -->
                <div class="filters m-b-20">
                    <?php
                    $query = "SELECT * from tb_exam_set
                    where es_id = '$es_id'";
                    $result = $con->query($query);
                    $row = $result->fetch_object();
                    ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="company" class=" form-control-label">ชุดข้อสอบ</label>
                            <input type="text" placeholder="<?= $row->es_name ?>" disabled="" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="company" class=" form-control-label">จำนวนข้อสอบ</label>
                            <input type="text" placeholder="<?= $row->es_count ?>/<?= $row->es_sum ?>" disabled="" class="form-control">
                        </div>
                        <div class="col-lg-2">
                            <label for="company" class=" form-control-label">คะแนน</label>
                            <input type="text" placeholder="<?= $row->es_score ?>" disabled="" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- end row 2 -->

                <!-- row 3 -->
                <div class="filters m-b-20">
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="exam_set_choose_exam_insert.php" method="GET">
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
                            <input type="hidden" name="ck_id" value="<?= $ck_id ?>">
                            <input type="hidden" name="es_id" value="<?= $es_id ?>">
                            <input type="text" name="search" class=" form-control">
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search"></i> Search
                            </button>
                            </form>
                        </div>
                        <div class="col-lg-2">
                            <a href="exam_set_controller.php?random=random&ck_id=<?= $ck_id ?>&es_id=<?= $es_id ?>&es_count=<?= $row->es_count ?>&es_sum=<?= $row->es_sum ?>&unit=<?= $unit ?>" class="btn btn-warning form-control">
                                <i class="fas fa-fw fa-sync"></i> Random
                            </a>
                        </div>

                    </div>
                </div>

                <!-- end row 3 -->

                <!-- row 4 -->
                <div class="filters">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table mytable_c table-borderless table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 5%">หน่วย</th>
                                    <th>คำถาม</th>
                                    <th style="width: 11%">ใช้/ไม่ไช้</th>
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
                                and e.ck_id = '$ck_id' $unitsql
                                limit " . $this_page_first_result . "," . $results_per_page . "";
                                $rs1 = $con->query($sql1);
                                while ($r1 = $rs1->fetch_object()) {
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $r1->u_unit ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($r1->e_qt, ENT_QUOTES)); ?></td>
                                        <td class="text-center">
                                            <label class="switch switch-3d switch-primary mr-3">
                                                <input type="checkbox" class="switch-input" e_id="<?= $r1->e_id ?>" es_id="<?= $es_id ?>" <?php
                                                                                                                                            $sql2 = "SELECT * from tb_choose_exam
                                                                                                                                            where es_id = '$es_id' and e_id = '$r1->e_id'";
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
                                                                                                                                            }
                                                                                                                                            ?>>
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
                <!-- end row 4 -->

            </div>
        </div>
    </div>
    <!-- end content -->

    <!-- page -->
    <div>
        <?php
        $sql_page = "SELECT * from tb_exam e
        inner join tb_unit u on u.u_id = e.u_id
        where (e_qt like '%" . $s_h . "%')
        and e.ck_id = '$ck_id' $unitsql";
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
                                        <a class="page-link" href="exam_set_choose_exam_insert.php?ck_id=<?= $ck_id ?>&es_id=<?= $es_id ?>&page=<?php echo $i; ?>&search=<?php echo $s_h; ?>&unit=<?php echo $unit; ?>"><?php echo $i; ?></a>
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
    <!-- end script -->
</body>

</html>