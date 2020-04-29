<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>แก้ไขหน่วยการเรียน</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>
    <?php
    $u_id = $_GET["unit"];
    $sql1 = "SELECT * from tb_unit u
    inner join tb_checkteach ck on ck.ck_id = u.ck_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id 
    where ck.t_id = '$r->t_id' and u_id = '$u_id'";
    $rs1 = $con->query($sql1);
    $r1 = $rs1->fetch_object();
    ?>
    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row">
                <div class="col-md-7 mr-auto ml-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title m-b-30">
                                <button type="button" class="btn btn-info" onclick="window.location.href='unit_manage.php'">
                                    Back
                                </button>
                                <h3 class="text-center title-2"><b>แก้ไขหน่วยการเรียน</b></h3>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="filters">
                                        <form action="unit_controller.php" method="post" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">วิชา</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <label class=" form-control-label"><?= $r1->sj_name ?></label>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">หน่วย</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <label class=" form-control-label"><?= $r1->u_unit ?></label>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">ชื่อหน่วย</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="u_name" rows="2" maxlength="100" class="form-control" required><?= $r1->u_name ?></textarea>
                                                </div>
                                            </div>
                                            <div align="center">
                                                <input type="hidden" name="update" value="<?= $u_id ?>">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-dot-circle-o"></i> Submit
                                                </button>
                                                <button type="reset" class="btn btn-danger">
                                                    <i class="fa fa-ban"></i> Reset
                                                </button>
                                        </form>
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

    <script src="../css_script/swal.js"></script>

</body>

</html>