<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>เลือกข้อมูล</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>

    <!-- content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="user-data m-b-30">

                <!-- row 1 -->
                <div class="filters m-b-30">
                    <div class="row">
                        <div class="col-lg-6">
                            <h3 class="title-3">
                                Select data
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- end row 1 -->

                <!-- row 2 -->
                <div class="filters m-b-20">
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="exam_select.php" method="GET">
                                <select name="class" class="form-control">
                                    <?php $class = $_GET['class']; ?>
                                    <option value="">กรุณาเลือกระดับชั้น</option>
                                    <option value="1" <?php if ($class == 1) {
                                                            echo "selected";
                                                        } ?>>ปวช</option>
                                    <option value="2" <?php if ($class == 2) {
                                                            echo "selected";
                                                        } ?>>ปวส</option>
                                    <option value="3" <?php if ($class == 3) {
                                                            echo "selected";
                                                        } ?>>ป.ตรี</option>
                                </select>
                        </div>
                        <div class="col-lg-4">
                            <input type="text" name="search" class=" form-control">
                        </div>
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search"></i> Search
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end row 2 -->

                <!-- row 3 -->
                <div class="filters">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table mytable_c table-borderless table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>อาจารย์</th>
                                    <th>วิชา</th>
                                    <th>Select</th>
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
                                if ($class != '') {
                                    $classsql = "and sj.sj_class = '$class'";
                                } else {
                                    $classsql = "";
                                }

                                // sql
                                $sql1 = "SELECT * from tb_checkteach ck
                                inner join tb_teacher t on t.t_id = ck.t_id
                                inner join tb_subject sj on sj.sj_id = ck.sj_id
                                where (t_name like '%" . $s_h . "%'
                                ||sj_name like '%" . $s_h . "%')
                                $classsql
                                limit " . $this_page_first_result . "," . $results_per_page . " 
                                ";
                                $rs1 = $con->query($sql1);
                                while ($r1 = $rs1->fetch_object()) {
                                ?>
                                    <tr>
                                        <td><?= $r1->t_name ?></td>
                                        <td><?= $r1->sj_name ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-warning" href="exam_manage.php?ck_id=<?= $r1->ck_id; ?>">
                                                <i class="fas fa-fw fa-check"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end row 3 -->

            </div>
        </div>
    </div>
    <!-- end content -->

    <!-- page -->
    <div>
        <?php
        $sql_page = "SELECT * from tb_checkteach ck
        inner join tb_teacher t on t.t_id = ck.t_id
        inner join tb_subject sj on sj.sj_id = ck.sj_id
        where (t_name like '%" . $s_h . "%'
        ||sj_name like '%" . $s_h . "%')
        $classsql";
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
                                        <a class="page-link" href="exam_select.php?page=<?php echo $i; ?>&search=<?php echo $s_h; ?>&class=<?php echo $class; ?>"><?php echo $i; ?></a>
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
</body>

</html>