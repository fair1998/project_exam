<?php
session_start();
ob_start();
$con = mysqli_connect("localhost", "root", "12345678", "project");
mysqli_set_charset($con, "utf8");
// if ($con) {
//     echo "เชื่อมต่อได้";
// }
