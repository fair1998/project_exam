<?php
session_start();
ob_start();
include("../connect.php");

if (isset($_POST["term"])) {
    $sql = $_POST["term_sql"];
    $output = '';
    if (isset($sql)) {
        $search = mysqli_real_escape_string($con, $sql);
        $query = "SELECT * from tb_term WHERE tm_name like '%" . $search . "%'";
    } else {
        $query = "SELECT * from tb_term  ";
    }
    $result = $con->query($query);
    while ($row = $result->fetch_object()) {
        $output .= '
            <div class="au-task__item au-task__item--primary">
                <div class="au-task__item-inner">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 80%">
                                 ' . $row->tm_name . '
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-success btn-sm term_view" term_form_update="' . $row->tm_id . '" data-toggle="modal" data-target="#term_view">
                                    <i class="fas fa-fw fa-edit"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm term_view" term_form_delete="' . $row->tm_id . '" data-toggle="modal" data-target="#term_view">
                                    <i class="fas fa-fw fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            ';
    }
    echo $output;
}
if (isset($_POST["term_form_insert"])) {
    $output = '';
    $output .= '
        <div class="modal-header" align="center">
            <h4 class="modal-title">ภาคเรียน/ปีการศึกษา</h4>
        </div>
        <form action="system_controller.php" method="POST">
            <div class="modal-body">
                <div class="container-fluid myplr35">
                    <div class="row">
                        <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                            <div class="form-group">
                                <label for="company" class=" form-control-label"><strong>เพิ่ม ภาคเรียน</strong></label>
                                <input type="text" name="tm_name" maxlength="6" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="modal-footer">
            <input type="hidden" name="term_insert" value="term_insert">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    ';
    echo $output;
}
if (isset($_POST["term_insert"])) {

    $name = $_POST["tm_name"];

    $sqlchecK = "SELECT * FROM tb_term WHERE  tm_name = '$name' ";
    $rschecK = $con->query($sqlchecK);
    $rchecK = mysqli_num_rows($rschecK);
    if ($rchecK == 0) {
        $sql = "INSERT into tb_term(tm_name)
        values('$name')";
        $con->query($sql);
        $_SESSION['successinsert'] = $name;
        header("location:system_manage.php");
    } else {
        $_SESSION['errorinsert'] = "";
        $_SESSION['errorname'] = "ภาคเรียน $name";
        header("location:system_manage.php");
    }
}
if (isset($_POST["term_form_update"])) {
    $id = $_POST["term_form_update"];
    $sql = "SELECT * from tb_term where tm_id = '$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">ภาคเรียน/ปีการศึกษา</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>แก้ไข ภาคเรียน</strong></label>
                                        <input type="text" name="tm_name" value="' . $r->tm_name . '" maxlength="6" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="term_update" value="' . $r->tm_id . '">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["term_update"])) {
    $id = $_POST["term_update"];
    $name = $_POST["tm_name"];

    $sqlchecK = "SELECT * FROM tb_term WHERE  tm_name = '$name' ";
    $rschecK = $con->query($sqlchecK);
    $rchecK = mysqli_num_rows($rschecK);
    if ($rchecK == 0) {
        $sql = "update tb_term set 
        tm_name = '$name'
        where y_id = '$id'";
        $con->query($sql);
        $_SESSION['successupdate'] = $name;
        header("location:system_manage.php");
    } else {

        $_SESSION['errorinsert'] = "";
        $_SESSION['errorname'] = "ภาคเรียน $name";
        header("location:system_manage.php");
    }
}
if (isset($_POST["term_form_delete"])) {
    $id = $_POST["term_form_delete"];
    $sql = "SELECT * from tb_term where tm_id = '$id' ";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">ภาคเรียน/ปีการศึกษา</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>ลบ ภาคเรียน/ปีการศึกษา</strong></label>
                                        <input type="text" disabled value="' . $r->tm_name . '" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="term_delete" value="' . $r->tm_id . '">
                        <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["term_delete"])) {

    $id = $_POST["term_delete"];
    $sql = "DELETE from tb_term where tm_id = '$id'";
    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $id;
        header("location:system_manage.php");
    } else {
        echo $sql;
        exit;
    }
}

