<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đăng Nhập Giảng Viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg rounded">
          <div class="card-body p-4">
            <h3 class="text-center mb-4">
              <i class="fas fa-user-tie text-primary"></i> Đăng Nhập Giảng Viên
            </h3>
            <form action="xulydangnhap.php" method="post">
              <input type="hidden" name="role" value="teacher" />

              <div class="mb-3">
                <label class="form-label"><i class="fas fa-envelope"></i> Email:</label>
                <input type="text" name="email" class="form-control" placeholder="Nhập email..." required />
              </div>

              <div class="mb-3">
                <label class="form-label"><i class="fas fa-lock"></i> Mật khẩu:</label>
                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required />
              </div>

              <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-sign-in-alt"></i> Đăng Nhập
              </button>
            </form>
          </div>
        </div>
        <p class="text-center mt-3 text-muted">&copy; 2025 - Quản lý thi trực tuyến</p>
      </div>
    </div>
  </div>
</body>
</html>
