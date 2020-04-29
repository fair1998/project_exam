<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>ประวัติผลการสอบ</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php
    // search
    $term = $_GET['term'];
    $subject = $_GET['subject'];
    $exam_set = $_GET['exam_set'];

    if ($term != '') {
        $termsql = "and cs.tm_id = '$term'";
    } else {
        $termsql = "";
    }
    if ($subject != '') {
        $subjectsql = "and ck.sj_id = '$subject'";
    } else {
        $subjectsql = "";
    }
    if ($exam_set != '') {
        $exam_setsql = "and cs.es_id = '$exam_set'";
    } else {
        $exam_setsql = "";
    }
    ?>
    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2"><b>ประวัติผลการสอบ</b></h3>
                            </div>
                            <div class="filters m-b-20">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="company" class=" form-control-label">ภาคเรียน</label>
                                        <form action="results_manage.php" method="GET">
                                            <select name="term" class="form-control" id="term">
                                                <option value="">กรุณาเลือกภาคเรียน</option>
                                                <?php
                                                $sqltm = "SELECT * from tb_exam_results er
                                                inner join tb_choose_student cs on cs.cs_id = er.cs_id
                                                inner join tb_term tm on cs.tm_id = tm.tm_id
                                                where s_id = '$r->s_id' GROUP BY cs.tm_id
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
                                        <label for="company" class=" form-control-label">วิชา</label>
                                        <select name="subject" class="form-control" id="subject">
                                            <option value="">กรุณาเลือกวิชา</option>
                                            <?php
                                            $sqlsj = "SELECT * from tb_exam_results er
                                            inner join tb_choose_student cs on cs.cs_id = er.cs_id
                                            inner join tb_exam_set es on es.es_id = cs.es_id
                                            inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                            inner join tb_subject sj on sj.sj_id = ck.sj_id
                                            where s_id = '$r->s_id' $termsql group by ck.sj_id";
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
                                        <label for="company" class=" form-control-label">ชื่อชุดข้อสอบ</label>
                                        <select name="exam_set" class="form-control" id="exam_set">
                                            <option value="">กรุณาเลือกชุดข้อสอบ</option>
                                            <?php
                                            $sqles = "SELECT * from tb_exam_results er
                                            inner join tb_choose_student cs on cs.cs_id = er.cs_id
                                            inner join tb_exam_set es on es.es_id = cs.es_id
                                            inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                            where s_id = '$r->s_id' $subjectsql GROUP BY cs.es_id
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
                                    <div class="col-md-3">
                                        <div class="col-md-3">
                                            <label for="company" class=" form-control-label">ค้นหา</label>
                                            <button type="submit" class="btn btn-success">
                                                <i class="zmdi zmdi-search"></i>&nbsp; Search
                                            </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="filters">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table mytable_c table-borderless table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>ภาคเรียน</th>
                                                <th>วิชา</th>
                                                <th>ชื่อชุดข้อสอบ</th>
                                                <th>ครั้งที่</th>
                                                <th>คะแนน</th>
                                                <th>ผ่าน/ไม่ผ่าน</th>
                                                <th style="width: 5%">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // page
                                            $results_per_page = 10;
                                            if (!isset($_GET['page'])) {
                                                $page = 1;
                                            } else {
                                                $page = $_GET['page'];
                                            }
                                            $this_page_first_result = ($page - 1) * $results_per_page;

                                            // sql
                                            $sql1 = "SELECT * from tb_exam_results er
                                            inner join tb_choose_student cs on cs.cs_id = er.cs_id
                                            inner join tb_term tm on cs.tm_id = tm.tm_id
                                            inner join tb_exam_set es on es.es_id = cs.es_id
                                            inner join tb_checkteach ck on ck.ck_id = es.ck_id
                                            inner join tb_subject sj on sj.sj_id = ck.sj_id
                                            inner join tb_teacher t on t.t_id = ck.t_id
                                            where s_id = '$r->s_id' $termsql $subjectsql $exam_setsql 
                                            order by er.er_id DESC
                                            limit " . $this_page_first_result . "," . $results_per_page . " 
                                            ";
                                            $rs1 = $con->query($sql1);
                                            while ($r1 = $rs1->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $r1->tm_name ?></td>
                                                    <td><?= $r1->sj_name ?></td>
                                                    <td><?= $r1->es_name ?></td>
                                                    <td class="text-center"><?= $r1->cs_number ?></td>
                                                    <td class="text-center"><?= $r1->er_score ?></td>
                                                    <td class="text-center"><?php if ($r1->er_results == 1) {
                                                                                echo "<span class='role member'>ผ่าน</span>";
                                                                            } else {
                                                                                echo "<span class='role admin'>ไม่ผ่าน</span>";
                                                                            } ?></td>
                                                    <td>
                                                        <button class="btn btn-primary view_data" id="<?= $r1->er_id ?>" data-toggle="modal" data-target="#viewdata">
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
                $sql_page = "SELECT * from tb_exam_results er
                inner join tb_choose_student cs on cs.cs_id = er.cs_id
                inner join tb_exam_set es on es.es_id = cs.es_id
                inner join tb_checkteach ck on ck.ck_id = es.ck_id
                inner join tb_subject sj on sj.sj_id = ck.sj_id
                inner join tb_teacher t on t.t_id = ck.t_id
                where s_id = '$r->s_id' $termsql $subjectsql $exam_setsql 
                order by er.er_id DESC";
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
                                                <a class="page-link" href="results_manage.php?page=<?php echo $i; ?>&term=<?php echo $term; ?>&subject=<?php echo $subject; ?>&exam_set=<?php echo $exam_set; ?>"><?php echo $i; ?></a>
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
        $(document).ready(function() {
            var choose_term = "";
            var choose_subject = "";
            var choose_exam_set = "";
            $('#term').on('change', function() {
                var term = $(this).val();
                $.ajax({
                    url: "exam_controller.php",
                    method: "POST",
                    data: {
                        term: term,
                        choose_subject: choose_subject
                    },
                    success: function(data) {
                        $('#subject').html(data);
                    }
                });
                $.ajax({
                    url: "exam_controller.php",
                    method: "POST",
                    data: {
                        term: term,
                        choose_exam_set: choose_exam_set
                    },
                    success: function(data) {
                        $('#exam_set').html(data);
                    }
                });
            });
            $('#subject').on('change', function() {
                var term = document.getElementById("term").value;
                var subject = $(this).val();
                $.ajax({
                    url: "exam_controller.php",
                    method: "POST",
                    data: {
                        term: term,
                        subject: subject,
                        choose_exam_set: choose_exam_set
                    },
                    success: function(data) {
                        $('#exam_set').html(data);
                    }
                });
            });
        });
    </script>
    <!-- end script -->

</body>

</html>