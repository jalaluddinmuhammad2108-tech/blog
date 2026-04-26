<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
    exit;
}

// Cek apakah kategori masih digunakan
$stmtCek = $conn->prepare("SELECT COUNT(*) AS total FROM artikel WHERE id_kategori = ?");
$stmtCek->bind_param('i', $id);
$stmtCek->execute();
$total = $stmtCek->get_result()->fetch_assoc()['total'];
$stmtCek->close();

if ($total > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Kategori tidak dapat dihapus karena masih memiliki artikel']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus kategori']);
}

$stmt->close();
$conn->close();
