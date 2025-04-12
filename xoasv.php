<?php
include 'db.php';
session_start();

if (!isset($_SESSION['teacher_id'])) {
    header("Location: dangnhapgv.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM students WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Xóa sinh viên thành công!'); window.location.href='qlsv.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa!'); window.history.back();</script>";
    }
}
?>