if (isset($_POST["year"])) {
    $sql = $_POST["year_sql"];
    $output = '';
    if (isset($sql)) {
        $search = mysqli_real_escape_string($con, $sql);
        $query = "SELECT * from tb_year WHERE y_name like '%" . $search . "%'";
    } else {
        $query = "SELECT * from tb_year";
    }
    $result = $con->query($query);
    while ($row = $result->fetch_object()) {
        $output .= '
            <div class="au-task__item au-task__item--primary">
                <div class="au-task__item-inner">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 80%">
                                ' . $row->y_name . '
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-success btn-sm year_view" year_form_update="' . $row->y_id . '" data-toggle="modal" data-target="#year_view">
                                    <i class="fas fa-fw fa-edit"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm year_view" year_form_delete="' . $row->y_id . '" data-toggle="modal" data-target="#year_view">
                                    <i class="fas fa-fw fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            ';
    }
    echo $output;
}
if (isset($_POST["year_form_insert"])) {
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">ปีการศึกษา</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>เพิ่ม ปีการศึกษา</strong></label>
                                        <input type="text" name="y_name" pattern="[0-9]{1,}" title="กรอกตัวเลขเท่านั้น" maxlength="4" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="year_insert" value="year_insert">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["year_insert"])) {

    $name = $_POST["y_name"];
    $sqlchecK = "SELECT * FROM tb_year WHERE  y_name = '$name' ";
    $rschecK = $con->query($sqlchecK);
    $rchecK = mysqli_num_rows($rschecK);
    if ($rchecK == 0) {
        $sql = "INSERT into tb_year(y_name)
        values('$name')";
        $con->query($sql);
        $_SESSION['successinsert'] = $name;
        header("location:system_manage.php");
    } else {
        $_SESSION['errorinsert'] = $name;
        $_SESSION['errorname'] = "ปีการศึกษา";
        header("location:system_manage.php");
    }
}
if (isset($_POST["year_form_update"])) {
    $id = $_POST["year_form_update"];
    $sql = "SELECT * from tb_year where y_id = '$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">ปีการศึกษา</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>แก้ไข ปีการศึกษา</strong></label>
                                        <input type="text" name="y_name" value="' . $r->y_name . '" pattern="[0-9]{1,}" title="กรอกตัวเลขเท่านั้น" maxlength="4" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="year_update" value="' . $r->y_id . '">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["year_update"])) {
    $id = $_POST["year_update"];
    $name = $_POST["y_name"];
    $sqlchecK = "SELECT * FROM tb_year WHERE  y_name = '$name' ";
    $rschecK = $con->query($sqlchecK);
    $rchecK = mysqli_num_rows($rschecK);
    if ($rchecK == 0) {
        $sql = "update tb_year set y_name = '$name' where y_id = '$id'";
        $con->query($sql);
        $_SESSION['successupdate'] = $name;
        header("location:system_manage.php");
    } else {
        $_SESSION['errorinsert'] = $name;
        $_SESSION['errorname'] = "ปีการศึกษา";
        header("location:system_manage.php");
    }
}
if (isset($_POST["year_form_delete"])) {
    $id = $_POST["year_form_delete"];
    $sql = "SELECT * from tb_year where y_id = '$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">ปีการศึกษา</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>ลบ ปีการศึกษา</strong></label>
                                        <input type="text" disabled value="' . $r->y_name . '" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="year_delete" value="' . $r->y_id . '">
                        <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["year_delete"])) {

    $id = $_POST["year_delete"];
    $sql = "DELETE from tb_year where y_id = '$id'";
    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $id;
        header("location:system_manage.php");
    } else {
        echo $sql;
        exit;
    }
}


