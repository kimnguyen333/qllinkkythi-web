<?php
include 'db.php';
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: dangnhapsv.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sinh Viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
</head>
<body>
<div class="container mt-5">
        <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="trangchugiaovien.php" class="logo">
              <img
                src="assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
          </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
               
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../demo1/index.html">
                       
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-layer-group"></i>
                  <p>Chức Năng</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="qlkythi.php">
                        <span class="sub-item">Quản Lý Kỳ Thi</span>
                      </a>
                    </li>
                    <li>
                      <a href="qlsv.php">
                        <span class="sub-item">Quản Lý Sinh Viên</span>
                      </a>
                    </li>
                    <li>
                    </li>
                  </ul>
                </div>
              </li>
              
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#charts">
                  <i class="far fa-chart-bar"></i>
                  <p>Thống kê</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="charts">
                  <ul class="nav nav-collapse">
                  <li>
                      <a href="thongke.php">
                        <span class="sub-item">Thống Kê Kết Quả</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
    
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#maps">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Maps</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="maps">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="#">
                        <span class="sub-item">Google Maps</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </div>
      <div class="col-10 col-md-13 offset-md-2">
      <div class="container mt-5">
    <h2 class="text-center mb-4">Quản Lý Sinh Viên</h2>

            <!-- BẢNG 1: Thêm Sinh Viên -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white text-center fw-bold">
                    Thêm Sinh Viên
                </div>
                <div class="card-body">
                    <form action="xulithemsv.php" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="name" class="form-label">👤 Họ tên:</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nhập họ tên" required>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">📧 Email:</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email" required>
                            </div>
                            <div class="col-md-4">
                                <label for="password" class="form-label">🔒 Mật khẩu:</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
                            </div>
                            <div class="col-md-4">
                                <label for="khoa_id" class="form-label">🏫 Khoa:</label>
                                <select name="khoa_id" id="khoa_id" class="form-select" required>
                                    <option value="">-- Chọn Khoa --</option>
                                    <?php
                                    $sql_khoa = "SELECT * FROM khoa";
                                    $result_khoa = mysqli_query($conn, $sql_khoa);
                                    while ($row_khoa = mysqli_fetch_assoc($result_khoa)) {
                                        echo "<option value='{$row_khoa['id']}'>{$row_khoa['ten_khoa']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="lop_id" class="form-label">👥 Lớp:</label>
                                <select name="lop_id" id="lop_id" class="form-select" required>
                                    <option value="">-- Chọn Lớp --</option>
                                    <?php
                                    $sql_lop = "SELECT * FROM lop";
                                    $result_lop = mysqli_query($conn, $sql_lop);
                                    while ($row_lop = mysqli_fetch_assoc($result_lop)) {
                                        echo "<option value='{$row_lop['id']}'>{$row_lop['ten_lop']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="student_file" class="form-label">📁 Nhập từ file Excel:</label>
                                <input type="file" name="student_file" id="student_file" class="form-control" accept=".xlsx, .xls">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success px-5">➕ Thêm Sinh Viên</button>
                        </div>
                    </form>
                </div>
            </div>

    <!-- BẢNG 2: Danh Sách Sinh Viên -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white text-center fw-bold">
            Danh Sách Sinh Viên
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Mật khẩu</th>
                        <th>Khoa</th>
                        <th>Lớp</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT s.*, k.ten_khoa, l.ten_lop FROM students s
                            JOIN khoa k ON s.khoa_id = k.id
                            JOIN lop l ON s.lop_id = l.id
                            ORDER BY s.name ASC";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class='align-middle'>
                                <td class='text-start'>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['password']}</td>
                                <td>{$row['ten_khoa']}</td>
                                <td>{$row['ten_lop']}</td>
                                <td>
                                    <a href='xoasv.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc muốn xóa không?\");'>Xóa</a>
                                </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.querySelector("input[name='student_file']");
        const nameInput = document.querySelector("input[name='name']");
        const emailInput = document.querySelector("input[name='email']");
        const passwordInput = document.querySelector("input[name='password']");

        fileInput.addEventListener("change", function () {
            if (this.files.length > 0) {
                nameInput.removeAttribute("required");
                emailInput.removeAttribute("required");
                passwordInput.removeAttribute("required");
            } else {
                nameInput.setAttribute("required", "required");
                emailInput.setAttribute("required", "required");
                passwordInput.setAttribute("required", "required");
            }
        });
    });
</script>
   <!--   Core JS Files   -->
   <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
</body>
</html>