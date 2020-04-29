<?php
session_start();
ob_start();

if ($_SESSION['id'] == '') {
    echo "เกิดข้อผิดพลาด";
    exit;
}
