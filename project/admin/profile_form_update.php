<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>แก้ไขโปรไฟล์</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>

    <!-- content -->
    <div class="row">
        <div class="col-lg-10 mr-auto ml-auto">
            <div class="card">
                <div class="card-header text-center">
                    <strong>แก้ไขโปรไฟล์</strong>
                </div>
                <div class="card-body card-block">
                    <form action="profile_controller.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">ไอดี</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <p class="form-control-static"><?= $r->a_id ?></p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">รหัสผ่าน ปัจจุบัน</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="password" name="a_password" maxlength="20" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">รหัสผ่าน ใหม่</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="password" name="new_a_password" maxlength="20" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">ชื่อ-นามสกุล</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="a_name" value="<?= $r->a_name ?>" maxlength="40" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">อีเมล์</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="email" name="a_email" value="<?= $r->a_email ?>" maxlength="35" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">เบอร์โทรศัพท์</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="a_tel" value="<?= $r->a_tel ?>" pattern="[0-9]{1,}" maxlength="10" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class="form-control-label">รูปโปรไฟล์</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" accept="image/*" id="myfilename" name="a_image" class="form-control-file">
                                <img id="myshowImage" src="../images/<?= $r->a_image ?>" />
                            </div>
                        </div>
                </div>
                <div class="card-footer" align="center">
                    <input type="hidden" name="update" value="update">
                    <input type="hidden" name="a_id" value="<?= $r->a_id ?>">
                    <input type="hidden" name="old_a_password" value="<?= $r->a_password ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-dot-circle-o"></i> Submit
                    </button>
                    <button type="reset" id="resetimage" reimage="<?= $r->a_image ?>" class="btn btn-danger">
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