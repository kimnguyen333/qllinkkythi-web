
<?php
session_start();
include 'db.php';

// Kiểm tra xem sinh viên đã đăng nhập chưa
if (!isset($_SESSION['student_id'])) {
    header("Location: login_student.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$exam_id = isset($_GET['exam_id']) ? intval($_GET['exam_id']) : null;

if ($exam_id) {
    // Kiểm tra xem sinh viên đã bắt đầu làm bài chưa
    $check_attempt = $conn->prepare("SELECT id FROM exam_attempts WHERE student_id = ? AND exam_id = ?");
    $check_attempt->bind_param("ii", $student_id, $exam_id);
    $check_attempt->execute();
    $result = $check_attempt->get_result();

    if ($result->num_rows == 0) {
        // Nếu chưa có, thêm vào database
        $insert_attempt = $conn->prepare("INSERT INTO exam_attempts (student_id, exam_id) VALUES (?, ?)");
        $insert_attempt->bind_param("ii", $student_id, $exam_id);
        if (!$insert_attempt->execute()) {
            die("Lỗi khi ghi dữ liệu: " . $insert_attempt->error);
        }
    }

    // Lấy link bài thi từ database
    $exam_link_query = $conn->prepare("SELECT exam_link FROM examstest WHERE id = ?");
    $exam_link_query->bind_param("i", $exam_id);
    $exam_link_query->execute();
    $exam_link_result = $exam_link_query->get_result();

    if ($exam_link_result->num_rows > 0) {
        $exam = $exam_link_result->fetch_assoc();
        header("Location: " . $exam['exam_link']);
        exit();
    } else {
        die("Không tìm thấy bài thi.");
    }
} else {
    die("Thiếu thông tin bài thi.");
}
?>
