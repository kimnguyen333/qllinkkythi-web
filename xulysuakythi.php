<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "teacher") {
    header("Location: dangnhapgv.php");
    exit();
}

if ($_POST) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "UPDATE exams SET title='$title', description='$description', start_time='$start_time', end_time='$end_time' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Cập nhật kỳ thi thành công!'); window.location.href='qlkythi.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật!'); window.history.back();</script>";
    }
}
?>
