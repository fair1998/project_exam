<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>แก้ไขข้อมูลอาจารย์</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>

    <!-- content -->
    <div class="row">
        <div class="col-lg-10 mr-auto ml-auto">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-md-3">
                            <button type="button" class="btn btn-info" onclick="window.location.href='teacher_manage.php'">
                                Back
                            </button>
                        </div>
                        <div class="col-md-9">
                            <strong>แก้ไขข้อมูลอาจารย์</strong>
                        </div>
                    </div>
                </div>
                <div class="card-body card-block">
                    <?php
                    $sql1 = "SELECT * from tb_teacher where t_id = '" . $_GET["id"] . "'";
                    $rs1 = $con->query($sql1);
                    $r1 = $rs1->fetch_object();
                    ?>
                    <form action="teacher_controller.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">รหัสประจำตัวอาจารย์</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <p class="form-control-static"><?= $r1->t_id ?></p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">รหัสผ่าน</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="password" name="password" value="<?= $r1->t_password ?>" maxlength="20" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">ชื่อ-นามสกุล</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="name" value="<?= $r1->t_name ?>" maxlength="40" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">เบอร์โทรศัพท์</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="tel" value="<?= $r1->t_tel ?>" pattern="[0-9]{1,}" maxlength="10" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">แผนกวิชา</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="d_id" class="form-control" required>
                                    <?php
                                    $sqld = "SELECT * from tb_department";
                                    $rsd = $con->query($sqld);
                                    while ($rd = $rsd->fetch_object()) {
                                    ?>
                                        <option value="<?= $rd->d_id; ?>" <?php if ($r1->d_id == $rd->d_id) {
                                                                                echo "selected";
                                                                            } ?>>
                                            <?php echo $rd->d_name; ?></option>
                                    <?php }; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class="form-control-label">รูปโปรไฟล์</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" accept="image/*" id="myfilename" name="image" class="form-control-file">
                                <img id="myshowImage" src="../images/<?= $r1->t_image ?>" />
                            </div>
                        </div>
                </div>
                <div class="card-footer" align="center">
                    <input type="hidden" name="id" value="<?= $r1->t_id ?>">
                    <input type="hidden" name="update" value="update">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <button type="reset" id="resetimage" reimage="<?= $r1->t_image ?>" class="btn btn-danger">
                        <i class="fa fa-ban"></i> Reset
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end content -->

    <?php include("footer.php"); ?>
    <?php include("../script.php"); ?>
</body>

</html>