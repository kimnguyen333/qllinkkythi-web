<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "teacher") {
    header("Location: dangnhapgv.php");
    exit();
}

if ($_POST) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $created_by = $_SESSION['user_id']; // Lấy ID giảng viên

    $sql = "INSERT INTO exams (title, description, start_time, end_time, created_by) 
            VALUES ('$title', '$description', '$start_time', '$end_time', '$created_by')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Tạo kỳ thi thành công!'); window.location.href='qlkythi.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi tạo kỳ thi!'); window.history.back();</script>";
    }
}
?>
