<?php
require 'db.php'; // Kết nối CSDL

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Lỗi: Không có ID kỳ thi.");
}

$id = $_GET['id'];

// Lấy dữ liệu từ CSDL
$stmt = $conn->prepare("SELECT * FROM examstest WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$exam = $result->fetch_assoc();

if (!$exam) {
    die("Lỗi: Không tìm thấy kỳ thi với ID này.");
}

// Xử lý cập nhật dữ liệu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $exam_link = $_POST['exam_link'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

        // Xử lý upload ảnh
        if (!empty($_FILES['exam_image']['name'])) {
            $target_dir = "uploads/"; // Thư mục lưu ảnh
            $target_file = $target_dir . basename($_FILES["exam_image"]["name"]);
            move_uploaded_file($_FILES["exam_image"]["tmp_name"], $target_file);
        } else {
            $target_file = $exam['image_path']; // Giữ ảnh cũ nếu không có ảnh mới
        }

    // Cập nhật dữ liệu vào CSDL
    $stmt = $conn->prepare("UPDATE examstest SET title=?, description=?, exam_link=?, start_time=?, end_time=?, image_path=? WHERE id=?");
    $stmt->bind_param("ssssssi", $title, $description, $exam_link, $start_time, $end_time, $target_file, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location='qlkythi.php';</script>";
    } else {
        echo "Lỗi cập nhật: " . $conn->error;
    }
}
?>

<!-- html -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa kỳ thi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background-color: #f8f9fa;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">Sửa thông tin kỳ thi</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ảnh kỳ thi</label>
                                <input type="file" name="exam_image" class="form-control">
                                <?php if (!empty($exam['image_path'])): ?>
                                    <p class="mt-2">Ảnh hiện tại:</p>
                                    <img src="<?= htmlspecialchars($exam['image_path']) ?>" alt="Exam Image" width="150" class="img-thumbnail">
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tiêu đề</label>
                                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($exam['title']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Mô tả</label>
                                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($exam['description']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Link bài thi</label>
                                <input type="url" name="exam_link" class="form-control" value="<?= htmlspecialchars($exam['exam_link']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Thời gian bắt đầu</label>
                                <input type="datetime-local" name="start_time" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($exam['start_time'])) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Thời gian kết thúc</label>
                                <input type="datetime-local" name="end_time" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($exam['end_time'])) ?>" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success px-4">Cập nhật</button>
                                <a href="qlkythi.php" class="btn btn-secondary px-4">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
