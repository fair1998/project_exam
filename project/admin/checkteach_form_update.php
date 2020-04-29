<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>แก้ไขการลงทะเบียนการสอน</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>

    <!-- content -->
    <div class="row">
        <div class="col-lg-10 mr-auto ml-auto">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-md-3">
                            <button type="button" class="btn btn-info" onclick="window.location.href='checkteach_manage.php'">
                                Back
                            </button>
                        </div>
                        <div class="col-md-9">
                            <strong>แก้ไขการลงทะเบียนการสอน
                            </strong>
                        </div>
                    </div>
                </div>
                <?php
                $ck_id = $_GET["id"];
                $sql1 = "SELECT * from tb_checkteach
                where ck_id = '$ck_id'";
                $rs1 = $con->query($sql1);
                $r1 = $rs1->fetch_object();
                ?>
                <form action="checkteach_controller.php" method="POST" class="form-horizontal">
                    <div class="card-body card-block" id="checkteach">

                    </div>
                    <div class="card-footer" align="center">
                        <input type="hidden" name="update" value="<?= $r1->ck_id ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-dot-circle-o"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-danger resetdata" data="<?= $r1->ck_id ?>">
                            <i class="fa fa-ban"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end content -->

    <?php include("footer.php"); ?>

    <!-- subject modal -->
    <div class="modal fade" id="subject_view" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">วิชา</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid myplr35">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <select name="subject_select" id="subject_select" class="form-control">
                                            <option value="">กรุณาเลือกระดับการศึกษา</option>
                                            <option value="1">ปวช</option>
                                            <option value="2">ปวส</option>
                                            <option value="3">ป.ตรี</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" id="subject_search" name="subject_search" placeholder="ค้นหา" class=" form-control">
                                        <button type="button" id="subject_button_search">
                                            <div class="input-group-addon">
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="au-task-list js-scrollbar3">
                                    <div class="table-responsive">
                                        <table class="table table-top-campaign">
                                            <tbody id="subject">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end subject modal -->

    <!-- teacher modal -->
    <div class="modal fade" id="teacher_view" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">อาจารย์</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid myplr35">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <select name="teacher_select" id="teacher_select" class="form-control">
                                            <option value="">กรุณาเลือกแผนก</option>
                                            <?php
                                            $sqld = "SELECT * from tb_department ";
                                            $rsd = $con->query($sqld);
                                            while ($rd = $rsd->fetch_object()) {
                                            ?>
                                                <option value="<?= $rd->d_id ?>"><?= $rd->d_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" id="teacher_search" name="teacher_search" placeholder="ค้นหา" class=" form-control">
                                        <button type="button" id="teacher_button_search">
                                            <div class="input-group-addon">
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="au-task-list js-scrollbar3">
                                    <div class="table-responsive">
                                        <table class="table table-top-campaign">
                                            <tbody id="teacher">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end teacher modal -->

    <?php include("../script.php"); ?>

    <!-- script -->
    <script>
        // subject
        $(document).on('click', '#subject_button_search', function() {
            var subject = "subject";
            var search = document.getElementById("subject_search").value;
            var select = document.getElementById("subject_select").value;
            $.ajax({
                url: "checkteach_controller.php",
                method: "POST",
                data: {
                    subject: subject,
                    search: search,
                    select: select
                },
                success: function(data) {
                    $('#subject').html(data);
                }
            });
        });
        $(document).on('click', '.subject_opt', function() {
            var subject_action = "subject_action";
            var subjectid = $(this).attr("subjectid");
            $.ajax({
                url: "checkteach_controller.php",
                method: "POST",
                data: {
                    subject_action: subject_action,
                    subjectid: subjectid
                },
                success: function(data) {
                    $('#sj_id').html(data);
                }
            });
        });

        // teacher
        $(document).on('click', '#teacher_button_search', function() {
            var teacher = "teacher";
            var search = document.getElementById("teacher_search").value;
            var select = document.getElementById("teacher_select").value;
            $.ajax({
                url: "checkteach_controller.php",
                method: "POST",
                data: {
                    teacher: teacher,
                    search: search,
                    select: select
                },
                success: function(data) {
                    $('#teacher').html(data);
                }
            });
        });
        $(document).on('click', '.teacher_opt', function() {
            var teacher_action = "teacher_action";
            var teacherid = $(this).attr("teacherid");
            $.ajax({
                url: "checkteach_controller.php",
                method: "POST",
                data: {
                    teacher_action: teacher_action,
                    teacherid: teacherid
                },
                success: function(data) {
                    $('#t_id').html(data);
                }
            });
        });

        // form updata
        $(document).ready(function() {
            var form_updata = "form_updata";
            var ck_id = <?= $ck_id ?>;
            $.ajax({
                url: "checkteach_controller.php",
                method: "POST",
                data: {
                    form_updata: form_updata,
                    ck_id: ck_id
                },
                success: function(data) {
                    $('#checkteach').html(data);
                }
            });
        });
        $(document).on('click', '.resetdata', function() {
            var ck_id = $(this).attr("data");
            var form_updata = "form_updata";
            $.ajax({
                url: "checkteach_controller.php",
                method: "POST",
                data: {
                    form_updata: form_updata,
                    ck_id: ck_id
                },
                success: function(data) {
                    $('#checkteach').html(data);
                }
            });
        });
    </script>
    <!-- end script -->
</body>

</html>