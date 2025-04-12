<?php
$host = "localhost";
$user = "root";  // Tài khoản MySQL (mặc định: root)
$password = "";  // Mật khẩu MySQL (để trống nếu dùng XAMPP)
$database = "qlkythi";

$conn = mysqli_connect($host, $user, $password, $database);

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
