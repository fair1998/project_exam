<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST["view"])) {
    $e_id = $_POST['view'];
    $es_id = $_POST['es_id'];
    $sum = $_POST["sum"];

    $output = '';
    $query = "SELECT * from tb_exam WHERE e_id = '$e_id'";
    $result = $con->query($query);

    $output .= '
        <div class="modal-header" align="center">
            <h4 class="modal-title">อัตราการตอบ</h4>
        </div>
        <div class="modal-body">
            <div class="container-fluid myplr35">
                <div class="row">';
    $row = $result->fetch_object();
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
                                <div class="col" style="padding-left: 4px;">';
        $sqle_c = "SELECT COUNT(*) AS a_e_c FROM tb_exam_answer ea
        INNER JOIN tb_choose_student cs ON cs.cs_id = ea.cs_id
        where ea.e_id = '$e_id' and cs.es_id = '$es_id' and ea_aw = '$i' ";
        $rse_c = $con->query($sqle_c);
        $re_c = $rse_c->fetch_object();
        $correct_answer = $re_c->a_e_c;
        if ($sum != 0) {
            $aw = ($correct_answer / $sum) * 100;
        } else {
            $aw = 0;
        }
        $output .= '                <label class=" form-control-label">' . number_format($aw) . '%</label><br>
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
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        ';
    echo $output;
}
