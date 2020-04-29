<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>จัดการชุดข้อสอบ</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>

    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title m-b-30">
                                <div class="row">
                                    <div class="col-md-12" align="right">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#exam_set_insert">
                                        <i class="fas fa-plus"></i> Add exam set
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-center title-2"><b>จัดการชุดข้อสอบ</b></h3>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12 m-b-20">
                                            <form action="exam_set_manage.php" method="GET">
                                                <select name="subject" class="form-control" id="subject">
                                                    <option value="">กรุณาเลือกวิชา</option>
                                                    <?php
                                                    $subject = $_GET['subject'];
                                                    $sqlsj = "SELECT * from tb_checkteach ck
                                                    inner join tb_subject sj on sj.sj_id = ck.sj_id
                                                    where ck.t_id = '$r->t_id'";
                                                    $rssj = $con->query($sqlsj);
                                                    while ($rsj = $rssj->fetch_object()) {
                                                    ?>
                                                        <option value="<?= $rsj->sj_id; ?>" <?php if ($subject == $rsj->sj_id) {
                                                                                                echo "selected";
                                                                                            } ?>><?= $rsj->sj_name; ?></option>
                                                    <?php }; ?>
                                                </select>
                                        </div>
                                        <div class="col-md-12 m-b-20">
                                            <input type="text" name="search" class=" form-control">
                                        </div>
                                        <div class="col-md-12 m-b-20">
                                            <button type="submit" class="btn btn-success">
                                            <i class="fas fa-search"></i> Search
                                            </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="filters">
                                        <div class="table-responsive table--no-card m-b-30">
                                            <table class="table mytable_c table-borderless table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>ชื่อชุดข้อสอบ</th>
                                                        <th style="width: 14%">จำนวนข้อสอบ</th>
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
                                                    if ($subject != '') {
                                                        $subjectsql = "and ck.sj_id= '$subject'";
                                                    } else {
                                                        $subjectsql = "";
                                                    }

                                                    // sql
                                                    $sql1 = "SELECT * from tb_exam_set es
                                                    inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                                    where (es_name like '%" . $s_h . "%')
                                                    and ck.t_id = '$r->t_id' $subjectsql
                                                    limit " . $this_page_first_result . "," . $results_per_page . " ";
                                                    $rs1 = $con->query($sql1);
                                                    while ($r1 = $rs1->fetch_object()) {
                                                    ?>
                                                        <tr>
                                                            <td><?= $r1->es_name ?></td>
                                                            <td class="text-center"><?= $r1->es_count ?>/<?= $r1->es_sum ?></td>
                                                            <td class="text-center"><?= $r1->es_score ?></td>
                                                            <td class="text-center">
                                                                <label class="switch switch-3d switch-primary mr-3">
                                                                    <input type="checkbox" class="switch-input" id="<?= $r1->es_id ?>" <?php if ($r1->es_status == 1) {
                                                                                                                                            echo "checked";
                                                                                                                                        }
                                                                                                                                        if ($r1->es_sum != $r1->es_count) {
                                                                                                                                            echo 'disabled ';
                                                                                                                                        } ?>>
                                                                    <span class="switch-label"></span>
                                                                    <span class="switch-handle"></span>
                                                                </label>
                                                            </td>
                                                            <td align="center">
                                                                <a class="btn btn-info" href="exam_set_choose_student.php?exam_set=<?= $r1->es_id ?>">
                                                                    <i class="fas fa-fw fa-graduation-cap"></i>
                                                                </a>
                                                            </td>
                                                            <td align="center">
                                                                <a class="btn btn-info" href="exam_set_choose_exam.php?exam_set=<?= $r1->es_id ?>">
                                                                    <i class="fas fa-fw fa-file-alt"></i>
                                                                </a>
                                                            </td>
                                                            <td align="center">
                                                                <a class="btn btn-success" href="exam_set_form_update.php?exam_set=<?= $r1->es_id ?>">
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
                                        <!-- page -->
                                        <div>
                                            <?php
                                            $sql_page = "SELECT * from tb_exam_set es
                                            inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                            where (es_name like '%" . $s_h . "%')
                                            and ck.t_id = '$r->t_id' $subjectsql";
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
                                                                            <a class="page-link" href="exam_set_manage.php?page=<?php echo $i; ?>&subject=<?php echo $subject; ?>&search=<?php echo $s_h; ?>"><?php echo $i; ?></a>
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
            <div class="modal-content" id="exam_set">

            </div>
        </div>
    </div>

    <div class="modal fade" id="exam_set_insert" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <h4 class="modal-title">เพิ่ม ชุดข้อสอบ</h4>
                </div>
                <div class="modal-body">
                    <form action="exam_set_form_insert.php" method="GET">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>วิชา</strong></label>
                                        <select name="checkteach" class="form-control" required>
                                            <option value="">กรุณาเลือกวิชา</option>
                                            <?php
                                            $sqlck = "SELECT * from tb_checkteach ck
                                            inner join tb_subject sj on sj.sj_id = ck.sj_id
                                            where ck.t_id = '$r->t_id'";
                                            $rsck = $con->query($sqlck);
                                            while ($rck = $rsck->fetch_object()) {
                                            ?>
                                                <option value="<?= $rck->ck_id; ?>"><?= $rck->sj_name; ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
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
                url: "exam_set_controller.php",
                method: "POST",
                data: {
                    view: view_id
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