<?php
include 'db.php';
require 'vendor/autoload.php'; // Load thư viện PHPExcel

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_GET['exam_id'])) {
    $exam_id = $_GET['exam_id'];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Tiêu đề cột
    $sheet->setCellValue('A1', 'Họ tên');
    $sheet->setCellValue('B1', 'Điểm');
    $sheet->setCellValue('C1', 'Thời gian nộp');

    // Lấy dữ liệu từ MySQL
    $sql = "SELECT students.name, results.score, results.submit_time 
            FROM results 
            JOIN students ON results.student_id = students.id
            WHERE results.exam_id = '$exam_id'
            ORDER BY results.submit_time DESC";
    $result = mysqli_query($conn, $sql);

    $rowIndex = 2;
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->setCellValue("A$rowIndex", $row['name']);
        $sheet->setCellValue("B$rowIndex", $row['score']);
        $sheet->setCellValue("C$rowIndex", $row['submit_time']);
        $rowIndex++;
    }

    // Xuất file Excel
    $filename = "KetQuaThi_$exam_id.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');  
    exit();
}
?>
