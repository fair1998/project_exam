<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST["view"])) {
    $e_id = $_POST['view'];
    $ck_id = $_POST['ck_id'];
    $output = '';
    $query = "SELECT * from tb_exam WHERE e_id = '$e_id'";
    $result = $con->query($query);

    $output .= '
        <div class="modal-header" align="center">
            <h4 class="modal-title">ข้อมูลข้อสอบ</h4>
        </div>
        <div class="modal-body">
            <div class="container-fluid myplr35">
                <div class="row">';
    while ($row = $result->fetch_object()) {
        $output .= '
                    <div class="col-lg-12">
                        <div class="row form-group">
                            <div class="col">
                                <label class=" form-control-label"><strong>คำถาม </strong>' . nl2br(htmlspecialchars($row->e_qt)) . '</label>
                            </div>
                        </div>
                    </div>';
        if ($row->e_qt_im != '') {
            $output .= '
                    <div class="col-lg-12">
                        <div class="row form-group">
                            <div class="col">
                                <img src="../images/' . $row->e_qt_im . '">
                            </div>
                        </div>
                    </div>';
        }
        for ($i = 1; $i <= 4; $i++) {
            $output .= '<div class="col-lg-12">   
                            <div class="row form-group';

            if ($row->e_aw == $i) {
                $output .= ' text-danger';
            }
            if ($i == 1) {
                $e_c = $row->e_c1;
                $e_c_im = $row->e_c1_im;
            } elseif ($i == 2) {
                $e_c = $row->e_c2;
                $e_c_im = $row->e_c2_im;
            } elseif ($i == 3) {
                $e_c = $row->e_c3;
                $e_c_im = $row->e_c3_im;
            } else {
                $e_c = $row->e_c4;
                $e_c_im = $row->e_c4_im;
            }

            $output .= '    ">
                                <div class="col-md-1">
                                    <label class=" form-control-label"><strong>';
                                    if ($i == 1) {
                                        $output .= 'ก';
                                    } elseif ($i == 2) {
                                        $output .= 'ข';
                                    } elseif ($i == 3) {
                                        $output .= 'ค';
                                    } else {
                                        $output .= 'ง';
                                    }
                                    $output .= '.</strong></label>
                                </div>
                                <div class="col" style="padding-left: 4px;">
                                    <label class=" form-control-label">' . nl2br(htmlspecialchars($e_c)) . '</label>
                                </div>
                            </div>  
                    </div>';
            if ($e_c_im != '') {
                $output .= '
                    <div class="col-lg-12">
                        <div class="row form-group">
                                <div class="col-md-1">
                                    <label class=" form-control-label"></label>
                                </div>  
                            <div class="col" style="padding-left: 4px;">
                                <img src="../images/' . $e_c_im . '">
                            </div>
                        </div>
                    </div>';
            }
        }
        $output .= '            
                </div>
            </div>
        </div>
        <div class="modal-footer">';
        if (isset($_POST["delete_id"])) {
            $output .= '    
            <form method="POST" action="exam_controller.php">
                <input type="hidden" name="delete" value="' . $e_id . '">
                <input type="hidden" name="ck_id" value="' . $ck_id . '">
                <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
            </form>
            ';
        }
        $output .= '
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        ';
    }
    echo $output;
}
if (isset($_POST["insert"])) {

    $ck_id = $_POST["insert"];
    $es_id = $_POST["es_id"];
    $u_id = $_POST["u_id"];

    $e_qt = mysqli_real_escape_string($con, $_POST["e_qt"]);
    $e_c1 = mysqli_real_escape_string($con, $_POST["e_c1"]);
    $e_c2 = mysqli_real_escape_string($con, $_POST["e_c2"]);
    $e_c3 = mysqli_real_escape_string($con, $_POST["e_c3"]);
    $e_c4 = mysqli_real_escape_string($con, $_POST["e_c4"]);
    $e_aw = mysqli_real_escape_string($con, $_POST["e_aw"]);

    $ext_qt_im = pathinfo(basename($_FILES['e_qt_im']['name']), PATHINFO_EXTENSION);
    $new_image_qt_im = 'img_' . uniqid() . "." . $ext_qt_im;
    $image_path_qt_im = "../images/";
    $upload_path_qt_im = $image_path_qt_im . $new_image_qt_im;

    if ($ext_qt_im == '') {
        $va_qt_im = '';
    } else {
        $va_qt_im = $new_image_qt_im;
    }

    $ext_c1_im = pathinfo(basename($_FILES['e_c1_im']['name']), PATHINFO_EXTENSION);
    $new_image_c1_im = 'img_' . uniqid() . "." . $ext_c1_im;
    $image_path_c1_im = "../images/";
    $upload_path_c1_im = $image_path_c1_im . $new_image_c1_im;

    if ($ext_c1_im == '') {
        $va_c1_im = '';
    } else {
        $va_c1_im = $new_image_c1_im;
    }

    $ext_c2_im = pathinfo(basename($_FILES['e_c2_im']['name']), PATHINFO_EXTENSION);
    $new_image_c2_im = 'img_' . uniqid() . "." . $ext_c2_im;
    $image_path_c2_im = "../images/";
    $upload_path_c2_im = $image_path_c2_im . $new_image_c2_im;

    if ($ext_c2_im == '') {
        $va_c2_im = '';
    } else {
        $va_c2_im = $new_image_c2_im;
    }

    $ext_c3_im = pathinfo(basename($_FILES['e_c3_im']['name']), PATHINFO_EXTENSION);
    $new_image_c3_im = 'img_' . uniqid() . "." . $ext_c3_im;
    $image_path_c3_im = "../images/";
    $upload_path_c3_im = $image_path_c3_im . $new_image_c3_im;

    if ($ext_c3_im == '') {
        $va_c3_im = '';
    } else {
        $va_c3_im = $new_image_c3_im;
    }

    $ext_c4_im = pathinfo(basename($_FILES['e_c4_im']['name']), PATHINFO_EXTENSION);
    $new_image_c4_im = 'img_' . uniqid() . "." . $ext_c4_im;
    $image_path_c4_im = "../images/";
    $upload_path_c4_im = $image_path_c4_im . $new_image_c4_im;

    if ($ext_c4_im == '') {
        $va_c4_im = '';
    } else {
        $va_c4_im = $new_image_c4_im;
    }

    $sql = "INSERT into tb_exam(e_qt,e_qt_im,e_c1,e_c1_im,e_c2,e_c2_im,e_c3,e_c3_im,e_c4,e_c4_im,e_aw,u_id,ck_id)
    values('$e_qt','$va_qt_im','$e_c1','$va_c1_im','$e_c2','$va_c2_im','$e_c3','$va_c3_im','$e_c4','$va_c4_im','$e_aw','$u_id','$ck_id')";

    // echo $sql;
    // exit();

    if ($con->query($sql)) {
        if ($ext_qt_im != '') {
            move_uploaded_file($_FILES['e_qt_im']['tmp_name'], $upload_path_qt_im);
        }
        if ($ext_c1_im != '') {
            move_uploaded_file($_FILES['e_c1_im']['tmp_name'], $upload_path_c1_im);
        }
        if ($ext_c2_im != '') {
            move_uploaded_file($_FILES['e_c2_im']['tmp_name'], $upload_path_c2_im);
        }
        if ($ext_c3_im != '') {
            move_uploaded_file($_FILES['e_c3_im']['tmp_name'], $upload_path_c3_im);
        }
        if ($ext_c4_im != '') {
            move_uploaded_file($_FILES['e_c4_im']['tmp_name'], $upload_path_c4_im);
        }
        if ($es_id != '') {
            $_SESSION['successinsert'] = "สำร็จ";
            header("location:exam_set_choose_exam_insert.php?ck_id=$ck_id&es_id=$es_id");
        } else {
            $_SESSION['successinsert'] = "สำร็จ";
            header("location:exam_manage.php?ck_id=$ck_id");
        }
    }
}
if (isset($_POST["update"])) {

    $e_id = $_POST["update"];
    $ck_id = $_POST["ck_id"];
    $u_id = $_POST["u_id"];

    $e_qt = mysqli_real_escape_string($con, $_POST["e_qt"]);
    $e_c1 = mysqli_real_escape_string($con, $_POST["e_c1"]);
    $e_c2 = mysqli_real_escape_string($con, $_POST["e_c2"]);
    $e_c3 = mysqli_real_escape_string($con, $_POST["e_c3"]);
    $e_c4 = mysqli_real_escape_string($con, $_POST["e_c4"]);
    $e_aw = mysqli_real_escape_string($con, $_POST["e_aw"]);

    if ($_FILES['e_qt_im']['tmp_name'] != '') {
        $ext_qt_im = pathinfo(basename($_FILES['e_qt_im']['name']), PATHINFO_EXTENSION);
        $new_image_qt_im = 'img_' . uniqid() . "." . $ext_qt_im;
        $image_path_qt_im = "../images/";
        $upload_path_qt_im = $image_path_qt_im . $new_image_qt_im;
    }

    if ($ext_qt_im == '') {
        $va_qt_im = '';
    } else {
        $va_qt_im = "e_qt_im = '$new_image_qt_im',";
    }

    if ($_FILES['e_c1_im']['tmp_name'] != '') {
        $ext_c1_im = pathinfo(basename($_FILES['e_c1_im']['name']), PATHINFO_EXTENSION);
        $new_image_c1_im = 'img_' . uniqid() . "." . $ext_c1_im;
        $image_path_c1_im = "../images/";
        $upload_path_c1_im = $image_path_c1_im . $new_image_c1_im;
    }

    if ($ext_c1_im == '') {
        $va_c1_im = '';
    } else {
        $va_c1_im = "e_c1_im = '$new_image_c1_im',";
    }

    if ($_FILES['e_c2_im']['tmp_name'] != '') {
        $ext_c2_im = pathinfo(basename($_FILES['e_c2_im']['name']), PATHINFO_EXTENSION);
        $new_image_c2_im = 'img_' . uniqid() . "." . $ext_c2_im;
        $image_path_c2_im = "../images/";
        $upload_path_c2_im = $image_path_c2_im . $new_image_c2_im;
    }

    if ($ext_c2_im == '') {
        $va_c2_im = '';
    } else {
        $va_c2_im = "e_c2_im = '$new_image_c2_im',";
    }

    if ($_FILES['e_c3_im']['tmp_name'] != '') {
        $ext_c3_im = pathinfo(basename($_FILES['e_c3_im']['name']), PATHINFO_EXTENSION);
        $new_image_c3_im = 'img_' . uniqid() . "." . $ext_c3_im;
        $image_path_c3_im = "../images/";
        $upload_path_c3_im = $image_path_c3_im . $new_image_c3_im;
    }

    if ($ext_c3_im == '') {
        $va_c3_im = '';
    } else {
        $va_c3_im = "e_c3_im = '$new_image_c3_im',";
    }

    if ($_FILES['e_c4_im']['tmp_name'] != '') {
        $ext_c4_im = pathinfo(basename($_FILES['e_c4_im']['name']), PATHINFO_EXTENSION);
        $new_image_c4_im = 'img_' . uniqid() . "." . $ext_c4_im;
        $image_path_c4_im = "../images/";
        $upload_path_c4_im = $image_path_c4_im . $new_image_c4_im;
    }

    if ($ext_c4_im == '') {
        $va_c4_im = '';
    } else {
        $va_c4_im = "e_c4_im = '$new_image_c4_im',";
    }

    $sql = "UPDATE tb_exam set
    e_qt = '$e_qt',
    $va_qt_im
    e_c1 = '$e_c1',
    $va_c1_im
    e_c2 = '$e_c2',
    $va_c2_im
    e_c3 = '$e_c3',
    $va_c3_im
    e_c4 = '$e_c4',
    $va_c4_im
    e_aw = '$e_aw',
    u_id = '$u_id'
    where e_id = '$e_id'";

    if ($con->query($sql)) {
        if ($ext_qt_im != '') {
            move_uploaded_file($_FILES['e_qt_im']['tmp_name'], $upload_path_qt_im);
        }
        if ($ext_c1_im != '') {
            move_uploaded_file($_FILES['e_c1_im']['tmp_name'], $upload_path_c1_im);
        }
        if ($ext_c2_im != '') {
            move_uploaded_file($_FILES['e_c2_im']['tmp_name'], $upload_path_c2_im);
        }
        if ($ext_c3_im != '') {
            move_uploaded_file($_FILES['e_c3_im']['tmp_name'], $upload_path_c3_im);
        }
        if ($ext_c4_im != '') {
            move_uploaded_file($_FILES['e_c4_im']['tmp_name'], $upload_path_c4_im);
        }
        $_SESSION['successupdate'] = "สำร็จ";
        header("location:exam_manage.php?ck_id=$ck_id");
    }
}
if (isset($_POST["delete"])) {
    $e_id = $_POST["delete"];
    $ck_id = $_POST["ck_id"];

    $sql = "DELETE from tb_exam where e_id = '$e_id'";

    if ($con->query($sql)) {
        $_SESSION["successdelete"] = $e_id;
        header("location:exam_manage.php?ck_id=$ck_id");
    }
}
if (isset($_GET["delete_img"])) {
    $ck_id = $_GET["ck_id"];
    $e_id = $_GET["e_id"];
    $e_img = $_GET["e_img"];

    $sql = "UPDATE tb_exam set $e_img = '' where e_id = '$e_id'";
    if ($con->query($sql)) {
        $_SESSION["successupdate"] = $e_id;
        header("location:exam_form_update.php?ck_id=$ck_id&e_id=$e_id");
    }
}
