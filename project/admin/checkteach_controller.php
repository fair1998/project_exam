<?php
session_start();
ob_start();
include("../connect.php");

// subject
if (isset($_POST["subject"])) {

    $search = $_POST["search"];
    $select = $_POST["select"];
    if ($select != '') {
        $select = "and sj_class = '$select'";
    } else {
        $select = "";
    }
    $output = '';
    $query = "SELECT * from tb_subject WHERE 
    (sj_name like '%" . $search . "%' or sj_id like '%" . $search . "%')
    $select";
    $result = $con->query($query);
    while ($row = $result->fetch_object()) {
        $output .= '
        <tr>
            <td >' . $row->sj_id . '</td>
            <td >' . $row->sj_name . '</td>
            <td align="right">
                <button type="button" class="btn btn-success btn-sm subject_opt" subjectid="' . $row->sj_id . '" data-dismiss="modal">
                    <i class="zmdi zmdi-check-square"></i>
                </button>
            </td>
        </tr>
            ';
    }
    echo $output;
}
if (isset($_POST['subject_action'])) {
    $id = $_POST['subjectid'];
    $sql = "SELECT * from tb_subject where sj_id = '$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '
        <option value="' . $r->sj_id . '">' . $r->sj_name . '</option>
    ';
    echo $output;
}

// teacher
if (isset($_POST["teacher"])) {

    $search = $_POST["search"];
    $select = $_POST["select"];
    if ($select != '') {
        $select = "and d_id = '$select'";
    } else {
        $select = "";
    }
    $output = '';
    $query = "SELECT * from tb_teacher WHERE 
    (t_name like '%" . $search . "%' or t_id like '%" . $search . "%')
    $select";
    $result = $con->query($query);
    while ($row = $result->fetch_object()) {
        $output .= '
        <tr>
            <td >' . $row->t_id . '</td>
            <td >' . $row->t_name . '</td>
            <td align="right">
                <button type="button" class="btn btn-success btn-sm teacher_opt" teacherid="' . $row->t_id . '" data-dismiss="modal">
                    <i class="zmdi zmdi-check-square"></i>
                </button>
            </td>
        </tr>
            ';
    }
    echo $output;
}
if (isset($_POST['teacher_action'])) {
    $id = $_POST['teacherid'];
    $sql = "SELECT * from tb_teacher where t_id = '$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '
        <option value="' . $r->t_id . '">' . $r->t_name . '</option>
    ';
    echo $output;
}

if (isset($_POST['view'])) {
    $id = $_POST['view'];
    $output = '';
    $query = "SELECT * from tb_checkteach ck
    inner join tb_teacher t on t.t_id = ck.t_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id
    WHERE ck_id = '$id'";
    $result = $con->query($query);
    $row = $result->fetch_object();
    $output .= '<form action="checkteach_controller.php" method="POST">
                    <div class="container-fluid myplr35">
                        <div class="row">
                            <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>อาจารย์</strong></label>
                                    <input type="text" disabled value="' . $row->t_name . '" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                <div class="form-group">
                                    <label for="company" class=" form-control-label"><strong>วิชา</strong></label>
                                    <input type="text" disabled value="' . $row->sj_name . '" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="delete" value="' . $row->ck_id . '">
                        <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST['insert'])) {
    $sj_id = $_POST["sj_id"];
    $t_id = $_POST["t_id"];

    $sql = "INSERT into tb_checkteach(t_id,sj_id)values('$t_id','$sj_id')";

    if ($con->query($sql)) {
        $_SESSION['successinsert'] = "สำร็จ";
        header("location:checkteach_manage.php");
    }
}
if (isset($_POST["delete"])) {
    $id = $_POST["delete"];
    $query = "DELETE from tb_checkteach where ck_id = '$id'";
    if ($con->query($query)) {
        $_SESSION['successdelete'] = $id;
        header("location:checkteach_manage.php");
    } else {
        echo $query;
        exit;
    }
}
if (isset($_POST["form_updata"])) {
    $id = $_POST['ck_id'];
    $sql = "SELECT * from tb_checkteach ck
    inner join tb_teacher t on t.t_id = ck.t_id
    inner join tb_subject sj on sj.sj_id = ck.sj_id
    where ck_id ='$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '
    <div class="row form-group">
        <div class="col-2">
            <label class=" form-control-label">วิชา</label>
        </div>
        <div class="col-lg-8">
            <select name="sj_id" id="sj_id" class="form-control" required>
                <option value="' . $r->sj_id . '"> ' . $r->sj_name . '</option>
            </select>
        </div>
        <div class="col-2">
            <button type="button" class="btn btn-outline-success subject_view" data-toggle="modal" data-target="#subject_view">
                <i class="zmdi zmdi-upload"></i>&nbsp; Upload</button>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-2">
            <label class=" form-control-label">อาจารย์</label>
        </div>
        <div class="col-lg-8">
            <select name="t_id" id="t_id" class="form-control" required>
                <option value="'. $r->t_id .'">'. $r->t_name.'</option>
            </select>
        </div>
        <div class="col-2">
            <button type="button" class="btn btn-outline-success teacher_view" data-toggle="modal" data-target="#teacher_view">
                <i class="zmdi zmdi-upload"></i>&nbsp; Upload</button>
        </div>
    </div>
    ';
    echo $output;
}
if(isset($_POST["update"])){
    
    $ck_id = $_POST["update"];
    $sj_id = $_POST["sj_id"];
    $t_id = $_POST["t_id"];

    $sql = "UPDATE tb_checkteach set
    sj_id = '$sj_id',
    t_id = $t_id
    where ck_id = '$ck_id'";

    if ($con->query($sql)) {
        $_SESSION['successupdate'] = "สำร็จ";
        header("location:checkteach_manage.php");
    }
}