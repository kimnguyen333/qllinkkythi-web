<?php
session_start();
unset($_SESSION['student_id']);
header("Location: trangchu.php");
exit();
?>
