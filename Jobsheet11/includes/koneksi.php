<?php
$host = "localhost";
$port = "5432";
$db   = "simpus_mini_abil";
$user = "postgres";
$pass = "rwqf";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Koneksi database gagal.");
}
