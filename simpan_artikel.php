<?php
header('Content-Type: application/json');
require 'koneksi.php';

$judul      = trim($_POST['judul'] ?? '');
$id_penulis = (int)($_POST['id_penulis'] ?? 0);
$id_kategori = (int)($_POST['id_kategori'] ?? 0);
$isi        = trim($_POST['isi'] ?? '');

if (!$judul || $id_penulis <= 0 || $id_kategori <= 0 || !$isi) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit;
}

// Upload gambar wajib
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'Gambar artikel wajib diunggah']);
    exit;
}

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

$ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
$namaFile = uniqid('artikel_', true) . '.' . $ext;
$tujuan   = 'uploads_artikel/' . $namaFile;

if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload gambar']);
    exit;
}

// Generate hari_tanggal dari server
date_default_timezone_set('Asia/Jakarta');
$hari   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan  = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',
    4=>'April', 5=>'Mei', 6=>'Juni',
    7=>'Juli', 8=>'Agustus', 9=>'September',
    10=>'Oktober', 11=>'November', 12=>'Desember'
];
$sekarang    = new DateTime();
$nama_hari   = $hari[$sekarang->format('w')];
$tanggal     = $sekarang->format('j');
$nama_bulan  = $bulan[(int)$sekarang->format('n')];
$tahun       = $sekarang->format('Y');
$jam         = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

$stmt = $conn->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $namaFile, $hari_tanggal);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil ditambahkan']);
} else {
    unlink($tujuan);
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan artikel: ' . $conn->error]);
}

$stmt->close();
$conn->close();
