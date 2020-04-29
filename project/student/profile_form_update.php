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

    <section class="au-breadcrumb2">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mr-auto ml-auto">
                    <div class="card">
                        <div class="card-header text-center">
                            <strong>แก้ไขโปรไฟล์</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="profile_controller.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">รหัสประจำตัวนักศึกษา</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <?= $r->s_id ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">ชื่อ-นามสกุล</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <?= $r->s_name ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">ระดับชั้น</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <?= $r->c_name ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">กลุ่ม</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <?= $r->s_group ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">แผนกวิชา</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <?= $r->d_name ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">ปีการศึกษา</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <?= $r->y_name ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">รหัสผ่าน ปัจจุบัน</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="password" name="s_password" maxlength="20" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class=" form-control-label">รหัสผ่าน ใหม่</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="password" name="new_s_password" maxlength="20" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label class="form-control-label">รูปโปรไฟล์</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="file" accept="image/*" id="myfilename" name="s_image" class="form-control-file">
                                        <img id="myshowImage" src="../images/<?= $r->s_image ?>">
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer" align="center">
                            <input type="hidden" name="update" value="update">
                            <input type="hidden" name="s_id" value="<?= $r->s_id ?>">
                            <input type="hidden" name="old_s_password" value="<?= $r->s_password ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                            <button type="reset" id="resetimage" reimage="<?= $r->s_image ?>" class="btn btn-danger">
                                <i class="fa fa-ban"></i> Reset
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("footer.php"); ?>
    <?php include("../script.php"); ?>
</body>

</html>