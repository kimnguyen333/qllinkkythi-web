<?php
session_start();
include 'db.php'; 

// Kiểm tra đăng nhập
if (!isset($_SESSION['student_id'])) {
  header("Location: dangnhapsv.php");
  exit();
}

// Lấy danh sách bài thi từ database
$user_id = $_SESSION['student_id'];
$current_time = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại theo múi giờ server

$keyword = isset($_GET['keyword']) ? $conn->real_escape_string($_GET['keyword']) : '';

$sql = "SELECT * FROM examstest WHERE start_time <= '$current_time' AND end_time >= '$current_time'";

if (!empty($keyword)) {
    $sql .= " AND title LIKE '%$keyword%'";
}

$sql .= " ORDER BY start_time ASC";
$result = $conn->query($sql);

// Lưu kết quả vào một mảng
$exams = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exams[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Thi Trực Tuyến</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link rel="stylesheet" href="assets/css/style.css" />  <!-- css main -->
</head>
    <style>
    </style>
</head>

<body class="index-page">
<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
    <!-- Logo -->
    <a href="trangchusinhvien.php" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <h1 class="sitename">Thi Trực Tuyến</h1>
    </a>
    <!-- Menu và Avatar gom chung để căn chỉnh -->
    <div class="d-flex align-items-center gap-3">
      <!-- Menu trái -->
      <nav id="navmenu" class="navmenu">
        <ul class="d-flex align-items-center mb-0">
          <li><a href="lichsubaithi.php">📜 Lịch Sử Bài Thi</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <!-- Avatar phải -->
      <ul class="navbar-nav d-flex align-items-center mb-0">
        <li class="nav-item dropdown">
          <a class="dropdown-toggle profile-pic d-flex align-items-center" data-bs-toggle="dropdown" href="#" aria-expanded="false">
            <div class="avatar-sm">
              <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
            </div>
          </a>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
          <?php
                  // Lấy thông tin sinh viên
                  $teacher_id = $_SESSION['student_id'];
                  $sql = "SELECT name FROM students WHERE id = ?";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("i", $teacher_id);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  $student = $result->fetch_assoc();
                  ?>
            <li>
              <div class="user-box">
                <div class="avatar-lg">
                  <img src="assets/img/profile.jpg" alt="image profile" class="avatar-img rounded" />
                </div>
                <div class="u-text">
                  <h4>Sinh viên</h4>
                  <span class="fw-bold"><?php echo htmlspecialchars($student['name']); ?></span>
                  </div>
              </div>
            </li>
            <li><div class="dropdown-divider"></div></li>
            <li><a class="dropdown-item" href="#">Thông tin hồ sơ</a></li>
            <li><div class="dropdown-divider"></div></li>
            <li><a class="dropdown-item" href="doimatkhau.php">🔑 Đổi Mật Khẩu</a></li>
            <li><div class="dropdown-divider"></div></li>
            <li><a class="dropdown-item" href="dangxuatsv.php">Đăng Xuất</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</header>
</div>
  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <img src="assets/img/hero-bg-light.webp" alt="">
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center">
          <h1 data-aos="fade-up"><span>Quộc Thi Trực Tuyến</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Chọn Link Bài Thi Mà Bạn Muốn Tham Gia<br></p>
            <div class="container mt-5" data-aos="fade-up" data-aos-delay="200">
                      <div id="examCarousel" class="carousel slide" data-bs-ride="carousel">
                          <!-- indicators -->
                          <div class="carousel-indicators">
                              <button type="button" data-bs-target="#examCarousel" data-bs-slide-to="0" class="active"></button>
                              <button type="button" data-bs-target="#examCarousel" data-bs-slide-to="1"></button>
                              <button type="button" data-bs-target="#examCarousel" data-bs-slide-to="2"></button>
                          </div>
                          <!-- images -->
                          <div class="carousel-inner">
                              <div class="carousel-item active">
                                  <img src="assets/img/d1.jpg" class="d-block w-100" alt="Ảnh 1">
                              </div>
                              <div class="carousel-item">
                                  <img src="assets/img/d2.png" class="d-block w-100" alt="Ảnh 2">
                              </div>
                              <div class="carousel-item">
                                  <img src="assets/img/d3.png" class="d-block w-100" alt="Ảnh 3">
                              </div>
                          </div>
                          <!-- controls -->
                          <button class="carousel-control-prev" type="button" data-bs-target="#examCarousel" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon"></span>
                          </button>
                          <button class="carousel-control-next" type="button" data-bs-target="#examCarousel" data-bs-slide="next">
                              <span class="carousel-control-next-icon"></span>
                          </button>
                      </div>
                  </div>
            <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="container mt-4">
           <header id="header" class="header d-flex align-items-center fixed-top">
           <div class="container-fluid container-xl position-relative d-flex align-items-center">
             <a href="index.php" class="logo d-flex align-items-center me-auto">
             </a>
          </div>
</header>
<!-- Phần Tìm Kiếm -->
<div class="container mt-5 search-section" data-aos="fade-up" data-aos-delay="200">
    <form method="GET" action="">
        <div class="input-group mb-3">
            <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
            <button class="btn btn-primary" type="submit">🔍 Tìm kiếm</button>
        </div>
    </form>
</div>
<main class="main">
    <div class="container">

        <?php if (!isset($_SESSION['student_id'])): ?>
            <div class="alert alert-warning alert-container">
                Bạn cần <a href="login_student.php"><strong>đăng nhập</strong></a> để xem danh sách bài thi.
            </div>
            <?php else: ?>
            <!-- Hiển thị bài thi dưới dạng thẻ card -->
        <div class="grid mt-4">
        <?php
            if (count($exams) > 0) {
                foreach ($exams as $exam) {
                    echo "<div class='card exam-card'>
                        <img src='" . htmlspecialchars($exam['image_path']) . "' alt='Thumbnail' class='thumbnail'>
                        <h3>" . htmlspecialchars($exam['title']) . "</h3>
                        <p><span class='icon'>🕒</span> Bắt đầu: " . (new DateTime($exam['start_time']))->format('d-m-Y H:i') . "</p>
                        <p><span class='icon'>🕒</span> Kết thúc: " . (new DateTime($exam['end_time']))->format('d-m-Y H:i') . "</p>
                        <p class='author'>Người tạo bài thi: " . htmlspecialchars($exam['teacher_name'] ?? "Giáo Viên") . "</p>
                        <a href='start_exam.php?exam_id=" . htmlspecialchars($exam['id']) . "' class='exam-btn' target='_blank'>Vào link thi</a>
                    </div>";
                }
            } else {
                echo "<p class='text-center'>Không có bài thi nào đang diễn ra.</p>";
            }
            ?>
        </div>
        <?php endif; ?>
    </div>
  </main>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Preloader -->
  <div id="preloader"></div>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>