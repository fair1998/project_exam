<?php
session_start();
ob_start();

if ($_SESSION['id'] == '') {
    header("location:../login_t.php");
}
