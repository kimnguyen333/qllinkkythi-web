<?php
include 'db.php';

$exams = $conn->query("SELECT id, title FROM examstest");
$departments = $conn->query("SELECT id, ten_khoa FROM khoa");
$classes = $conn->query("SELECT id, ten_lop FROM lop");

$exam_id = $_POST['exam_id'] ?? '';
$department_id = $_POST['department_id'] ?? '';
$class_id = $_POST['class_id'] ?? '';
$student_name = $_POST['student_name'] ?? '';

if (isset($_POST['export_csv'])) {
    $sql_csv = "SELECT ea.id, s.name AS student_name, e.title AS exam_title, 
                       k.ten_khoa AS department_name, l.ten_lop AS class_name, 
                       ea.start_time, i.image_path
                FROM exam_attempts ea 
                JOIN students s ON ea.student_id = s.id 
                JOIN examstest e ON ea.exam_id = e.id
                JOIN lop l ON s.lop_id = l.id
                JOIN khoa k ON s.khoa_id = k.id
                LEFT JOIN images i ON ea.image_id = i.id
                ORDER BY ea.start_time DESC";
    $result = $conn->query($sql_csv);

    if ($result->num_rows > 0) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=thongke.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Tên SV', 'Bài thi', 'Khoa', 'Lớp', 'Thời gian bắt đầu', 'Ảnh', 'Trạng thái']);
        while ($row = $result->fetch_assoc()) {
            $status = empty($row['start_time']) || empty($row['image_path']) ? 'Chưa hoàn thiện' : 'Hoàn thành';
            fputcsv($output, [
                $row['id'],
                $row['student_name'],
                $row['exam_title'],
                $row['department_name'],
                $row['class_name'],
                $row['start_time'],
                $row['image_path'],
                $status
            ]);
        }
        fclose($output);
        exit();
    }
}

$sql = "SELECT ea.id, s.name AS student_name, e.title AS exam_title, 
               k.ten_khoa AS department_name, l.ten_lop AS class_name, 
               ea.start_time, i.image_path
        FROM exam_attempts ea 
        JOIN students s ON ea.student_id = s.id 
        JOIN examstest e ON ea.exam_id = e.id
        JOIN lop l ON s.lop_id = l.id
        JOIN khoa k ON s.khoa_id = k.id
        LEFT JOIN images i ON ea.image_id = i.id
        WHERE (e.id = ? OR ? = '') AND (k.id = ? OR ? = '') 
              AND (l.id = ? OR ? = '') AND (s.name LIKE ? OR ? = '')
        ORDER BY ea.start_time DESC";

$stmt = $conn->prepare($sql);
$searchName = "%$student_name%";
$stmt->bind_param("iiisssss", $exam_id, $exam_id, $department_id, $department_id, $class_id, $class_id, $searchName, $student_name);
$stmt->execute();
$result = $stmt->get_result();

$department_id = $_POST['department_id'] ?? '';
$exam_id = $_POST['exam_id'] ?? '';
$class_id = $_POST['class_id'] ?? '';
$student_name = $_POST['student_name'] ?? '';

// Truy vấn danh sách khoa
$departments = $conn->query("SELECT * FROM khoa");

// Truy vấn danh sách bài thi
$exams = $conn->query("SELECT * FROM examstest");

