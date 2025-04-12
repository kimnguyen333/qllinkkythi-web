<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: dangnhapgv.php");
    exit();
}

// Kết nối CSDL
require 'db.php'; // Đảm bảo file này có kết nối CSDL

// Xử lý thêm kỳ thi mới
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $exam_link = $_POST['exam_link'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $created_by = $_SESSION['teacher_id'];

    // Xử lý tải ảnh
    $imagePath = "default.png"; 
    if (!empty($_FILES['exam_image']['name'])) {
        $targetDir = "uploads/";
        $fileName = time() . "_" . basename($_FILES['exam_image']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['exam_image']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath;
        }
    }

    // Chèn dữ liệu vào CSDL
    $stmt = $conn->prepare("INSERT INTO examstest (title, description, exam_link, image_path, start_time, end_time, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $title, $description, $exam_link, $imagePath, $start_time, $end_time, $created_by);
    $stmt->execute();
    $stmt->close();

    // Sau khi thêm thành công
    echo "<script>
        alert('Thêm kỳ thi mới thành công!');
        window.location.href = window.location.href;
    </script>";
    exit();
}

// Xóa kỳ thi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Lấy đường dẫn ảnh
    $stmt = $conn->prepare("SELECT image_path FROM examstest WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();
    

    // Xóa ảnh nếu không phải ảnh mặc định
    if ($imagePath !== "default.png" && file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Xóa kỳ thi khỏi CSDL
    $stmt = $conn->prepare("DELETE FROM examstest WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: qlkythi.php");
    exit();
}

// Lấy danh sách kỳ thi từ CSDL
$result = $conn->query("SELECT * FROM examstest");

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Kỳ Thi</title>
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
    <h2 class="text-center">Quản Lý Kỳ Thi</h2><br>

 <!-- Form thêm kỳ thi -->
        <div class="card-header bg-primary text-white text-center fw-bold">
            Thêm Kỳ Thi
        </div>
            <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <label for="title" class="form-label">🎓 Tiêu đề kỳ thi:</label>
                        <input type="text" name="title" id="title" class="form-control mb-2" placeholder="Nhập tiêu đề kỳ thi" required>
                    </div>
                    <div class="col-md-4">
                        <label for="exam_link" class="form-label">🔗 Link bài thi (Google Forms):</label>
                        <input type="url" name="exam_link" id="exam_link" class="form-control mb-2" placeholder="Dán link bài thi vào đây" required>
                    </div>
                    <div class="col-md-4">
                        <label for="exam_image" class="form-label">🖼️ Ảnh đại diện kỳ thi:</label>
                        <input type="file" name="exam_image" id="exam_image" class="form-control mb-2" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">📝 Mô tả kỳ thi:</label>
                        <textarea name="description" id="description" class="form-control mb-2" placeholder="Viết mô tả ngắn gọn về kỳ thi"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label for="start_time" class="form-label">📅 Thời gian bắt đầu:</label>
                        <input type="datetime-local" name="start_time" id="start_time" class="form-control mb-2" required>
                    </div>
                    <div class="col-md-3">
                        <label for="end_time" class="form-label">📅 Thời gian kết thúc:</label>
                        <input type="datetime-local" name="end_time" id="end_time" class="form-control mb-2" required>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-md-3 text-center">
                        <button type="submit" class="btn btn-success w-100">➕ Thêm Kỳ Thi</button>
                    </div>
                </div>
            </form>

    <!-- Danh sách kỳ thi -->

    <table class="table table-bordered table-hover text-nowrap mt-4">
        <thead class="table-dark text-center">
            <tr>
                <th>Ảnh</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Link</th>
                <th>Bắt đầu</th>
                <th>Kết thúc</th>
                <th>Trạng thái</th>
                <th>Chức Năng</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($exam = $result->fetch_assoc()) : ?>
                <?php
                    $now = new DateTime();
                    $start = new DateTime($exam['start_time']);
                    $end = new DateTime($exam['end_time']);
                    $status = ($now < $start) ? '<span class="badge bg-secondary">Chưa bắt đầu</span>'
                            : (($now >= $start && $now <= $end) ? '<span class="badge bg-success">Đang diễn ra</span>'
                            : '<span class="badge bg-danger">Kết thúc</span>');
                ?>
                <tr class="text-center align-middle">
                    <td><img src="<?= htmlspecialchars($exam['image_path']) ?>" width="80"></td>
                    <td><?= htmlspecialchars($exam['title']) ?></td>
                    <td><?= htmlspecialchars(mb_strimwidth($exam['description'], 0, 50, "...")) ?></td>
                    <td>
                        <a href="<?= htmlspecialchars($exam['exam_link']) ?>" target="_blank">
                            🔗 Link
                        </a>
                    </td>
                    <td><?= $start->format('d-m-Y H:i') ?></td>
                    <td><?= $end->format('d-m-Y H:i') ?></td>
                    <td><?= $status ?></td>
                    <td>
                        <a href="suakythi.php?id=<?= $exam['id'] ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
                        <a href="?delete=<?= $exam['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa kỳ thi này không?');">🗑️ Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>
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