if (isset($_POST["department"])) {
    $sql = $_POST["department_sql"];
    $outputd = '';
    if (isset($sql)) {
        $search = mysqli_real_escape_string($con, $sql);
        $query = "SELECT * from tb_department WHERE d_name like '%" . $search . "%'";
    } else {
        $query = "SELECT * from tb_department";
    }
    $result = $con->query($query);
    while ($row = $result->fetch_object()) {
        $outputd .= '
            <div class="au-task__item au-task__item--primary">
                <div class="au-task__item-inner">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 80%">
                                ' . $row->d_name . '
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-success btn-sm department_view" department_form_update="' . $row->d_id . '" data-toggle="modal" data-target="#department_view">
                                    <i class="fas fa-fw fa-edit"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm department_view" department_form_delete="' . $row->d_id . '" data-toggle="modal" data-target="#department_view">
                                    <i class="fas fa-fw fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            ';
    }
    echo $outputd;
}
if (isset($_POST["department_form_insert"])) {
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">แผนกวิชา</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>เพิ่ม แผนกวิชา</strong></label>
                                        <input type="text" name="d_name" maxlength="40" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="department_insert" value="department_insert">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["department_insert"])) {

    $name = $_POST["d_name"];

    $sqlchecK = "SELECT * FROM tb_department WHERE  d_name = '$name' ";
    $rschecK = $con->query($sqlchecK);
    $rchecK = mysqli_num_rows($rschecK);
    if ($rchecK == 0) {
        $sql = "INSERT into tb_department(d_name)
        values('$name')";
        $con->query($sql);
        $_SESSION['successinsert'] = $name;
        header("location:system_manage.php");
    } else {
        $_SESSION['errorinsert'] = $name;
        $_SESSION['errorname'] = "แผนกวิชา";
        header("location:system_manage.php");
    }
}
if (isset($_POST["department_form_update"])) {
    $id = $_POST["department_form_update"];
    $sql = "SELECT * from tb_department where d_id = '$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">แผนกวิชา</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>แก้ไข แผนกวิชา</strong></label>
                                        <input type="text" name="d_name" value="' . $r->d_name . '" maxlength="40" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="department_update" value="' . $r->d_id . '">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["department_update"])) {
    $id = $_POST["department_update"];
    $name = $_POST["d_name"];
    $sqlchecK = "SELECT * FROM tb_department WHERE  d_name = '$name' ";
    $rschecK = $con->query($sqlchecK);
    $rchecK = mysqli_num_rows($rschecK);
    if ($rchecK == 0) {
        $sql = "UPDATE tb_department set d_name = '$name' where d_id = '$id'";
        $con->query($sql);
        $_SESSION['successupdate'] = $name;
        header("location:system_manage.php");
    } else {
        $_SESSION['errorinsert'] = $name;
        $_SESSION['errorname'] = "แผนกวิชา";
        header("location:system_manage.php");
    }
}
if (isset($_POST["department_form_delete"])) {
    $id = $_POST["department_form_delete"];
    $sql = "SELECT * from tb_department where d_id = '$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">แผนกวิชา</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>ลบ แผนกวิชา</strong></label>
                                        <input type="text" disabled value="' . $r->d_name . '" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="department_delete" value="' . $r->d_id . '">
                        <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["department_delete"])) {

    $id = $_POST["department_delete"];
    $sql = "DELETE from tb_department where d_id = '$id'";
    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $id;
        header("location:system_manage.php");
    } else {
        echo $sql;
        exit;
    }
}


