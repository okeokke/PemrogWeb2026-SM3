<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

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

$stmt = $pdo->prepare(
    "INSERT INTO anggota (nama, no_anggota, alamat, no_hp)
     VALUES (:nama, :no_anggota, :alamat, :no_hp)
     RETURNING id"
);
try {
    $stmt->execute([
        'nama' => $nama,
        'no_anggota' => $noAnggota,
        'alamat' => $alamat,
        'no_hp' => $noHp,
    ]);
} catch (PDOException $e) {
    if ($e->getCode()==='23505') {
        $_SESSION['flash']=['type' => 'error', 'pesan' => 'No. Anggota sudah dipakai, gunakan nomor lain.'];
    } else {
        $_SESSION['flash']=['type' => 'error', 'pesan' => 'Gagal menambahkan anggota. Silakan coba lagi.'];
    }
    header('Location: tambah.php');
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;
