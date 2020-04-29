<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>ลงทะเบียนการสอน</title>
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
                                Teaching registration data
                            </h3>
                        </div>
                        <div class="col-lg-6" align="right">
                            <a href="checkteach_form_insert.php" class="btn btn-success">
                                <i class="fas fa-plus"></i> Registration
                            </a>
                        </div>
                    </div>
                </div>
                <!-- end row 1 -->

                <!-- row 2 -->
                <div class="filters m-b-20">
                    <div class="row">
                        <div class="col-lg-4">
                            <form action="checkteach_manage.php" method="GET">
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

                                // sql
                                $sql1 = "SELECT * from tb_checkteach ck
                                inner join tb_teacher t on t.t_id = ck.t_id
                                inner join tb_subject sj on sj.sj_id = ck.sj_id
                                where (t.t_name like '%" . $s_h . "%'
                                ||sj.sj_name like '%" . $s_h . "%')
                                limit " . $this_page_first_result . "," . $results_per_page . "";
                                $rs1 = $con->query($sql1);
                                while ($r1 = $rs1->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <button type="button" class="view_teacher" id="<?= $r1->t_id ?>" data-toggle="modal" data-target="#viewteacher">
                                                <?= $r1->t_name ?>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="view_subject" id="<?= $r1->sj_id ?>" data-toggle="modal" data-target="#viewsubject">
                                                <?= $r1->sj_name ?>
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-success" href="checkteach_form_update.php?id=<?= $r1->ck_id; ?>">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger view_data" id="<?= $r1->ck_id ?>" data-toggle="modal" data-target="#viewdata">
                                                <i class="fas fa-fw fa-trash-alt"></i>
                                            </button>
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
        where (t.t_name like '%" . $s_h . "%'
        ||sj.sj_name like '%" . $s_h . "%')";
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
                                        <a class="page-link" href="checkteach_manage.php?page=<?php echo $i; ?>&search=<?php echo $s_h; ?>"><?php echo $i; ?></a>
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
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <h4 class="modal-title">ข้อมูลการลงทะเบียนการสอน</h4>
                </div>
                <div class="modal-body" id="checkteach">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewteacher" tabindex="-1" role="dialog" aria-labelledby="viewteacher" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <h4 class="modal-title">ข้อมูลอาจารย์</h4>
                </div>
                <div class="modal-body" id="teacher">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewsubject" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <h4 class="modal-title">ข้อมูลวิชา</h4>
                </div>
                <div class="modal-body" id="subject">
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
                url: "checkteach_controller.php",
                method: "POST",
                data: {
                    view: view_id
                },
                success: function(data) {
                    $('#checkteach').html(data);
                }
            });
        });
        $(document).on('click', '.view_teacher', function() {
            var view_id = $(this).attr("id");
            $.ajax({
                url: "teacher_controller.php",
                method: "POST",
                data: {
                    view: view_id
                },
                success: function(data) {
                    $('#teacher').html(data);
                }
            });
        });
        $(document).on('click', '.view_subject', function() {
            var view_id = $(this).attr("id");
            $.ajax({
                url: "subject_controller.php",
                method: "POST",
                data: {
                    view: view_id
                },
                success: function(data) {
                    $('#subject').html(data);
                }
            });
        });
    </script>
    <!-- end script -->

    <script src="../css_script/swal.js"></script>
</body>

</html>