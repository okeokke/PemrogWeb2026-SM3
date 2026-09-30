<?php
require __DIR__ . '/../includes/auth.php';
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Sengaja hanya menerima POST (bukan GET) agar penghapusan tidak bisa
// dipicu tanpa sengaja lewat link/preview crawler.
if (($_SESSION['role'] ?? '') !== 'admin') {
  $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Akses ditolak. Hanya admin yang boleh menghapus buku.'];
  header('Location: list.php');
  exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = $_POST['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil dihapus.'];
}

header('Location: list.php');
exit;
