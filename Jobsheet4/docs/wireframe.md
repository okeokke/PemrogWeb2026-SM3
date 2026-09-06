# Wireframe & User Flow — SIMPUS-Mini

Halaman yang sudah ada (Beranda, Daftar/Tambah Buku, Daftar/Tambah Anggota — Jobsheet 1-3) belum mencakup fitur Login, Dashboard Petugas, dan Peminjaman/Pengembalian. Dokumen ini merancang wireframe untuk halaman-halaman tersebut sebelum diimplementasikan mulai Jobsheet 5 dan seterusnya.

## Aktor
- **Tamu**: hanya bisa melihat katalog buku (Beranda, Daftar Buku) tanpa login.
- **Petugas**: login untuk mengakses seluruh fitur CRUD dan transaksi peminjaman.

## User Flow — Peminjaman Buku

```
[Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"]
        -> [Pilih Anggota] -> [Pilih Buku (stok > 0)]
        -> [Simpan] -> [Stok buku berkurang 1]
        -> [Database Update Status Peminjaman] -> [Kembali ke Dashboard]
```

## User Flow — Pengembalian Buku

```
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)]
        -> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1]
        -> [Database Update Status Peminjaman] -> [Kembali ke Dashboard]
```

## User Flow — Buku Terlambat

```
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)]
        -> [Tandai "Terlambat"] -> [Database Update Status Peminjaman]
        -> [Kembali ke Dashboard]
```

## Wireframe: Halaman Login

```
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|         [  Login Petugas  ]          |
|                                      |
|      Username : [______________]     |
|      Password : [______________]     |
|                                      |
|            [   Masuk   ]             |
|                                      |
|        Ajukan Akun Baru Disini       |
+--------------------------------------+
```

## Wireframe: Halaman Pendaftaran

```
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|       [  Pendaftaran Petugas  ]      |
|                                      |
|    Nama Lengkap : [______________]   |
|      Username : [______________]     |
|       Kontak : [______________]      |
|      Password : [______________]     |
|  Konfirmasi Password : [___________] |
|                                      |
|            [   Masuk   ]             |
|                                      |
|            Login Akun Lama           |
+--------------------------------------+
```

## Wireframe: Dashboard Petugas

```
+---------------------------------------------------------------------------------------+
| SIMPUS-Mini      Beranda | Buku | Anggota | Peminjaman | (Petugas: Abil) Logout       |
|---------------------------------------------------------------------------------------|
|  [Total Buku = 43]  [Total Anggota = 12]  [Sedang Dipinjam = 8]  [Buku Terlambat = 4] |
|                                                                                       |
|  Aksi Cepat:                                                                          |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]  [ + Tambah/Hapus Buku ]                  |
|                                                                                       |
|  Transaksi Terbaru                                                                    |
|  -------------------------------------------------------------------------------------|
|  No. Anggota | Nama Anggota | Buku         | Tgl Pinjam | Tgl Kembali | Status    |   |
|  MA01        | Iskandar     | 1984         | 11/03/2026 | 18/03/2026  | Dipinjam  |   |
|  PK02        | Efvy         | Animal Farm  | 21/03/2026 | 28/03/2026  | Terlambat |   |
+---------------------------------------------------------------------------------------+
```

## Wireframe: Form Peminjaman

```
+--------------------------------------+
|  Form Peminjaman Buku                |
|--------------------------------------|
|  Anggota :[ dropdown: Iskandar ]     |
|  Buku    :[ dropdown: 1984 (stok: 3)]|
|  Kategori :[ dropdown: fiksi ]       |
|  Tanggal Pinjam :[ auto: 11/03/2026] |
|  Tanggal Kembali:[ auto: 18/03/2026] |
|                                      |
|        [  Simpan Peminjaman  ]       |
+--------------------------------------+
```

## Wireframe: Form Pengembalian

```
+-----------------------------------------------------------------------------------------+
|  Pengembalian Buku & Validasi Keterlambatan                                             |
|-----------------------------------------------------------------------------------------|
|  Cari Transaksi Aktif : [ Ketik No. Anggota / Judul Buku ________________ ] [ Cari ]    |
|                                                                                         |
|  No. Anggota | Anggota  | Judul Buku   | Tgl Pinjam | Status / Denda    | Aksi          |
|  MA01        | Iskandar | 1984         | 11/03/2026 | Tepat Waktu (Rp0) | [Kembalikan]  |
|  PK02        | Efvy     | Animal Farm  | 21/03/2026 | Terlambat (Rp5rb) | [Kembalikan]  |
+-----------------------------------------------------------------------------------------+
```

## Wireframe: Riwayat Peminjaman per Anggota

```
+--------------------------------------------------------------------------+
|  Riwayat Transaksi Anggota — MA01 (Iskandar)                             |
|--------------------------------------------------------------------------|
|  Judul Buku   | Kategori   | Tgl Pinjam | Tgl Kembali | Denda | Status   |
|  1984         | Fiksi      | 11/03/2026 | 18/03/2026  | Rp 0  | Selesai  |
+--------------------------------------------------------------------------+
```

## 

## Konsistensi dengan Desain yang Sudah Berjalan
- Warna aksen, tipografi navbar, dan gaya tabel/kartu mengikuti `assets/css/style.css` yang sudah dibangun sejak Jobsheet 2-3.
- Navbar akan ditambah menu **Peminjaman** dan indikator status login (nama petugas / tombol Logout) mulai implementasi di Jobsheet 10.
- Edge case yang perlu ditangani saat implementasi: buku stok habis tidak boleh dipilih di form peminjaman; anggota dengan tunggakan terlambat divalidasi di Jobsheet 12 (tugas mandiri).
