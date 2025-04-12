<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Đăng Nhập Sinh Viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

  <div class="card shadow p-4" style="min-width: 350px;">
    <h3 class="text-center text-primary mb-4">Đăng Nhập Sinh Viên</h3>

    <form action="xulydangnhap.php" method="post">
      <input type="hidden" name="role" value="student">

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
          <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100 mt-2">Đăng Nhập</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
