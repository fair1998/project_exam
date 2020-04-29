<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>ข้อมูลการเลือกนักศึกษา</title>
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
                                Student selection information
                            </h3>
                        </div>
                        <div class="col-lg-6" align="right">
                            <button type="button" class="btn btn-info" onclick="window.location.href='exam_set_manage.php?ck_id=<?php echo $ck_id ?>'">
                                Back
                            </button>
                            <button type="button" class="btn btn-success term_number" data-toggle="modal" data-target="#term_number">
                                <i class="fas fa-plus"></i> Choose student
                            </button>
                        </div>
                    </div>
                </div>
                <!-- end row 1 -->

                <!-- row -->
                <div class="filters m-b-20">
                    <?php
                    $query = "SELECT * from tb_exam_set es
                    inner join tb_checkteach ck on ck.ck_id = es.ck_id
                    inner join tb_subject sj on sj.sj_id = ck.sj_id
                    where es_id = '$es_id'";
                    $result = $con->query($query);
                    $row = $result->fetch_object();
                    if ($row->sj_class == 1) {
                        $level = "ปวช";
                    } elseif ($row->sj_class == 2) {
                        $level = "ปวส";
                    } else {
                        $level = "ป.ตรี";
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="company" class=" form-control-label">ชื่อชุดข้อสอบ</label>
                            <input type="text" value="<?= $row->es_name ?>" disabled="" class="form-control">
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
                <!-- end row  -->

                <!-- row * -->
                <div class="filters m-b-20">
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="exam_set_choose_student.php" method="GET">
                                <select name="term" class="form-control">
                                    <option value="">กรุณาเลือกภาคเรียน</option>
                                    <?php
                                    $term = $_GET['term'];
                                    $sqltm = "SELECT * from tb_term
                                    order by tm_id DESC
                                    ";
                                    $rstm = $con->query($sqltm);
                                    while ($rtm = $rstm->fetch_object()) {
                                    ?>
                                        <option value="<?= $rtm->tm_id; ?>" <?php if ($term == $rtm->tm_id) {
                                                                                echo "selected";
                                                                            } ?>>
                                            <?= $rtm->tm_name; ?></option>
                                    <?php }; ?>
                                </select>
                        </div>
                        <div class="col-lg-4">
                            <select name="dep" class="form-control">
                                <option value="">กรุณาเลือกแผนกวิชา</option>
                                <?php
                                $dep = $_GET['dep'];
                                $sqld = "SELECT * from tb_department";
                                $rsd = $con->query($sqld);
                                while ($rd = $rsd->fetch_object()) {
                                ?>
                                    <option value="<?= $rd->d_id; ?>" <?php if ($dep == $rd->d_id) {
                                                                            echo "selected";
                                                                        } ?>>
                                        <?php echo $rd->d_name; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select name="myclass" class="form-control">
                                <option value="">กรุณาเลือกระดับชั้น</option>
                                <?php
                                $myclass = $_GET['myclass'];
                                $sqlc = "SELECT * from tb_class where c_name like '$level%'";
                                $rsc = $con->query($sqlc);
                                while ($rc = $rsc->fetch_object()) {
                                ?>
                                    <option value="<?= $rc->c_id; ?>" <?php if ($myclass == $rc->c_id) {
                                                                            echo "selected";
                                                                        } ?>>
                                        <?php echo $rc->c_name; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- row * -->

                <!-- row 2 -->
                <div class="filters m-b-20">
                    <div class="row">
                        <div class="col-lg-4">
                            <select name="group" class="form-control">
                                <option value="">กรุณาเลือกกลุ่ม</option>
                                <?php
                                $group = $_GET['group'];
                                $sqlg = "SELECT * from tb_student group by s_group ORDER BY s_group ASC";
                                $rsg = $con->query($sqlg);
                                while ($rg = $rsg->fetch_object()) {
                                ?>
                                    <option value="<?= $rg->s_group; ?>" <?php if ($group == $rg->s_group) {
                                                                                echo "selected";
                                                                            } ?>>
                                        <?php echo $rg->s_group; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select name="year" class="form-control">
                                <option value="">กรุณาเลือกปีการศึกษา</option>
                                <?php
                                $year = $_GET['year'];
                                $sqly = "SELECT * from tb_year";
                                $rsy = $con->query($sqly);
                                while ($ry = $rsy->fetch_object()) {
                                ?>
                                    <option value="<?= $ry->y_id; ?>" <?php if ($year == $ry->y_id) {
                                                                            echo "selected";
                                                                        } ?>>
                                        <?php echo $ry->y_name; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <input type="hidden" name="ck_id" value="<?= $ck_id ?>">
                            <input type="hidden" name="es_id" value="<?= $es_id ?>">
                            <input type="text" name="search" class=" form-control">
                        </div>
                    </div>
                </div>
                <!-- row 2 -->

                <!-- row 3 -->
                <div class="filters m-b-40">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search"></i> Search
                            </button>
                            </form>
                        </div>
                        <div class="col-lg-6" align="right">
                            <button type="button" class="btn btn-warning" id="cancel_all">
                                <i class="fas fa-fw fa-toggle-off"></i> Cancel all
                            </button>
                        </div>
                    </div>
                </div>
                <!-- row 3 -->

                <!-- row 4 -->
                <div class="filters">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table mytable_c table-borderless table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>ภาคเรียน</th>
                                    <th>รหัสนักศึกษา</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>แผนกวิชา</th>
                                    <th>ระดับชั้น</th>
                                    <th>กลุ่ม</th>
                                    <th>ครั้งที่</th>
                                    <th>ใช้/ไม่ไช้</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // search
                                $s_h = $_GET['search'];
                                if ($dep != '') {
                                    $depsql = "and s.d_id = '$dep'";
                                } else {
                                    $depsql = "";
                                }
                                if ($myclass != '') {
                                    $myclasssql = "and s.c_id = '$myclass'";
                                } else {
                                    $myclasssql = "";
                                }
                                if ($group != '') {
                                    $groupsql = "and s.s_group = '$group'";
                                } else {
                                    $groupsql = "";
                                }
                                if ($year != '') {
                                    $yearsql = "and s.y_id = '$year'";
                                } else {
                                    $yearsql = "";
                                }
                                if ($term != '') {
                                    $termsql = "and cs.tm_id = '$term'";
                                } else {
                                    $termsql = "";
                                }


                                // sql
                                $sql1 = "SELECT * from tb_choose_student cs
                                inner join tb_student s on s.s_id = cs.s_id
                                inner join tb_class c on s.c_id = c.c_id
                                inner join tb_department d on s.d_id = d.d_id
                                inner join tb_term tm on tm.tm_id = cs.tm_id
                                where (s.s_id like '%" . $s_h . "%'
                                ||s.s_name like '%" . $s_h . "%')
                                and cs.es_id='$es_id' and cs_status='0'
                                $depsql $myclasssql $groupsql $yearsql $termsql";
                                $rs1 = $con->query($sql1);
                                while ($r1 = $rs1->fetch_object()) {
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $r1->tm_name ?></td>
                                        <td class="text-center"><?= $r1->s_id ?></td>
                                        <td><?= $r1->s_name ?></td>
                                        <td><?= $r1->d_name ?></td>
                                        <td class="text-center"><?= $r1->c_name ?></td>
                                        <td class="text-center"><?= $r1->s_group ?></td>
                                        <td class="text-center"><?= $r1->cs_number ?></td>
                                        <td class="text-center">
                                            <label class="switch switch-3d switch-primary mr-3">
                                                <input type="checkbox" class="switch-input" cs_id=<?= $r1->cs_id ?> checked>
                                                <span class="switch-label"></span>
                                                <span class="switch-handle"></span>
                                            </label>
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

    <?php include("footer.php"); ?>

    <!-- modal -->
    <div class="modal fade" id="term_number" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <h4 class="modal-title">ลงทะเบียน</h4>
                </div>
                <div class="modal-body">
                    <form action="exam_set_choose_student_insert.php" method="GET">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>สอบครั้งที่</strong></label>
                                        <input type="text" name="cs_number" pattern="[0-9]{1,}" title="กรอกตัวเลขเท่านั้น" maxlength="2" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>ภาคเรียนที่</strong></label>
                                        <select name="tm_id" class="form-control" required="">
                                            <option value="">กรุณาเลือกภาคเรียน</option>
                                            <?php
                                            $sqltm = "SELECT * from tb_term
                                            ORDER BY tm_id DESC";
                                            $rstm = $con->query($sqltm);
                                            while ($rtm = $rstm->fetch_object()) {
                                            ?>
                                                <option value="<?= $rtm->tm_id; ?>"><?= $rtm->tm_name; ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="ck_id" value="<?= $ck_id ?>">
                    <input type="hidden" name="es_id" value="<?= $es_id ?>">
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
        $(document).ready(function() {
            $('input[type="checkbox"]').click(function() {
                var cs_id = $(this).attr("cs_id");
                var student_uncheck = "student_uncheck";
                if ($(this).is(":not(:checked)")) {
                    $.ajax({
                        url: "exam_set_controller.php",
                        method: "POST",
                        data: {
                            student_uncheck: student_uncheck,
                            cs_id: cs_id
                        }
                    });
                    window.location.reload();
                }
            });
        });

        $(document).on('click', '#cancel_all', function() {
            var cancel_all = "cancel_all";
            var ck_id = <?= $ck_id ?>;
            var es_id = <?= $es_id ?>;
            var s_h = "<?= $s_h ?>";
            var dep = "<?= $dep ?>";
            var myclass = "<?= $myclass ?>";
            var group = "<?= $group ?>";
            var year = "<?= $year ?>";
            var term = "<?= $term ?>";
            $.ajax({
                url: "exam_set_controller.php",
                method: "POST",
                data: {
                    cancel_all: cancel_all,
                    ck_id: ck_id,
                    es_id: es_id,
                    s_h: s_h,
                    dep: dep,
                    myclass: myclass,
                    group: group,
                    year: year,
                    term: term
                }
            });
            window.location.reload();
        });
    </script>
    <!-- end script -->

</body>

</html>