<?php
declare(strict_types=1);

require __DIR__ . '/includes/koneksi.php';

$jsonFile = '/home/fx/c3/pweb/PemrogWeb2026-SM3/Jobsheet7/data/buku.json';

try {
    if (!is_file($jsonFile)) {
        throw new RuntimeException("File JSON tidak ditemukan: {$jsonFile}");
    }

    $raw = file_get_contents($jsonFile);
    if ($raw === false) {
        throw new RuntimeException("Gagal membaca file: {$jsonFile}");
    }

    $data = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException('JSON tidak valid: ' . json_last_error_msg());
    }
    if (!is_array($data)) {
        throw new RuntimeException('Format JSON harus array of objects.');
    }

    $sql = 'INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
            VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)';
    $stmt = $pdo->prepare($sql);

    $pdo->beginTransaction();
    $ok = 0;
    $skip = 0;

    foreach ($data as $i => $row) {
        $judul = trim((string)($row['judul'] ?? ''));
        $pengarang = trim((string)($row['pengarang'] ?? ''));
        $tahun = $row['tahun'] ?? null;
        $stok = $row['stok'] ?? 0;
        $kategori = isset($row['kategori']) ? trim((string)$row['kategori']) : null;
        $isbn = isset($row['isbn']) ? trim((string)$row['isbn']) : null;

        if ($judul === '' || $pengarang === '' || !is_numeric($tahun)) {
            $skip++;
            continue;
        }

        $stmt->execute([
            ':judul'     => $judul,
            ':pengarang' => $pengarang,
            ':tahun'     => (int)$tahun,
            ':isbn'      => ($isbn === '' ? null : $isbn),
            ':stok'      => (int)$stok,
            ':kategori'  => ($kategori === '' ? null : $kategori),
        ]);
        $ok++;
    }

    $pdo->commit();

    echo "Selesai. Berhasil INSERT: {$ok}, dilewati (data tidak lengkap): {$skip}\n";
} catch (Throwable $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    fwrite(STDERR, 'Gagal import: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}
