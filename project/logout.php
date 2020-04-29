<?php
session_start();
ob_start();

if (isset($_GET['a'])) {
    session_destroy();
    header("location:index.php");
}

if (isset($_GET['t'])) {
    session_destroy();
    header("location:index.php");
}

if (isset($_GET['s'])) {
    session_destroy();
    header("location:index.php");
}
