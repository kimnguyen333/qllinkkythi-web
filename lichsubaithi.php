<?php
session_start();
include 'db.php'; // Kết nối CSDL

// Kiểm tra đăng nhập
if (!isset($_SESSION['student_id'])) {
    echo "Bạn chưa đăng nhập!";
    exit();
}
$student_id = $_SESSION['student_id'];

// Xử lý thêm ảnh
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_image'])) {
    $exam_attempt_id = $_POST['exam_attempt_id'];
    $image_path = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;

                // Thêm ảnh vào bảng images
                $stmt = $conn->prepare("INSERT INTO images (student_id, image_path) VALUES (?, ?)");
                $stmt->bind_param("is", $student_id, $image_path);
                $stmt->execute();
                $image_id = $stmt->insert_id;

                // Cập nhật image_id vào exam_attempts
                $stmt = $conn->prepare("UPDATE exam_attempts SET image_id = ? WHERE id = ?");
                $stmt->bind_param("ii", $image_id, $exam_attempt_id);
                $stmt->execute();

                echo "<script>alert('Ảnh đã được cập nhật!'); window.location.href=window.location.href;</script>";
            } else {
                echo "<script>alert('Tải ảnh thất bại.');</script>";
            }
        } else {
            echo "<script>alert('Chỉ cho phép định dạng JPG, JPEG, PNG, GIF');</script>";
        }
    }
}

// Truy vấn dữ liệu lịch sử thi của sinh viên hiện tại
$sql = "SELECT ea.id, e.title AS exam_title, ea.start_time, i.image_path
        FROM exam_attempts ea
        JOIN examstest e ON ea.exam_id = e.id
        LEFT JOIN images i ON ea.image_id = i.id
        WHERE ea.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Sử Làm Bài Thi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center text-primary mb-4">Lịch Sử Làm Bài Thi</h2>

        <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Tên Bài Thi</th>
                        <th>Thời Gian</th>
                        <th>Ảnh Minh Chứng</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        $formatted_time = date("d/m/Y H:i:s", strtotime($row['start_time']));
                        $status = !empty($row['image_path']) ? "Hoàn thành" : "Thiếu ảnh minh chứng";
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['exam_title']) ?></td>
                        <td><?= $formatted_time ?></td>
                        <td>
                            <?php if (!empty($row['image_path'])): ?>
                                <img src="<?= $row['image_path'] ?>" width="60">
                            <?php else: ?>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="exam_attempt_id" value="<?= $row['id'] ?>">
                                    <input type="file" name="image" class="form-control mb-1" accept="image/*" required>
                                    <button type="submit" name="add_image" class="btn btn-sm btn-primary">Tải ảnh lên</button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td><?= $status ?></td>
                        <td>
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="exam_attempt_id" value="<?= $row['id'] ?>">
                                <input type="file" name="image" class="form-control mb-1" accept="image/*" required>
                                <button type="submit" name="add_image" class="btn btn-sm btn-warning">Sửa ảnh</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p class="text-center text-muted">Bạn chưa có lịch sử làm bài thi nào.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="trangchusinhvien.php" class="btn btn-secondary">← Quay lại trang chính</a>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
