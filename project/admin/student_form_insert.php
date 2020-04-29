<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>เพิ่มข้อมูลนักศึกษา</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>

    <!-- content -->
    <div class="row">
        <div class="col-lg-10 mr-auto ml-auto">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-md-3">
                            <button type="button" class="btn btn-info" onclick="window.location.href='student_manage.php'">
                                Back
                            </button>
                        </div>
                        <div class="col-md-9">
                            <strong>เพิ่มข้อมูลนักศึกษา</strong>
                        </div>
                    </div>
                </div>
                <div class="card-body card-block">
                    <form action="student_controller.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">รหัสประจำตัวนักศึกษา</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="s_id" pattern="[0-9]{1,}" title="กรอกตัวเลขเท่านั้น" maxlength="10" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">รหัสผ่าน</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="password" name="s_password" maxlength="20" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">ชื่อ-นามสกุล</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="s_name" maxlength="40" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">ระดับชั้น</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="c_id" class="form-control" required>
                                    <option value="">กรุณาเลือกระดับชั้น</option>
                                    <?php
                                    $sqlc = "SELECT * from tb_class";
                                    $rsc = $con->query($sqlc);
                                    while ($rc = $rsc->fetch_object()) {
                                    ?>
                                        <option value="<?= $rc->c_id; ?>"><?php echo $rc->c_name; ?></option>
                                    <?php }; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">กลุ่ม</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="s_group" pattern="[0-9]{1,}" title="กรอกตัวเลขเท่านั้น" maxlength="2" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">แผนกวิชา</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="d_id" class="form-control" required>
                                    <option value="">กรุณาเลือกแผนกวิชา</option>
                                    <?php
                                    $sqld = "SELECT * from tb_department";
                                    $rsd = $con->query($sqld);
                                    while ($rd = $rsd->fetch_object()) {
                                    ?>
                                        <option value="<?= $rd->d_id; ?>"><?php echo $rd->d_name; ?></option>
                                    <?php }; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">ปีการศึกษา</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="y_id" class="form-control" required>
                                    <option value="">กรุณาเลือกปีการศึกษา</option>
                                    <?php
                                    $sqly = "SELECT * from tb_year order by y_id desc";
                                    $rsy = $con->query($sqly);
                                    while ($ry = $rsy->fetch_object()) {
                                    ?>
                                        <option value="<?= $ry->y_id; ?>"><?php echo $ry->y_name; ?></option>
                                    <?php }; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class="form-control-label">รูปโปรไฟล์</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" accept="image/*" id="myfilename" name="s_image" class="form-control-file">
                                <img id="myshowImage" />
                            </div>
                        </div>
                </div>
                <div class="card-footer" align="center">
                    <input type="hidden" name="insert" value="insert">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <button type="reset" id="myreset" class="btn btn-danger">
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