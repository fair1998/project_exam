<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>หน้าหลัก</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>

    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mr-auto ml-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2"><b>วิชา</b></h3>
                            </div>
                            <hr>
                            <div class="filters">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table mytable_c table-borderless table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <td>รหัสวิชา</td>
                                                <td>ชื่อวิชา</td>
                                                <td>หน่วยกิต</td>
                                                <td>ระดับชั้น</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // sql
                                            $sql1 = "SELECT * from tb_checkteach ck
                                            inner join tb_subject sj on sj.sj_id = ck.sj_id
                                            where t_id = '$r->t_id'";
                                            $rs1 = $con->query($sql1);
                                            while ($r1 = $rs1->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $r1->sj_id ?></td>
                                                    <td><?= $r1->sj_name ?></td>
                                                    <td class="text-center"><?= $r1->sj_credit ?></td>
                                                    <td class="text-center"><?php if ($r1->sj_class == 1) {
                                                                                echo "ปวช";
                                                                            } elseif ($r1->sj_class == 2) {
                                                                                echo "ปวส";
                                                                            } else {
                                                                                echo "ป.ตรี";
                                                                            } ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-4">
                    <div class="user-data m-b-30">
                        <div class="filters">
                            <table>
                                <tr>
                                    <td>sssss</td>
                                </tr>
                                <tr>
                                    <td>sssss</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div> -->
            </div>
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
    </script>
    <!-- end script -->
</body>

</html>