if (isset($_POST["myclass"])) {
    $sql = $_POST["myclass_sql"];
    $outputd = '';
    if (isset($sql)) {
        $search = mysqli_real_escape_string($con, $sql);
        $query = "SELECT * from tb_class WHERE c_name like '%" . $search . "%'";
    } else {
        $query = "SELECT * from tb_class";
    }
    $result = $con->query($query);
    while ($row = $result->fetch_object()) {
        $outputd .= '
            <div class="au-task__item au-task__item--primary">
                <div class="au-task__item-inner">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 80%">
                                ' . $row->c_name . '
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-success btn-sm myclass_view" myclass_form_update="' . $row->c_id . '" data-toggle="modal" data-target="#myclass_view">
                                    <i class="fas fa-fw fa-edit"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm myclass_view" myclass_form_delete="' . $row->c_id . '" data-toggle="modal" data-target="#myclass_view">
                                    <i class="fas fa-fw fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            ';
    }
    echo $outputd;
}
if (isset($_POST["myclass_form_insert"])) {
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">ระดับชั้น</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>เพิ่ม ระดับชั้น</strong></label>
                                        <input type="text" name="c_name" maxlength="10" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="myclass_insert" value="myclass_insert">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["myclass_insert"])) {

    $name = $_POST["c_name"];

    $sqlchecK = "SELECT * FROM tb_class WHERE  c_name = '$name' ";
    $rschecK = $con->query($sqlchecK);
    $rchecK = mysqli_num_rows($rschecK);
    if ($rchecK == 0) {
        $sql = "INSERT into tb_class(c_name)
        values('$name')";
        $con->query($sql);
        $_SESSION['successinsert'] = $name;
        header("location:system_manage.php");
    } else {
        $_SESSION['errorinsert'] = $name;
        $_SESSION['errorname'] = "ระดับชั้น";
        header("location:system_manage.php");
    }
}
if (isset($_POST["myclass_form_update"])) {
    $id = $_POST["myclass_form_update"];
    $sql = "SELECT * from tb_class where c_id = '$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">ระดับชั้น</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>แก้ไข ระดับชั้น</strong></label>
                                        <input type="text" name="c_name" value="' . $r->c_name . '" maxlength="10" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="myclass_update" value="' . $r->c_id . '">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["myclass_update"])) {
    $id = $_POST["myclass_update"];
    $name = $_POST["c_name"];
    $sqlchecK = "SELECT * FROM tb_class WHERE  c_name = '$name' ";
    $rschecK = $con->query($sqlchecK);
    $rchecK = mysqli_num_rows($rschecK);
    if ($rchecK == 0) {
        $sql = "UPDATE tb_class set c_name = '$name' where c_id = '$id'";
        $con->query($sql);
        $_SESSION['successupdate'] = $name;
        header("location:system_manage.php");
    } else {
        $_SESSION['errorinsert'] = $name;
        $_SESSION['errorname'] = "ระดับชั้น";
        header("location:system_manage.php");
    }
}
if (isset($_POST["myclass_form_delete"])) {
    $id = $_POST["myclass_form_delete"];
    $sql = "SELECT * from tb_class where c_id = '$id'";
    $rs = $con->query($sql);
    $r = $rs->fetch_object();
    $output = '';
    $output .= '<div class="modal-header" align="center">
                    <h4 class="modal-title">ระดับชั้น</h4>
                </div>
                <form action="system_controller.php" method="POST">
                    <div class="modal-body">
                        <div class="container-fluid myplr35">
                            <div class="row">
                                <div class="col-lg-12 offset-md-3 mr-auto ml-auto">
                                    <div class="form-group">
                                        <label for="company" class=" form-control-label"><strong>ลบ ระดับชั้น</strong></label>
                                        <input type="text" disabled value="' . $r->c_name . '" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="myclass_delete" value="' . $r->c_id . '">
                        <button type="submit" class="btn btn-danger" onclick="del()">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>';
    echo $output;
}
if (isset($_POST["myclass_delete"])) {

    $id = $_POST["myclass_delete"];
    $sql = "DELETE from tb_class where c_id = '$id'";
    if ($con->query($sql)) {
        $_SESSION['successdelete'] = $id;
        header("location:system_manage.php");
    } else {
        echo $sql;
        exit;
    }
}
