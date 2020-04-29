<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>จัดการหน่วยการเรียน</title>
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
                                    <div class="col-md-12" align="right">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#unit_insert">
                                        <i class="fas fa-plus"></i> Add unit
                                        </button>
                                    </div>
                                </div>
                                <h3 class="text-center title-2"><b>จัดการหน่วยการเรียน</b></h3>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12 m-b-20">
                                            <form action="unit_manage.php" method="GET">
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
                                                        <th>หน่วยการเรียน</th>
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
                                                    if ($subject != '') {
                                                        $subjectsql = "and ck.sj_id= '$subject'";
                                                    } else {
                                                        $subjectsql = "";
                                                    }

                                                    // sql
                                                    $sql1 = "SELECT * from tb_unit u
                                                    inner join tb_checkteach ck on ck.ck_id = u.ck_id
                                                    where (u_unit like '%" . $s_h . "%'
                                                    || u_name like '%" . $s_h . "%')
                                                    and ck.t_id = '$r->t_id' $subjectsql
                                                    order by u_unit 
                                                    limit " . $this_page_first_result . "," . $results_per_page . " ";
                                                    $rs1 = $con->query($sql1);
                                                    while ($r1 = $rs1->fetch_object()) {
                                                    ?>
                                                        <tr>
                                                            <td>หน่วยที่ <?= $r1->u_unit ?> <?= $r1->u_name ?></td>
                                                            <td>
                                                                <a class="btn btn-success" href="unit_form_update.php?unit=<?= $r1->u_id ?>">
                                                                    <i class="fas fa-fw fa-edit"></i>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger view_data" id="<?= $r1->u_id ?>" delete_id="dalete" data-toggle="modal" data-target="#viewdata">
                                                                    <i class="fas fa-fw fa-trash-alt"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- page -->
                                        <div>
                                            <?php
                                            $sql_page = "SELECT * from tb_unit u
                                            inner join tb_checkteach ck on ck.ck_id = u.ck_id
                                            where (u_unit like '%" . $s_h . "%'
                                            || u_name like '%" . $s_h . "%')
                                            and ck.t_id = '$r->t_id' $subjectsql
                                            order by u_unit ";
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
                                                                            <a class="page-link" href="unit_manage.php?page=<?php echo $i; ?>&subject=<?php echo $subject; ?>&search=<?php echo $s_h; ?>"><?php echo $i; ?></a>
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

    <!-- modal -->
    <div class="modal fade" id="viewdata" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="unit">

            </div>
        </div>
    </div>

    <div class="modal fade" id="unit_insert" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <h4 class="modal-title">เพิ่ม หน่วยการเรียน</h4>
                </div>
                <div class="modal-body">
                    <form action="unit_form_insert.php" method="GET">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>วิชา</strong></label>
                                        <select name="checkteach" class="form-control" required>
                                            <option value="">กรุณาเลือกวิชา</option>
                                            <?php
                                            $sqlck = "SELECT * from tb_checkteach ck
                                            inner join tb_subject sj on sj.sj_id = ck.sj_id
                                            where ck.t_id = '$r->t_id'";
                                            $rsck = $con->query($sqlck);
                                            while ($rck = $rsck->fetch_object()) {
                                            ?>
                                                <option value="<?= $rck->ck_id; ?>"><?= $rck->sj_name; ?></option>
                                            <?php }; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
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
        $(document).on('click', '.view_data', function() {
            var view_id = $(this).attr("id");
            var delete_id = $(this).attr("delete_id");
            $.ajax({
                url: "unit_controller.php",
                method: "POST",
                data: {
                    view: view_id,
                    delete_id: delete_id
                },
                success: function(data) {
                    $('#unit').html(data);
                }
            });
        });
    </script>
    <!-- end script -->

    <script src="../css_script/swal.js"></script>

</body>

</html>