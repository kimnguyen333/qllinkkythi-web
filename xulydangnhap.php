<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if ($role == "student") {
        $table = "students";
        $id_column = "student_id";
        $login_page = "dangnhapsv.php";
        $home_page = "trangchusinhvien.php";
        $session_key = "student_id";  // Tạo session riêng
    } else if ($role == "teacher") {
        $table = "teachers";
        $id_column = "teacher_id";
        $login_page = "dangnhapgv.php";
        $home_page = "trangchugiaovien.php";
        $session_key = "teacher_id";  // Tạo session riêng
    } else {
        die("Vai trò không hợp lệ!");
    }

    $stmt = $conn->prepare("SELECT id, password FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['password']) {
        $_SESSION[$session_key] = $user['id']; // Lưu session riêng cho từng loại user
        header("Location: $home_page");
        exit();
    } else {
        echo "<script>alert('Sai email hoặc mật khẩu!'); window.location.href='$login_page';</script>";
    }
}

?>
