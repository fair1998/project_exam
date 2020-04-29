<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>เพิ่มข้อมูลวิชา</title>
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
                            <button type="button" class="btn btn-info" onclick="window.location.href='subject_manage.php'">
                                Back
                            </button>
                        </div>
                        <div class="col-md-9">
                            <strong>เพิ่มข้อมูลวิชา</strong>
                        </div>
                    </div>
                </div>
                <div class="card-body card-block">
                    <form action="subject_controller.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">รหัสวิชา</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="id" maxlength="9" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">ชื่อวิชา</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea name="name" rows="2" maxlength="150" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">หน่วยกิต</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" name="credit" pattern="[0-9]{1,}" maxlength="1" class="form-control" required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label">ระดับชั้น</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <select name="class" class="form-control" required>
                                    <option value="">กรุณาเลือกระดับชั้น</option>
                                    <option value="1">ปวช</option>
                                    <option value="2">ปวส</option>
                                    <option value="3">ป.ตรี</option>
                                </select>
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