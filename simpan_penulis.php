<?php
header('Content-Type: application/json');
require 'koneksi.php';

$nama_depan   = trim($_POST['nama_depan'] ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name    = trim($_POST['user_name'] ?? '');
$password     = $_POST['password'] ?? '';

if (!$nama_depan || !$nama_belakang || !$user_name || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit;
}

// Handle foto upload
$foto = 'default.png';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['foto'];

    // Validasi ukuran
    if ($file['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran file maksimal 2 MB']);
        exit;
    }

    // Validasi tipe file dengan finfo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WEBP']);
        exit;
    }

    // Ambil ekstensi dari MIME type (bukan dari nama file user)
    $mimeToExt = ['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif','image/webp'=>'webp'];
    $ext      = $mimeToExt[$mime];
    $namaFile = uniqid('penulis_', true) . '.' . $ext;
    $tujuan   = 'uploads_penulis/' . $namaFile;

    if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload foto']);
        exit;
    }
    $foto = $namaFile;
}

// Hash password
$hashed = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $nama_depan, $nama_belakang, $user_name, $hashed, $foto);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil ditambahkan']);
} else {
    // Hapus file yang sudah terupload jika query gagal
    if ($foto !== 'default.png' && file_exists('uploads_penulis/' . $foto)) {
        unlink('uploads_penulis/' . $foto);
    }
    // Cek duplikat username
    if ($stmt->errno === 1062) {
        echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan penulis: ' . $stmt->error]);
    }
}

$stmt->close();
$conn->close();
?>