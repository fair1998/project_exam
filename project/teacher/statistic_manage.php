<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>สถิติการสอบ</title>
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
                                </div>
                                <h3 class="text-center title-2"><b>อัตราการสอบ ผ่าน / ไม่ผ่าน</b></h3>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12 m-b-20">
                                            <form action="statistic_manage.php" method="GET">
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
                                                        <th>ชุดข้อสอบ</th>
                                                        <th style="width: 35%">อัตราการสอบผ่าน</th>
                                                        <th style="width: 5%">ทั้งหมด</th>
                                                        <th style="width: 5%">ผ่าน</th>
                                                        <th style="width: 9%">ไม่ผ่าน</th>
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
                                                            <td><a href="statistic_exam.php?exam_set=<?= $r1->es_id ?>"><?= $r1->es_name ?></a></td>
                                                            <td class="text-center">
                                                                <?php
                                                                $sql2 = "SELECT COUNT(*) AS full from tb_exam_results er
                                                                inner join tb_choose_student cs on cs.cs_id = er.cs_id
                                                                WHERE es_id = '$r1->es_id'";
                                                                $rs2 = $con->query($sql2);
                                                                $r2 = $rs2->fetch_object();
                                                                $full = $r2->full;

                                                                $sql3 = "SELECT COUNT(*) AS past from tb_exam_results er
                                                                inner join tb_choose_student cs on cs.cs_id = er.cs_id
                                                                WHERE es_id = '$r1->es_id' AND er_results = '1'";
                                                                $rs3 = $con->query($sql3);
                                                                $r3 = $rs3->fetch_object();
                                                                $past = $r3->past;

                                                                $sql4 = "SELECT COUNT(*) AS not_passed from tb_exam_results er
                                                                inner join tb_choose_student cs on cs.cs_id = er.cs_id
                                                                WHERE es_id = '$r1->es_id' AND er_results = '0'";
                                                                $rs4 = $con->query($sql4);
                                                                $r4 = $rs4->fetch_object();
                                                                $not_passed = $r4->not_passed;

                                                                if ($full != 0) {
                                                                    $ave = ($past / $full) * 100;
                                                                } else {
                                                                    $ave = 0;
                                                                }
                                                                ?>
                                                                <div class="progress mb-2">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $ave . "%" ?>" aria-valuenow="<?= $ave ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($ave) ?>%</div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center"><?= $full ?></td>
                                                            <td class="text-center"><?= $past ?></td>
                                                            <td class="text-center"><?= $not_passed ?></td>
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
    <?php include("../script.php"); ?>
</body>

</html>