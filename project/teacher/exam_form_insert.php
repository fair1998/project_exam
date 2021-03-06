<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>เพิ่มข้อสอบ</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>
    <?php
    $ck_id = $_GET["checkteach"];
    $es_id = $_GET["exam_set"];
    $sql1 = "SELECT * from tb_checkteach ck
    inner join tb_subject sj on sj.sj_id = ck.sj_id 
    where ck_id = '$ck_id'";
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
                                <?php if ($es_id != '') { ?>
                                    <button type="button" class="btn btn-info" onclick="window.location.href='exam_set_choose_exam_insert.php?exam_set=<?= $es_id ?>'">
                                        Back
                                    </button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-info" onclick="window.location.href='exam_manage.php'">
                                        Back
                                    </button>
                                <?php } ?>
                                <h3 class="text-center title-2"><b>เพิ่มข้อสอบ</b></h3>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="filters">
                                        <form action="exam_controller.php" method="post" enctype="multipart/form-data" class="form-horizontal">
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
                                                    <select name="u_id" class="form-control" required>
                                                        <option value="">กรุณาเลือกหน่วย</option>
                                                        <?php
                                                        $sqlu = "SELECT * from tb_unit u
                                                        inner join tb_checkteach ck on ck.ck_id = u.ck_id
                                                        where ck.t_id = '$r->t_id' and u.ck_id = '$ck_id' order by u_unit ";
                                                        $rsu = $con->query($sqlu);
                                                        while ($ru = $rsu->fetch_object()) {
                                                        ?>
                                                            <option value="<?= $ru->u_id; ?>">หน่วยที่ <?= $ru->u_unit; ?> <?= $ru->u_name; ?></option>
                                                        <?php }; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">คำถาม</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="e_qt" rows="2" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class="form-control-label"></label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" accept="image/*" id="imge_qt" name="e_qt_im" class="form-control-file">
                                                    <img class="showimg" id="showimge_qt" />
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">ก.</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="e_c1" rows="2" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class="form-control-label"></label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" accept="image/*" id="imge_c1" name="e_c1_im" class="form-control-file">
                                                    <img class="showimg" id="showimge_c1" />
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">ข.</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="e_c2" rows="2" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class="form-control-label"></label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" accept="image/*" id="imge_c2" name="e_c2_im" class="form-control-file">
                                                    <img class="showimg" id="showimge_c2" />
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">ค.</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="e_c3" rows="2" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class="form-control-label"></label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" accept="image/*" id="imge_c3" name="e_c3_im" class="form-control-file">
                                                    <img class="showimg" id="showimge_c3" />
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">ง.</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <textarea name="e_c4" rows="2" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class="form-control-label"></label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" accept="image/*" id="imge_c4" name="e_c4_im" class="form-control-file">
                                                    <img class="showimg" id="showimge_c4" />
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">เฉลย</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <div class="form-check-inline form-check">
                                                        <label class="form-check-label ">
                                                            <input type="radio" name="e_aw" value="1" class="form-check-input" checked>ตอบ 1
                                                        </label>
                                                        <label class="form-check-label ">
                                                            <input type="radio" name="e_aw" value="2" class="form-check-input">ตอบ 2
                                                        </label>
                                                        <label class="form-check-label ">
                                                            <input type="radio" name="e_aw" value="3" class="form-check-input">ตอบ 3
                                                        </label>
                                                        <label class="form-check-label ">
                                                            <input type="radio" name="e_aw" value="4" class="form-check-input">ตอบ 4
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div align="center">
                                                <input type="hidden" name="insert" value="<?= $ck_id ?>">
                                                <input type="hidden" name="exam_set" value="<?= $es_id ?>">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-dot-circle-o"></i> Submit
                                                </button>
                                                <button type="reset" id="resetimge" class="btn btn-danger">
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