<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>ข้อมูลวิชา</title>
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
                                Subject data
                            </h3>
                        </div>
                        <div class="col-md-4 ml-auto" align="right">
                            <a href="subject_form_insert.php" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add Subject
                            </a>
                        </div>
                    </div>
                </div>
                <!-- row 1 -->

                <!-- row 2 -->
                <div class="filters m-b-40">
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="subject_manage.php" method="GET">
                                <?php
                                $class = $_GET['class'];
                                ?>
                                <select name="class" class="form-control">
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
                <!-- row 2 -->

                <!-- row 3 -->
                <div class="filters">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table mytable_c table-borderless table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 15%" class="text-center">รหัสวิชา</th>
                                    <th style="width: 70%" class="text-center">ชื่อวิชา</th>
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
                                if ($class != '') {
                                    $classsql = "and sj_class = '$class'";
                                } else {
                                    $classsql = "";
                                }

                                // sql 
                                $sql1 = "SELECT * from tb_subject 
                                where (sj_id like '%" . $s_h . "%'
                                ||sj_name like '%" . $s_h . "%')
                                $classsql
                                limit " . $this_page_first_result . "," . $results_per_page . " ";
                                $rs1 = $con->query($sql1);
                                while ($r1 = $rs1->fetch_object()) {
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $r1->sj_id ?></td>
                                        <td><?= $r1->sj_name ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary view_data" id="<?= $r1->sj_id ?>" data-toggle="modal" data-target="#viewdata">
                                                <i class="fas fa-fw fa-eye"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="subject_form_update.php?id=<?= $r1->sj_id; ?>">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger view_data" id="<?= $r1->sj_id ?>" delete_id="<?= $r1->sj_id ?>" data-toggle="modal" data-target="#viewdata">
                                                <i class="fas fa-fw fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- row 3 -->

            </div>
        </div>
    </div>
    <!-- end content -->

    <!-- page -->
    <div>
        <?php
        $sql_page = "SELECT * from tb_subject 
        where (sj_id like '%" . $s_h . "%'
        ||sj_name like '%" . $s_h . "%')
        $classsql";
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
                                        <a class="page-link" href="subject_manage.php?page=<?php echo $i; ?>&search=<?php echo $s_h; ?>"><?php echo $i; ?></a>
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
                    <h4 class="modal-title">ข้อมูลวิชา</h4>
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
                url: "subject_controller.php",
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