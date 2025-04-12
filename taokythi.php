<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "teacher") {
    header("Location: dangnhapgv.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Kỳ Thi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Tạo Kỳ Thi Mới</h2>
    <form action="xulytaokythi.php" method="post">
        <div class="mb-3">
            <label>Tiêu đề kỳ thi:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mô tả:</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Thời gian bắt đầu:</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Thời gian kết thúc:</label>
            <input type="datetime-local" name="end_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Tạo Kỳ Thi</button>
    </form>
    <a href="trangchugiaovien.php" class="btn btn-secondary mt-3">Quay lại</a>
</div>
</body>
</html>
