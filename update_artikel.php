<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id          = (int)($_POST['id'] ?? 0);
$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = (int)($_POST['id_penulis'] ?? 0);
$id_kategori = (int)($_POST['id_kategori'] ?? 0);
$isi         = trim($_POST['isi'] ?? '');

if ($id <= 0 || !$judul || $id_penulis <= 0 || $id_kategori <= 0 || !$isi) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

// Ambil gambar lama
$stmtOld = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtOld->bind_param('i', $id);
$stmtOld->execute();
$old = $stmtOld->get_result()->fetch_assoc();
$stmtOld->close();

if (!$old) {
    echo json_encode(['status' => 'error', 'message' => 'Artikel tidak ditemukan']);
    exit;
}

$gambar = $old['gambar'];

// Handle gambar baru (opsional saat edit)
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['gambar'];

    if ($file['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran file maksimal 2 MB']);
        exit;
    }

    $finfo   = new finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($file['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan']);
        exit;
    }

    // Ambil ekstensi dari MIME type (bukan dari nama file user)
    $mimeToExt = ['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif','image/webp'=>'webp'];
    $ext      = $mimeToExt[$mime];
    $namaFile = uniqid('artikel_', true) . '.' . $ext;
    $tujuan   = 'uploads_artikel/' . $namaFile;

    if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload gambar']);
        exit;
    }

    // Hapus gambar lama
    if (file_exists('uploads_artikel/' . $gambar)) {
        unlink('uploads_artikel/' . $gambar);
    }
    $gambar = $namaFile;
}

$stmt = $conn->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil diperbarui']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui artikel']);
}

$stmt->close();
$conn->close();
?>