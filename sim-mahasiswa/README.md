# Sim Data Mahasiswa
Nama : Muhammad Yunus Priatna
Nim : 10124184
Kelas: IF - 5

## Fitur
- Otentikasi login berbasis `$_SESSION` (password di-hash `password_hash()`)
- CRUD lengkap (Create, Read, Update, Delete) dengan prepared statement
- Validasi form (percabangan if-else + `filter_var()` + `preg_match()`)
- Sanitasi input & escape output (`strip_tags()`, `htmlspecialchars()`)
- Dual bahasa (Indonesia / English) tersimpan di `$_SESSION`
- Pencarian data, flash message, proteksi CSRF

##  Cara Menjalankan Aplikasi (Instalasi)

1. **Unduh / Clone Repositori**
2. **Pindahkan ke Folder Server**
   Letakkan folder `sim-mahasiswa` ke dalam direktori `htdocs` (jika menggunakan XAMPP) atau `www` (Laragon).
3. **Nyalakan Server**
4. **Import Database**
5. **Konfigurasi Database**
   Jika password MySQL Anda tidak kosong, buka file `config/database.php` dan sesuaikan bagian `$DB_PASS`.
6. **Akses Aplikasi**
   Buka browser dan ketikkan: `http://localhost/sim-mahasiswa/login.php`

## Akun Default
| Username | Password  |
|----------|-----------|
| admin    | admin123  |

## Alur Program Singkat
1. **login.php** → memverifikasi kredensial dengan `password_verify()`, menyimpan `user_id` di `$_SESSION`, lalu redirect ke `index.php`.
2. **config.php** → dijalankan pada setiap halaman: memulai session, memuat file bahasa sesuai `$_SESSION['lang']`, menyediakan helper.
3. **index.php** → `requireLogin()` memproteksi halaman, query SELECT seluruh data, render ke tabel HTML.
4. **create.php** → sanitasi input → `validateStudent()` → INSERT.
5. **edit.php** → ambil data by ID → sanitasi → validasi (kecuali NIM sendiri) → UPDATE.
6. **delete.php** → hanya menerima POST + CSRF token → DELETE by ID.
7. **logout.php** → hapus session & cookie → kembali ke login.