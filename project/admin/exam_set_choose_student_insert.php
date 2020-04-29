<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>เลือกนักศึกษา</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>

    <?php
    $ck_id = $_GET["ck_id"];
    $es_id = $_GET["es_id"];

    $cs_number = $_GET["cs_number"];
    $tm_id = $_GET["tm_id"];
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
                                Choose student
                            </h3>
                        </div>
                        <div class="col-lg-6" align="right">
                            <button type="button" class="btn btn-info" onclick="window.location.href='exam_set_choose_student.php?ck_id=<?php echo $ck_id ?>&es_id=<?php echo $es_id ?>'">
                                Back
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
                            <input type="text" placeholder="สอบครั้งที่ <?= $cs_number ?>" disabled="" class="form-control">
                        </div>
                        <?php
                        $sqltm = "SELECT * from tb_term
                        where tm_id = '$tm_id'";
                        $rstm = $con->query($sqltm);
                        $rtm = $rstm->fetch_object();
                        ?>
                        <div class="col-lg-4">
                            <input type="text" placeholder="ภาคเรียนที่ <?= $rtm->tm_name; ?>" disabled="" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <form action="exam_set_choose_student_insert.php" method="GET">
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
                    </div>
                </div>
                <!-- row * -->

                <!-- row 2 -->
                <div class="filters m-b-20">
                    <div class="row">
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
                    </div>
                </div>
                <!-- row 2 -->

                <!-- row 3 -->
                <div class="filters m-b-40">
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="hidden" name="cs_number" value="<?= $cs_number ?>">
                            <input type="hidden" name="tm_id" value="<?= $tm_id ?>">
                            <input type="hidden" name="ck_id" value="<?= $ck_id ?>">
                            <input type="hidden" name="es_id" value="<?= $es_id ?>">
                            <input type="text" name="search" class=" form-control">
                        </div>
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search"></i> Search
                            </button>
                            </form>
                        </div>
                        <div class="col-lg-4" align="right">
                            <button type="button" class="btn btn-warning" id="select_all">
                                <i class="fas fa-fw fa-toggle-on"></i> Select all
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
                                    <th>รหัสนักศึกษา</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>แผนกวิชา</th>
                                    <th>ระดับชั้น</th>
                                    <th>กลุ่ม</th>
                                    <th>ใช้/ไม่ไช้</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // page
                                $results_per_page = 50;
                                if (!isset($_GET['page'])) {
                                    $page = 1;
                                } else {
                                    $page = $_GET['page'];
                                }
                                $this_page_first_result = ($page - 1) * $results_per_page;

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

                                // sql
                                $sql1 = "SELECT * from tb_student s
                                inner join tb_class c on s.c_id = c.c_id
                                inner join tb_department d on s.d_id = d.d_id
                                where (s.s_id like '%" . $s_h . "%'
                                ||s.s_name like '%" . $s_h . "%')
                                $depsql $myclasssql $groupsql $yearsql
                                limit " . $this_page_first_result . "," . $results_per_page . "";
                                $rs1 = $con->query($sql1);
                                while ($r1 = $rs1->fetch_object()) {
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $r1->s_id ?></td>
                                        <td><?= $r1->s_name ?></td>
                                        <td><?= $r1->d_name ?></td>
                                        <td class="text-center"><?= $r1->c_name ?></td>
                                        <td class="text-center"><?= $r1->s_group ?></td>
                                        <td class="text-center">
                                            <?php
                                            $sql2 = "SELECT * from tb_choose_student where s_id = '$r1->s_id' and es_id = '$es_id' and cs_number = '$cs_number' and tm_id = '$tm_id'";
                                            $rs2 = $con->query($sql2);
                                            $r2 = $rs2->fetch_object();
                                            if ($r2->cs_status != 1) {
                                            ?>
                                                <label class="switch switch-3d switch-primary mr-3">
                                                    <input type="checkbox" class="switch-input" s_id="<?= $r1->s_id ?>" <?php if ($r2->cs_status == 0) {
                                                                                                                            echo "cs_id=$r2->cs_id checked";
                                                                                                                        } ?>>
                                                    <span class="switch-label"></span>
                                                    <span class="switch-handle"></span>
                                                </label>
                                            <?php } ?>
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
        $sql_page = "SELECT * from tb_student s
        inner join tb_class c on s.c_id = c.c_id
        inner join tb_department d on s.d_id = d.d_id
        where (s.s_id like '%" . $s_h . "%'
        ||s.s_name like '%" . $s_h . "%')
        $depsql $myclasssql $groupsql $yearsql";
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
                                        <a class="page-link" href="exam_set_choose_student_insert.php?ck_id=<?= $ck_id ?>&es_id=<?= $es_id ?>&page=<?php echo $i; ?>&search=<?php echo $s_h; ?>&dep=<?php echo $dep; ?>&myclass=<?php echo $myclass; ?>&group=<?php echo $group; ?>&year=<?php echo $year; ?>&cs_number=<?php echo $cs_number; ?>&tm_id=<?php echo $tm_id; ?>"><?php echo $i; ?></a>
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
    <?php include("../script.php"); ?>

    <!-- script -->
    <script>
        $(document).on('click', '#select_all', function() {
            var select_all = "select_all";
            var ck_id = <?= $ck_id ?>;
            var es_id = <?= $es_id ?>;
            var page = <?= $page ?>;
            var s_h = "<?= $s_h ?>";
            var dep = "<?= $dep ?>";
            var myclass = "<?= $myclass ?>";
            var group = "<?= $group ?>";
            var year = "<?= $year ?>";
            var cs_number = "<?= $cs_number ?>";
            var tm_id = "<?= $tm_id ?>";
            $.ajax({
                url: "exam_set_controller.php",
                method: "POST",
                data: {
                    select_all: select_all,
                    ck_id: ck_id,
                    es_id: es_id,
                    page: page,
                    s_h: s_h,
                    dep: dep,
                    myclass: myclass,
                    group: group,
                    year: year,
                    cs_number: cs_number,
                    tm_id: tm_id
                }
            });
            window.location.reload();
        });

        $(document).ready(function() {
            $('input[type="checkbox"]').click(function() {
                var s_id = $(this).attr("s_id");
                var es_id = <?= $es_id ?>;
                var cs_id = $(this).attr("cs_id");
                var student_check = "student_check";
                var student_uncheck = "student_uncheck";
                var cs_number = "<?= $cs_number ?>";
                var tm_id = "<?= $tm_id ?>";
                if ($(this).is(":checked")) {
                    $.ajax({
                        url: "exam_set_controller.php",
                        method: "POST",
                        data: {
                            student_check: student_check,
                            s_id: s_id,
                            es_id: es_id,
                            cs_number: cs_number,
                            tm_id: tm_id
                        }
                    });
                    window.location.reload();
                } else if ($(this).is(":not(:checked)")) {
                    $.ajax({
                        url: "exam_set_controller.php",
                        method: "POST",
                        data: {
                            student_uncheck: student_uncheck,
                            cs_id: cs_id,
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