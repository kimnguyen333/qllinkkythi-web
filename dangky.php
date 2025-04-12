<?php
include 'db.php';
session_start();

// Lấy danh sách khoa
$khoa_result = $conn->query("SELECT id, ten_khoa FROM khoa");

// Lấy danh sách lớp theo khoa
if (isset($_GET['khoa_id'])) {
    $khoa_id = $_GET['khoa_id'];
    $lop_result = $conn->query("SELECT id, ten_lop FROM lop WHERE khoa_id = $khoa_id");
    $lop_options = [];
    while ($row = $lop_result->fetch_assoc()) {
        $lop_options[] = $row;
    }
    echo json_encode($lop_options);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = ($_POST['password']);
    $khoa_id = $_POST['khoa'];
    $lop_id = $_POST['lop'];

    $stmt = $conn->prepare("SELECT id FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email đã tồn tại!'); window.location.href='dangky.php';</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO students (name, email, password, khoa_id, lop_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $name, $email, $password, $khoa_id, $lop_id);
        if ($stmt->execute()) {
            echo "<script>alert('Đăng ký thành công!'); window.location.href='dangnhapsv.php';</script>";
        } else {
            echo "<script>alert('Đăng ký không thành công!'); window.location.href='dangky.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng Ký Sinh Viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">

<div class="card p-4 shadow" style="min-width: 400px;">
  <h3 class="text-center text-success mb-3">Đăng Ký Sinh Viên</h3>

  <form action="dangky.php" method="POST">
    <div class="mb-3">
      <label for="name" class="form-label">Họ và Tên</label>
      <input type="text" class="form-control" name="name" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Mật khẩu</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
      <label for="khoa" class="form-label">Chọn Khoa</label>
      <select class="form-select" name="khoa" id="khoa" onchange="loadLop()" required>
        <option value="">-- Chọn khoa --</option>
        <?php while ($row = $khoa_result->fetch_assoc()) { ?>
          <option value="<?php echo $row['id']; ?>"><?php echo $row['ten_khoa']; ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="lop" class="form-label">Chọn Lớp</label>
      <select class="form-select" name="lop" id="lop" required>
        <!-- Danh sách lớp sẽ được thêm vào bằng JavaScript -->
      </select>
    </div>

    <button type="submit" class="btn btn-success w-100">Đăng Ký</button>
  </form>

  <p class="mt-3 text-center">Đã có tài khoản? <a href="dangnhapsv.php">Đăng Nhập</a></p>
</div>

<script>
  function loadLop() {
    var khoaId = document.getElementById("khoa").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "dangky.php?khoa_id=" + khoaId, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        var lopSelect = document.getElementById("lop");
        lopSelect.innerHTML = "<option value=''>-- Chọn lớp --</option>";
        var classes = JSON.parse(xhr.responseText);
        classes.forEach(function (lop) {
          var option = document.createElement("option");
          option.value = lop.id;
          option.textContent = lop.ten_lop;
          lopSelect.appendChild(option);
        });
      }
    };
    xhr.send();
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
