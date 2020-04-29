<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>จัดการข้อมูลชุดข้อสอบ</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>
    <?php $ck_id = $_GET['ck_id']; ?>

    <!-- content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="user-data m-b-30">

                <!-- row 1 -->
                <div class="filters m-b-30">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3 class="title-3">
                                Examination set data
                            </h3>
                        </div>
                        <div class="col-lg-6" align="right">
                            <button type="button" class="btn btn-info" onclick="window.location.href='exam_set_select.php'">
                                Back
                            </button>
                            <a href="exam_set_form_insert.php?ck_id=<?= $ck_id ?>" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add exam set
                            </a>
                        </div>
                    </div>
                </div>
                <!-- end row 1 -->

                <!-- row 2 -->
                <div>
                    <?php
                    $query = "SELECT * from tb_checkteach ck
                    inner join tb_teacher t on t.t_id = ck.t_id
                    inner join tb_subject sj on sj.sj_id = ck.sj_id
                    where ck_id = '$ck_id'";
                    $result = $con->query($query);
                    $row = $result->fetch_object();
                    ?>
                    <div class="filters m-b-20">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="company" class=" form-control-label">อาจารย์</label>
                                <input type="text" value="<?= $row->t_name ?>" disabled="" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="company" class=" form-control-label">วิชา</label>
                                <input type="text" value="<?= $row->sj_name ?>" disabled="" class="form-control">
                            </div>
                            <div class="col-lg-2">
                                <label for="company" class=" form-control-label">ระดับชั้น</label>
                                <input type="text" value="<?php if ($row->sj_class == 1) {
                                                                echo "ปวช";
                                                            } elseif ($row->sj_class == 2) {
                                                                echo "ปวส";
                                                            } else {
                                                                echo "ป.ตรี";
                                                            } ?>" disabled="" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row 2 -->

                <!-- row 3 -->
                <div class="filters m-b-20">
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="exam_set_manage.php?" method="GET">
                                <input type="hidden" name="ck_id" value="<?= $ck_id ?>">
                                <input type="text" name="search" class=" form-control">
                        </div>
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- end row 3 -->

                <!-- row 4 -->
                <div class="filters">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table mytable_c table-borderless table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>ชื่อชุดข้อสอบ</th>
                                    <th style="width: 15%">จำนวนข้อสอบ</th>
                                    <th style="width: 9%">คะแนน</th>
                                    <th style="width: 10%">เปิด/ปิด</th>
                                    <th style="width: 5%">นักศึกษา</th>
                                    <th style="width: 5%">ข้อสอบ</th>
                                    <th style="width: 5%">Edit</th>
                                    <th style="width: 5%">Delete</th>
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

                                // sql
                                $sql1 = "SELECT * from tb_exam_set
                                where (es_name like '%" . $s_h . "%')
                                and ck_id = '$ck_id'
                                limit " . $this_page_first_result . "," . $results_per_page . "";
                                $rs1 = $con->query($sql1);
                                while ($r1 = $rs1->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?= $r1->es_name ?></td>
                                        <td class="text-center"><?= $r1->es_count ?>/<?= $r1->es_sum ?></td>
                                        <td class="text-center"><?= $r1->es_score ?></td>
                                        <td class="text-center">
                                            <label class="switch switch-3d switch-primary mr-3">
                                                <input type="checkbox" class="switch-input" id="<?= $r1->es_id ?>" <?php
                                                                                                                    if ($r1->es_status == 1) {
                                                                                                                        echo "checked";
                                                                                                                    }
                                                                                                                    if ($r1->es_sum != $r1->es_count) {
                                                                                                                        echo 'disabled ';
                                                                                                                    }
                                                                                                                    ?>>
                                                <span class="switch-label"></span>
                                                <span class="switch-handle"></span>
                                            </label>
                                        </td>
                                        <td align="center">
                                            <a class="btn btn-info" href="exam_set_choose_student.php?ck_id=<?= $ck_id ?>&es_id=<?= $r1->es_id ?>">
                                                <i class="fas fa-fw fa-graduation-cap"></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a class="btn btn-info" href="exam_set_choose_exam.php?ck_id=<?= $ck_id ?>&es_id=<?= $r1->es_id ?>">
                                                <i class="fas fa-fw fa-file-alt"></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a class="btn btn-success" href="exam_set_form_update.php?ck_id=<?= $ck_id ?>&es_id=<?= $r1->es_id ?>">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <button type="button" class="btn btn-danger view_data" id="<?= $r1->es_id ?>" data-toggle="modal" data-target="#viewdata">
                                                <i class="fas fa-fw fa-trash-alt"></i>
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
        $sql_page = "SELECT * from tb_exam_set
        where (es_id like '%" . $s_h . "%')
        and ck_id = '$ck_id'";
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
                                        <a class="page-link" href="exam_set_manage.php?ck_id=<?php echo $ck_id ?>&page=<?php echo $i; ?>&search=<?php echo $s_h; ?>"><?php echo $i; ?></a>
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

    <!-- end content -->
    <?php include("footer.php"); ?>

    <!-- modal -->
    <div class="modal fade" id="viewdata" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="exam_set">

            </div>
        </div>
    </div>
    <!-- end modal -->

    <?php include("../script.php"); ?>

    <!-- script -->
    <script>
        $(document).on('click', '.view_data', function() {
            var view_id = $(this).attr("id");
            var ck_id = <?= $ck_id ?>;
            $.ajax({
                url: "exam_set_controller.php",
                method: "POST",
                data: {
                    view: view_id,
                    ck_id: ck_id
                },
                success: function(data) {
                    $('#exam_set').html(data);
                }
            });
        });

        $(document).ready(function() {
            $('input[type="checkbox"]').click(function() {
                if ($(this).is(":checked")) {
                    var open_close = $(this).attr("id");
                    var status = "1";
                    $.ajax({
                        url: "exam_set_controller.php",
                        method: "POST",
                        data: {
                            open_close: open_close,
                            status: status
                        }
                    });
                    window.location.reload();
                } else if ($(this).is(":not(:checked)")) {
                    var open_close = $(this).attr("id");
                    var status = "0";
                    $.ajax({
                        url: "exam_set_controller.php",
                        method: "POST",
                        data: {
                            open_close: open_close,
                            status: status
                        }
                    });
                    window.location.reload();
                }
            });
        });
    </script>
    <!-- end script -->

    <script src="../css_script/swal.js"></script>

</body>

</html>