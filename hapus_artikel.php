<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
    exit;
}

// Ambil gambar untuk dihapus
$stmtGambar = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtGambar->bind_param('i', $id);
$stmtGambar->execute();
$row = $stmtGambar->get_result()->fetch_assoc();
$stmtGambar->close();

$stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus file gambar dari server
    if ($row && file_exists('uploads_artikel/' . $row['gambar'])) {
        unlink('uploads_artikel/' . $row['gambar']);
    }
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus artikel']);
}

$stmt->close();
$conn->close();
