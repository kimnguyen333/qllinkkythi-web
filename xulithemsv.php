<?php
include 'db.php';
require 'vendor/autoload.php'; // Import thư viện PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra nếu file được tải lên
    if (!empty($_FILES['student_file']['name'])) {
        $file = $_FILES['student_file']['tmp_name'];

        // Đọc file Excel
        try {
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Bỏ qua dòng tiêu đề (nếu có)
            foreach ($data as $index => $row) {
                if ($index == 0) continue;
                
                $name = mysqli_real_escape_string($conn, $row[0]); 
                $email = mysqli_real_escape_string($conn, $row[1]);
                $password = password_hash($row[2], PASSWORD_BCRYPT);
                $khoa_id = mysqli_real_escape_string($conn, $row[3]);
                $lop_id = mysqli_real_escape_string($conn, $row[4]);

                // Kiểm tra dữ liệu
                if (!empty($name) && !empty($email) && !empty($password) && !empty($khoa_id) && !empty($lop_id)) {
                    $sql = "INSERT INTO students (name, email, password, khoa_id, lop_id) VALUES ('$name', '$email', '$password', '$khoa_id', '$lop_id')";
                    if (!mysqli_query($conn, $sql)) {
                        echo "Lỗi: " . mysqli_error($conn);
                    }
                }
            }
            header("Location: qlsv.php");
            exit();
        } catch (Exception $e) {
            echo "Lỗi khi đọc file: " . $e->getMessage();
        }
    }

    // Nếu thêm thủ công
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['khoa_id']) && !empty($_POST['lop_id'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];
        $khoa_id = mysqli_real_escape_string($conn, $_POST['khoa_id']);
        $lop_id = mysqli_real_escape_string($conn, $_POST['lop_id']);

        $sql = "INSERT INTO students (name, email, password, khoa_id, lop_id) VALUES ('$name', '$email', '$password', '$khoa_id', '$lop_id')";
        if (!mysqli_query($conn, $sql)) {
            echo "Lỗi: " . mysqli_error($conn);
        } else {
            header("Location: qlsv.php");
            exit();
        }
    }
}
?>