<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "teacher") {
    header("Location: dangnhapgv.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM exams WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Xóa kỳ thi thành công!'); window.location.href='qlkythi.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa!'); window.history.back();</script>";
    }
}
?>