// Truy vấn danh sách lớp có theo khoa nếu được chọn
if (!empty($department_id)) {
    $classes = $conn->query("SELECT * FROM lop WHERE khoa_id = '$department_id'");
} else {
    $classes = $conn->query("SELECT * FROM lop");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống Kê Kết Quả</title>
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

    <!-- CSS files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/demo.css" />
</head>
<body class="container py-5">
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
      <h1 class="mb-4 text-center">Thống Kê Kết Quả Thi</h1>

                    <!-- MỤC 1: BỘ LỌC THÔNG TIN -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <strong>Bộ lọc thông tin</strong>
                        </div>
                        <div class="card-body">
                            <form method="POST" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Bài Thi</label>
                                    <select class="form-select" name="exam_id" onchange="this.form.submit()">
                                        <option value="">Chọn Bài Thi</option>
                                        <?php while ($row = $exams->fetch_assoc()): ?>
                                            <option value="<?= $row['id'] ?>" <?= ($row['id'] == $exam_id ? 'selected' : '') ?>><?= $row['title'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Khoa</label>
                                    <select class="form-select" name="department_id" onchange="this.form.submit()">
                                        <option value="">Chọn Khoa</option>
                                        <?php while ($row = $departments->fetch_assoc()): ?>
                                            <option value="<?= $row['id'] ?>" <?= ($row['id'] == $department_id ? 'selected' : '') ?>><?= $row['ten_khoa'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Lớp</label>
                                    <select class="form-select" name="class_id" onchange="this.form.submit()">
                                      <option value="">Chọn Lớp</option>
                                      <?php while ($row = $classes->fetch_assoc()): ?>
                                          <option value="<?= $row['id'] ?>" <?= ($row['id'] == $class_id ? 'selected' : '') ?>>
                                              <?= $row['ten_lop'] ?>
                                          </option>
                                      <?php endwhile; ?>
                                  </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Tên Sinh Viên</label>
                                    <input type="text" name="student_name" class="form-control" placeholder="Tìm tên sinh viên..." value="<?= htmlspecialchars($student_name) ?>">
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- MỤC 2: DANH SÁCH KẾT QUẢ -->
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <strong>Danh sách kết quả</strong>
                        </div>
                        <div class="card-body">
                            <?php if ($result->num_rows > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên Sinh Viên</th>
                                                <th>Bài Thi</th>
                                                <th>Khoa</th>
                                                <th>Lớp</th>
                                                <th>Thời Gian Bắt Đầu</th>
                                                <th>Ảnh</th>
                                                <th>Trạng Thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <?php $status = (empty($row['start_time']) || empty($row['image_path'])) ? 'Chưa hoàn thiện' : 'Hoàn thành'; ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td><?= $row['student_name'] ?></td>
                                                <td><?= $row['exam_title'] ?></td>
                                                <td><?= $row['department_name'] ?></td>
                                                <td><?= $row['class_name'] ?></td>
                                                <td>
                                                  <?php
                                                  $startTime = new DateTime($row['start_time']);
                                                  echo $startTime->format('d-m-Y H:i');
                                                  ?>
                                              </td>
                                                <td>
                                                    <?php if (!empty($row['image_path'])): ?>
                                                        <img src="<?= $row['image_path'] ?>" width="50" style="cursor: pointer;" onclick="showImageModal('<?= $row['image_path'] ?>')">
                                                        <br>
                                                        <button class="btn btn-sm btn-primary mt-1" onclick="showImageModal('<?= $row['image_path'] ?>')">Xem ảnh</button>
                                                    <?php else: ?>
                                                        Không có ảnh
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $status ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning text-center">Không có dữ liệu phù hợp.</div>
                            <?php endif; ?>

                            <form method="POST" class="text-center mt-3">
                                <button type="submit" name="export_csv" class="btn btn-success">Xuất File CSV</button>
                            </form>
                        </div>
                    </div>
                </div>
                    <!-- Modal xem ảnh lớn hơn -->
                    <div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg làm modal rộng hơn -->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Ảnh kết quả</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                          </div>
                          <div class="modal-body text-center">
                            <!-- max-height: 80vh giới hạn ảnh theo chiều cao màn hình -->
                            <img id="modalImage" src="" alt="Ảnh phóng to" class="img-fluid" style="max-height: 80vh;">
                          </div>
                        </div>
                      </div>
                    </div>

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
        <script>
        function showImageModal(src) {
          document.getElementById('modalImage').src = src;
          var myModal = new bootstrap.Modal(document.getElementById('viewImageModal'));
          myModal.show();
        }
      </script>

</body>
</html>
