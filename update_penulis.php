<?php
header('Content-Type: application/json');
require 'koneksi.php';

$id = (int) ($_POST['id'] ?? 0);
$nama_depan = trim($_POST['nama_depan'] ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name = trim($_POST['user_name'] ?? '');
$password = $_POST['password'] ?? '';

if ($id <= 0 || !$nama_depan || !$nama_belakang || !$user_name) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

// Ambil data lama
$stmtOld = $conn->prepare("SELECT foto, password FROM penulis WHERE id = ?");
$stmtOld->bind_param('i', $id);
$stmtOld->execute();
$old = $stmtOld->get_result()->fetch_assoc();
$stmtOld->close();

if (!$old) {
    echo json_encode(['status' => 'error', 'message' => 'Penulis tidak ditemukan']);
    exit;
}

$foto = $old['foto'];
$hashed = $old['password'];

// Update password jika diisi
if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_BCRYPT);
}

// Handle foto baru
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['foto'];

    if ($file['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran file maksimal 2 MB']);
        exit;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan']);
        exit;
    }

    // Ambil ekstensi dari MIME type (bukan dari nama file user)
    $mimeToExt = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
    $ext = $mimeToExt[$mime];
    $namaFile = uniqid('penulis_', true) . '.' . $ext;
    $tujuan = 'uploads_penulis/' . $namaFile;

    if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload foto']);
        exit;
    }

    // Hapus foto lama jika bukan default
    if ($foto !== 'default.png' && file_exists('uploads_penulis/' . $foto)) {
        unlink('uploads_penulis/' . $foto);
    }
    $foto = $namaFile;
}

$stmt = $conn->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
$stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $user_name, $hashed, $foto, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil diperbarui']);
} else {
    if ($stmt->errno === 1062) {
        echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui penulis: ' . $stmt->error]);
    }
}

$stmt->close();
$conn->close();
?>