<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: dangnhapsv.php");
    exit();
}

include 'db.php';

// Lấy thông tin user
$user_id = $_SESSION['student_id'];
$role = 'student'; // Hoặc lấy từ session nếu có phân quyền phức tạp hơn
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi Mật Khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow rounded-4">
                <div class="card-body">
                    <h3 class="text-center text-primary mb-4">🧑‍🏫 Đổi Mật Khẩu</h3>
                    <p class="text-center text-muted">Vui lòng nhập mật khẩu cũ và mới của bạn.</p>
                    <form action="doimatkhau.php" method="post">
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <input type="hidden" name="role" value="<?= $role ?>">

                        <div class="mb-3">
                            <label class="form-label">🔐 Mật khẩu cũ</label>
                            <div class="input-group">
                                <span class="input-group-text">🔑</span>
                                <input type="password" name="old_password" class="form-control" placeholder="Nhập mật khẩu cũ" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">🆕 Mật khẩu mới</label>
                            <div class="input-group">
                                <span class="input-group-text">🔒</span>
                                <input type="password" name="new_password" class="form-control" placeholder="Nhập mật khẩu mới" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold">✅ Đổi Mật Khẩu</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="trangchusinhvien.php" class="btn btn-link">← Quay lại trang chính</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
