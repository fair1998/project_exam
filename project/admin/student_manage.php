<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>ข้อมูลนักศึกษา</title>
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
                        <div class="col-md-4">
                            <h3 class="title-3">
                                Student data
                            </h3>
                        </div>
                        <div class="col-md-4 ml-auto" align="right">
                            <a href="student_form_insert.php" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add Student
                            </a>
                        </div>
                    </div>
                </div>
                <!-- row 1 -->

                <!-- row 2 -->
                <div class="filters m-b-20">
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="student_manage.php" method="GET">
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
                                <option value="">ระดับชั้น</option>
                                <?php
                                $myclass = $_GET['myclass'];
                                $sqlc = "SELECT * from tb_class";
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
                                <option value="">กลุ่ม</option>
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
                    </div>
                </div>
                <!-- row 2 -->

                <!-- row 3 -->
                <div class="filters m-b-40">
                    <div class="row">
                        <div class="col-lg-4">
                            <select name="year" class="form-control">
                                <option value="">ปีการศึกษา</option>
                                <?php
                                $year = $_GET['year'];
                                $sqly = "SELECT * from tb_year order by y_id DESC";
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
                <!-- row 3 -->

                <!-- row 4 -->
                <div class="filters">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table mytable_c table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 20%">รูปโปรไฟล์</th>
                                    <th style="width: 30%">รหัสประจำตัวนักศึกษา</th>
                                    <th style="width: 35%">ชื่อ-นามสกุล</th>
                                    <th style="width: 5%">View</th>
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
                                if ($dep != '') {
                                    $depsql = "and d_id = '$dep'";
                                } else {
                                    $depsql = "";
                                }
                                if ($myclass != '') {
                                    $myclasssql = "and c_id = '$myclass'";
                                } else {
                                    $myclasssql = "";
                                }
                                if ($group != '') {
                                    $groupsql = "and s_group = '$group'";
                                } else {
                                    $groupsql = "";
                                }
                                if ($year != '') {
                                    $yearsql = "and y_id = '$year'";
                                } else {
                                    $yearsql = "";
                                }

                                // sql
                                $sql1 = "SELECT * from tb_student
                                where (s_id like '%" . $s_h . "%'
                                ||s_name like '%" . $s_h . "%')
                                $depsql $myclasssql $groupsql $yearsql
                                limit " . $this_page_first_result . "," . $results_per_page . " ";
                                $rs1 = $con->query($sql1);
                                while ($r1 = $rs1->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <div class="avatar">
                                                <img src="../images/<?= $r1->s_image ?>">
                                            </div>
                                        </td>
                                        <td><?= $r1->s_id ?></td>
                                        <td><?= $r1->s_name ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary view_data" id="<?= $r1->s_id ?>" data-toggle="modal" data-target="#viewdata">
                                                <i class="fas fa-fw fa-eye"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="student_form_update.php?id=<?= $r1->s_id; ?>">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger view_data" id="<?= $r1->s_id ?>" delete_id="<?= $r1->s_id ?>" data-toggle="modal" data-target="#viewdata">
                                                <i class="fas fa-fw fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- row 4 -->
            </div>
        </div>
    </div>
    <!-- end content -->

    <!-- page -->
    <div>
        <?php
        $sql_page = "SELECT * from tb_student
        where (s_id like '%" . $s_h . "%'
        ||s_name like '%" . $s_h . "%')
        $depsql
        $myclasssql
        $groupsql
        $yearsql";
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
                                        <a class="page-link" href="student_manage.php?page=<?php echo $i; ?>&search=<?php echo $s_h; ?>&dep=<?php echo $dep; ?>&myclass=<?php echo $myclass; ?>&group=<?php echo $group; ?>&year=<?php echo $year; ?>"><?php echo $i; ?></a>
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
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <h4 class="modal-title">ข้อมูลนักศึกษา</h4>
                </div>
                <div class="modal-body" id="mydetail">
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
            var delete_id = $(this).attr("delete_id");
            $.ajax({
                url: "student_controller.php",
                method: "POST",
                data: {
                    view: view_id,
                    delete_id: delete_id
                },
                success: function(data) {
                    $('#mydetail').html(data);
                }
            });
        });
    </script>
    <!-- end script -->

    <script src="../css_script/swal.js"></script>
</body>

</html>