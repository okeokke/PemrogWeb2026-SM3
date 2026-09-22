<?php
session_start();

$nama = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($noAnggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
} elseif (strlen($noAnggota)<4){
  $errors[] = "No. Anggota harus memiliki paling tidak 4 karakter.";
}
if ($noHp!==''){
    if (!preg_match('/^[0-9-]+$/', $noHp)) {
        $errors[] = "No. HP hanya boleh berisi angka dan hyphen (-).";
    } else {
        $digitCount=preg_match_all('/[0-9]/', $noHp);
        if ($digitCount<10) {
            $errors[] = "No. HP harus mengandung minimum 10 digit angka.";
        }
    }
}
if ($alamat === ""){
  $errors[] = "Alamat wajib di-isi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

$_SESSION['anggota'][] = [
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'alamat' => $alamat,
    'no_hp' => $noHp,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;
