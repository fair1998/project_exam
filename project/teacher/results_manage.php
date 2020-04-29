<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>ผลการสอบนักศึกษา</title>
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
                                <h3 class="text-center title-2"><b>ผลการสอบนักศึกษา</b></h3>
                            </div>
                            <div class="filters m-b-10">
                                <div class="row m-b-20">
                                    <div class="col-md-3">
                                        <!-- <label for="company" class=" form-control-label">ภาคเรียน</label> -->
                                        <form action="results_manage.php" method="GET">
                                            <select name="term" class="form-control" id="term">
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
                                    <div class="col-md-3">
                                        <!-- <label for="company" class=" form-control-label">วิชา</label> -->
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
                                    <div class="col-md-3">
                                        <!-- <label for="company" class=" form-control-label">ชื่อชุดข้อสอบ</label> -->
                                        <select name="exam_set" class="form-control" id="exam_set">
                                            <option value="">กรุณาเลือกชุดข้อสอบ</option>
                                            <?php
                                            $exam_set = $_GET['exam_set'];
                                            if ($subject != '') {
                                                $subjectsql1 = " and ck.sj_id = '$subject'";
                                                $subjectsql2 = " and b.sj_id = '$subject'";
                                            } else {
                                                $subjectsql = "";
                                            }
                                            $sqles = "SELECT * from tb_exam_set es
                                                inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                                where ck.t_id = '$r->t_id' $subjectsql1
                                                ";
                                            $rses = $con->query($sqles);
                                            while ($res = $rses->fetch_object()) {
                                            ?>
                                                <option value="<?= $res->es_id; ?>" <?php if ($exam_set == $res->es_id) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                                    <?= $res->es_name; ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3" align="center">
                                        <!-- <br> -->
                                        <div class="form-check-inline form-check">
                                            <?php $er_results = $_GET["er_results"]; ?>
                                            <label for="inline-radio1" class="form-check-label ">
                                                <input type="radio" id="inline-radio1" name="er_results" value="1" class="form-check-input" <?php
                                                                                                                                            if ($er_results == 1) {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>ผ่าน
                                            </label>
                                            <label for="inline-radio2" class="form-check-label ">
                                                <input type="radio" id="inline-radio2" name="er_results" value="0" class="form-check-input" <?php
                                                                                                                                            if ($er_results == 0) {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>ไม่ผ่าน
                                            </label>
                                            <label for="inline-radio3" class="form-check-label ">
                                                <input type="radio" id="inline-radio3" name="er_results" value="2" class="form-check-input" <?php
                                                                                                                                            if ($er_results == '' || $er_results == 2) {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>ทั้งหมด
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filters m-b-10">
                                <div class="row m-b-20">
                                    <div class="col-md-3">
                                        <!-- <label for="company" class=" form-control-label">แผนกวิชา</label> -->
                                        <select name="department" class="form-control" id="department">
                                            <option value="">กรุณาเลือกแผนก</option>
                                            <?php
                                            $department = $_GET['department'];
                                            $sqld = "SELECT * from tb_department ";
                                            $rsd = $con->query($sqld);
                                            while ($rd = $rsd->fetch_object()) {
                                            ?>
                                                <option value="<?= $rd->d_id; ?>" <?php if ($department == $rd->d_id) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                                    <?= $rd->d_name; ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <label for="company" class=" form-control-label">ระดับชั้น</label> -->
                                        <select name="class" class="form-control" id="class">
                                            <option value="">กรุณาเลือกระดับชั้น</option>
                                            <?php
                                            $class = $_GET['class'];
                                            $sqlc = "SELECT * from tb_class";
                                            $rsc = $con->query($sqlc);
                                            while ($rc = $rsc->fetch_object()) {
                                            ?>
                                                <option value="<?= $rc->c_id; ?>" <?php if ($class == $rc->c_id) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                                    <?= $rc->c_name; ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <label for="company" class=" form-control-label">กลุ่ม</label> -->
                                        <select name="group" class="form-control" id="group">
                                            <option value="">กรุณาเลือกกลุ่ม</option>
                                            <?php
                                            $group = $_GET['group'];
                                            $sqlg = "SELECT * from tb_student s
                                            inner join tb_class c on c.c_id = s.c_id
                                            where c_name like '$level%'
                                            group by s_group ";
                                            $rsg = $con->query($sqlg);
                                            while ($rg = $rsg->fetch_object()) {
                                            ?>
                                                <option value="<?= $rg->s_group; ?>" <?php if ($group == $rg->s_group) {
                                                                                            echo "selected";
                                                                                        } ?>>
                                                    <?= $rg->s_group; ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <label for="company" class=" form-control-label">ปีการศึกษา</label> -->
                                        <select name="year" class="form-control" id="year">
                                            <option value="">กรุณาเลือกปีการศึกษา</option>
                                            <?php
                                            $year = $_GET['year'];
                                            $sqly = "SELECT * from tb_year order by y_id DESC";
                                            $rsy = $con->query($sqly);
                                            while ($ry = $rsy->fetch_object()) {
                                            ?>
                                                <option value="<?= $ry->y_id; ?>" <?php if ($year == $ry->y_id) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                                    <?= $ry->y_name; ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="filters m-b-20">
                                <div class="row m-b-20">
                                    <div class="col-md-3">
                                        <!-- <label for="company" class=" form-control-label">ค้นหา</label> -->
                                        <input type="text" name="search" class=" form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <br> -->
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="filters">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table mytable_c table-borderless table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>รหัสนักศึกษา</th>
                                                <th>ชื่อนักศึกษา</th>
                                                <th>ตอบถูก</th>
                                                <th>ตอบผิด</th>
                                                <th>คะแนน</th>
                                                <th>ครั้งที่</th>
                                                <th>ผ่าน/ไม่ผ่าน</th>
                                                <th>เวลา</th>
                                                <th style="width: 5%">View</th>
                                                <th style="width: 5%">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // page
                                            $results_per_page = 30;
                                            if (!isset($_GET['page'])) {
                                                $page = 1;
                                            } else {
                                                $page = $_GET['page'];
                                            }
                                            $this_page_first_result = ($page - 1) * $results_per_page;

                                            // search
                                            $s_h = $_GET['search'];
                                            if ($term != '') {
                                                $termsql = "and b.tm_id = '$term'";
                                            } else {
                                                $depsql = "";
                                            }
                                            if ($exam_set != '') {
                                                $exam_setsql = "and b.es_id = '$exam_set'";
                                            } else {
                                                $exam_setsql = "";
                                            }
                                            if ($department != '') {
                                                $departmentsql = "and b.d_id = '$department'";
                                            } else {
                                                $departmentsql = "";
                                            }
                                            if ($class != '') {
                                                $classsql = "and b.c_id = '$class'";
                                            } else {
                                                $classsql = "";
                                            }
                                            if ($group != '') {
                                                $groupsql = "and b.s_group = '$group'";
                                            } else {
                                                $groupsql = "";
                                            }
                                            if ($year != '') {
                                                $yearsql = "and b.y_id = '$year'";
                                            } else {
                                                $yearsql = "";
                                            }

                                            if ($er_results == 1) {
                                                $er_resultssql = "and er_results = '1'";
                                            }
                                            if ($er_results == 0) {
                                                $er_resultssql = "and er_results = '0'";
                                            }
                                            if ($er_results == '' || $er_results == 2) {
                                                $er_resultssql = "";
                                            }

                                            // sql
                                            $sql1 = "SELECT * FROM
                                            (SELECT MAX(cs_number) AS cs_number,es_id,s_id,tm_id 
                                                FROM tb_exam_results er 
                                                INNER JOIN tb_choose_student cs ON cs.cs_id = er.cs_id 
                                                GROUP BY es_id,s_id,tm_id ) a 
                                            INNER JOIN
                                            (SELECT er_id,t_id,er_time,er_results,er_score,er_wrong,er_correct,s_name,
                                            y_id,s_group,c_id,d_id,cs_status,ck.sj_id,er.cs_id,cs_number,
                                            cs.es_id,cs.s_id,tm_id
                                                FROM  tb_exam_results er 
                                                INNER JOIN tb_choose_student cs ON cs.cs_id = er.cs_id 
                                                INNER JOIN tb_exam_set es ON es.es_id = cs.es_id
                                                INNER JOIN tb_student s ON s.s_id = cs.s_id
                                                inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                                inner join tb_subject sj on sj.sj_id = ck.sj_id ) b 

                                            ON a.cs_number=b.cs_number
                                            AND a.es_id=b.es_id 
                                            AND a.s_id=b.s_id
                                            AND a.tm_id=b.tm_id

                                            WHERE (b.s_id like '%" . $s_h . "%'||b.s_name like '%" . $s_h . "%')
                                            $subjectsql2 $termsql $exam_setsql $departmentsql 
                                            $classsql $groupsql $yearsql $er_resultssql
                                            and b.t_id = '$r->t_id'order by b.er_time DESC
                                            limit " . $this_page_first_result . "," . $results_per_page . " ";
                                            $rs1 = $con->query($sql1);
                                            while ($r1 = $rs1->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $r1->s_id ?></td>
                                                    <td><?= $r1->s_name ?></td>
                                                    <td class="text-center"><?= $r1->er_correct ?></td>
                                                    <td class="text-center"><?= $r1->er_wrong ?></td>
                                                    <td class="text-center"><?= $r1->er_score ?></td>
                                                    <td class="text-center"><?= $r1->cs_number ?></td>
                                                    <td class="text-center">
                                                        <?php if ($r1->er_results == 1) {
                                                            echo "<span class='role member'>ผ่าน</span>";
                                                        } else {
                                                            echo "<span class='role admin'>ไม่ผ่าน</span>";
                                                        } ?>
                                                    </td>
                                                    <td class="text-center"><?= $r1->er_time ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-primary view_data" ids="<?= $r1->s_id ?>" ides="<?= $r1->es_id ?>" idtm="<?= $r1->tm_id ?>" data-toggle="modal" data-target="#viewdata">
                                                            <i class="fas fa-fw fa-eye"></i>
                                                        </button>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger view_data" ids="<?= $r1->s_id ?>" ides="<?= $r1->es_id ?>" idtm="<?= $r1->tm_id ?>" delete_id="delete" data-toggle="modal" data-target="#viewdata">
                                                            <i class="fas fa-fw fa-trash-alt"></i>
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
                $sql_page = "SELECT * FROM
                (SELECT MAX(cs_number) AS cs_number,es_id,s_id,tm_id 
                    FROM tb_exam_results er 
                    INNER JOIN tb_choose_student cs ON cs.cs_id = er.cs_id 
                    GROUP BY es_id,s_id,tm_id ) a 
                INNER JOIN
                (SELECT er_id,t_id,er_time,er_results,er_score,er_wrong,er_correct,s_name,
                y_id,s_group,c_id,d_id,cs_status,ck.sj_id,er.cs_id,cs_number,
                cs.es_id,cs.s_id,tm_id
                    FROM  tb_exam_results er 
                    INNER JOIN tb_choose_student cs ON cs.cs_id = er.cs_id 
                    INNER JOIN tb_exam_set es ON es.es_id = cs.es_id
                    INNER JOIN tb_student s ON s.s_id = cs.s_id
                    inner join tb_checkteach ck on ck.ck_id = es.ck_id
                    inner join tb_subject sj on sj.sj_id = ck.sj_id ) b 

                ON a.cs_number=b.cs_number
                AND a.es_id=b.es_id 
                AND a.s_id=b.s_id
                AND a.tm_id=b.tm_id

                WHERE (b.s_id like '%" . $s_h . "%'||b.s_name like '%" . $s_h . "%')
                $subjectsql2 $termsql $exam_setsql $departmentsql 
                $classsql $groupsql $yearsql $er_resultssql
                and b.t_id = '$r->t_id'order by b.er_time DESC";
                $rs_page = $con->query($sql_page);
                $number_of_results = mysqli_num_rows($rs_page);
                $number_of_pages = ceil($number_of_results / $results_per_page);
                if ($number_of_results > $results_per_page) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-data__tool">
                                <nav>
                                    <ul class="pagination">
                                        <?php for ($i = 1; $i <= $number_of_pages; $i++) { ?>
                                            <li <?php if ($page == $i) echo 'class="page-item active"'; ?>>
                                                <a class="page-link" href="results_manage.php?page=<?php echo $i; ?>&term=<?php echo $term; ?>&exam_set=<?php echo $exam_set; ?>&department=<?php echo $department; ?>&class=<?php echo $class; ?>&group=<?php echo $group; ?>&year=<?php echo $year; ?>&er_results=<?php echo $er_results; ?>&search=<?php echo $search; ?>&subject=<?php echo $subject; ?>"><?php echo $i; ?></a>
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

    <script>
        $(document).on('click', '.view_data', function() {
            var view_ids = $(this).attr("ids");
            var view_ides = $(this).attr("ides");
            var view_idtm = $(this).attr("idtm");
            var delete_id = $(this).attr("delete_id");
            $.ajax({
                url: "results_controller.php",
                method: "POST",
                data: {
                    view_ids: view_ids,
                    view_ides: view_ides,
                    view_idtm: view_idtm,
                    delete_id: delete_id
                },
                success: function(data) {
                    $('#mydetail').html(data);
                }
            });
        });
        $(document).ready(function() {
            $('#subject').on('change', function() {
                var subject_id = $(this).val();
                $.ajax({
                    url: "results_controller.php",
                    method: "POST",
                    data: {
                        subject_es: subject_id
                    },
                    success: function(data) {
                        $('#exam_set').html(data);
                    }
                });
            });
        });
    </script>

    <script src="../css_script/swal.js"></script>
</body>

</html>