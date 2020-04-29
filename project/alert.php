<?php
// session_start();
// ob_start();

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['successinsert'])) {
    // $successinsert = $_SESSION['successinsert'];
    echo '<script type="text/javascript">';
    echo "Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            })";
    echo '</script>';
    unset($_SESSION["successinsert"]);
}

if (isset($_SESSION['successupdate'])) {
    // $successupdate = $_SESSION['successupdate'];
    echo '<script type="text/javascript">';
    echo "Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'แก้ไขข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            })";
    echo '</script>';
    unset($_SESSION["successupdate"]);
}

if (isset($_SESSION['successdelete'])) {
    // $successdelete = $_SESSION['successdelete'];
    echo '<script type="text/javascript">';
    echo "Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'ลบข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            })";
    echo '</script>';
    unset($_SESSION["successdelete"]);
}

if (isset($_SESSION['errorinsert'])) {
    $errorinsert = $_SESSION['errorinsert'];
    $errorname = $_SESSION['errorname'];
    echo '<script type="text/javascript">';
    echo "Swal.fire(
            'ข้อมูลซ้ำ',
            '$errorname $errorinsert มีการลงทะเบียนแล้ว',
            'error'
        )";
    echo '</script>';
    unset($_SESSION["errorinsert"]);
    unset($_SESSION["errorname"]);
}

if (isset($_SESSION['errorupdate'])) {
    $errorupdate = $_SESSION['errorupdate'];
    echo '<script type="text/javascript">';
    echo "Swal.fire({
            icon: 'error',
            title: 'รหัสผ่านปัจจุบันไม่ถูกต้อง'
        })";
    echo '</script>';
    unset($_SESSION["errorupdate"]);
}
