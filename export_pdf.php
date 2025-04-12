<?php
include 'db.php';
require 'vendor/autoload.php'; // Load thư viện TCPDF

use TCPDF;

if (isset($_GET['exam_id'])) {
    $exam_id = $_GET['exam_id'];

    // Tạo PDF
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Hệ Thống Thi');
    $pdf->SetTitle('Kết Quả Thi');
    $pdf->AddPage();

    // Tiêu đề
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, "Kết Quả Kỳ Thi", 0, 1, 'C');

    // Dữ liệu từ MySQL
    $pdf->SetFont('helvetica', '', 12);
    $content = "<table border='1' cellpadding='5'>
                <tr>
                    <th>Họ tên</th>
                    <th>Điểm</th>
                    <th>Thời gian nộp</th>
                </tr>";

    $sql = "SELECT students.name, results.score, results.submit_time 
            FROM results 
            JOIN students ON results.student_id = students.id
            WHERE results.exam_id = '$exam_id'
            ORDER BY results.submit_time DESC";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $content .= "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['score']}</td>
                        <td>{$row['submit_time']}</td>
                    </tr>";
    }

    $content .= "</table>";

    $pdf->writeHTML($content, true, false, true, false, '');
    $pdf->Output("KetQuaThi_$exam_id.pdf", 'D');
    exit();
}
?>
