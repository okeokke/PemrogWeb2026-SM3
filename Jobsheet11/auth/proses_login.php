<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';
//init perhitungan percobaan login jika belum ada
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SESSION['login_attempts'] >= 3) { //cek percobaan login
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Akun dikunci sementara karena 3x gagal login. Harap tunggu atau hubungi admin.'
    ];
    header('Location: login.php');
    exit;
}


$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    unset($_SESSION['login_attempts']); //ulang counter ke 0 jika berhasil login

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    if (!empty($_POST['remember'])) {
        $kadaluwarsa = time() + (86400 * 7); //timeout 7hari
        setcookie('remember_user', $user['id'], $kadaluwarsa, "/", "", false, true);
    }
    header('Location: ../index.php');
    exit;
}

$_SESSION['login_attempts']++;//increment counter dan hitung sisa kesempatan login
$sisa = 3 - $_SESSION['login_attempts'];
$_SESSION['flash'] = [
    'type' => 'error',
    'pesan' => "Username atau password salah. (Sisa kesempatan: {$sisa})"
];
header('Location: login.php');
exit;
