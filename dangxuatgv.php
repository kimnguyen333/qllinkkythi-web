<?php
session_start();
unset($_SESSION['teacher_id']);
header("Location: dangnhapgv.php");
exit();
?>
