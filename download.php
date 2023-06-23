<?php
session_start(); // セッションを開始します

if(isset($_SESSION['csvData'])) {
    // CSVファイルとして出力
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="ocr.csv"');
    echo $_SESSION['csvData'];
}
?>
