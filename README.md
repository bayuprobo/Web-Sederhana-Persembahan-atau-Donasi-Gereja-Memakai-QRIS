# Web-Sederhana-Persembahan-atau-Donasi-Gereja-Memakai-QRIS
Web sederhana untuk menolong donatur dan admin dalam melakukan donasi dan pencatatan persembahan beserta tujuan atas persembahan tersebut.
Dokumentasi hasil percakapan dengan ChatGPT

Saya ingin membuat website sederhana untuk menolong donatur dalam mengirim donasi. Juga menolong admin yang menerima donasi agar tidak harus selalu mengontak donatur untuk menanyakan alokasinya. Susunan sederhana web 
Tampilan 1 donatur mengisi data diri dan alokasi donasi dan totalnya. Setelah klik, data dari Tampilan 1 dikirim ke e-mail namalembaga@namadomain.org 
Tampilan 2 donatur diminta untuk memilih mengirim dana via transfer atau via QRIS. Donatur dipersilakan klik salah satu pilihan. 
Tampilan pilih transfer 
Tampilan pilih QRIS 
Tampilan akhir yang ucapan terima kasih dan ayat Alkitab. 


Berdasarkan penjelasan Anda, saya memahami alur website yang diinginkan sebagai berikut.
Alur Website
Donatur
    │
    ▼
Halaman 1
Mengisi data diri
+
Memilih alokasi donasi
+
Mengisi nominal

Klik "Lanjut"

    │
    ├──► Email dikirim ke
    │    namalembaga@namadomain.org
    │
    ▼

Halaman 2
Pilih metode pembayaran

( ) Transfer Bank
( ) QRIS

    │
    ├──────────────┐
    ▼              ▼

Halaman 3A      Halaman 3B
Transfer Bank     QRIS

    │              │
    └──────┬───────┘
           ▼

Halaman 4
Terima kasih
+
Ayat Alkitab

Teknologi yang Dipakai
Karena sebelumnya kita pernah berdiskusi mengenai server Ubuntu, Apache, PHP, dan MariaDB, saya menyarankan menggunakan:
Ubuntu Server
Apache
PHP 8
MariaDB
HTML + Bootstrap 5
PHPMailer (mengirim email)
QR Code gambar statis
Tidak memerlukan framework Laravel sehingga lebih mudah dipelajari.

Detail Alur
Halaman 1
Misalnya tampilannya seperti berikut.
========================================

      Lembaga Pelayanan-Gereja
        Form Donasi

========================================

Nama Lengkap [________________________]

Sapaan

( ) Bapak
( ) Ibu
( ) Saudara
( ) Saudari

Nomor WA [________________________]

Email [________________________]

Domisili [________________________]

==============================

Alokasi Donasi

[ ] Operasional Nasional Nominal Rp [____________]

------------------------------

[ ] Pelayanan Lapangan Nominal Rp [____________]

------------------------------

[ ] Beasiswa Nominal Rp [____________]

------------------------------

TOTAL DONASI Rp 1.250.000

        [ LANJUT ]

Keuntungan model ini:
Donatur langsung mengalokasikan nominal masing-masing.
Admin tidak perlu menelepon lagi.

Setelah klik LANJUT
PHP akan:
menghitung total
menyimpan ke database
mengirim email ke
namalembaga@namadomain.org
Isi email misalnya
DONASI BARU

Nama : Bayu Bayu

WA : 0812xxxxxxx

Email : bayubayu@gkmail-com.com

Domisili : Pekanbaru

================================

Operasional Nasional Rp500.000

Pelayanan Lapangan Rp250.000
Beasiswa Rp500.000
================================
TOTAL Rp1.250.000

Halaman 2
===================================
Terima kasih.
Silakan pilih metode pembayaran.
===================================
      [ Transfer Bank ]
atau
      [ QRIS ]

Halaman Transfer
Transfer ke Bank BCA 1234567890 a.n. Yayasan ...
--------------------------
Setelah transfer, silakan klik tombol di bawah.
[ Saya Sudah Transfer ]

Bisa juga ditambah tombol:

Download Nomor Rekening

Halaman QRIS
Menampilkan gambar QRIS.
===========================
Silakan scan QRIS berikut.
      [gambar QRIS]
===========================
[ Saya Sudah Membayar ]

Halaman Terima Kasih
=================================
Terima kasih.
Kiranya Tuhan memberkati setiap persembahan kasih Anda.

---------------------------------

"Allah mengasihi orang yang memberi dengan sukacita."
2 Korintus 9:7

=================================

Struktur database
Tabel Donatur
id
nama
sapaan
wa
email
domisili
tanggal

Tabel Donasi
id
donatur_id
program
nominal

Dengan desain ini, jika nanti jumlah program bertambah (misalnya menjadi 20 program), Anda tidak perlu mengubah struktur database.

Struktur direktori website
donasi/

index.php

proses.php

pilih_metode.php

transfer.php

qris.php

terima_kasih.php

config.php

database.php

send_email.php

assets/

css/

img/

logo.png

qris.png

vendor/

PHPMailer/

Fitur yang saya sarankan ditambahkan
Karena ini website donasi resmi, saya menyarankan beberapa fitur tambahan yang sangat bermanfaat:
Validasi nomor WhatsApp dan email.
Nomor donasi otomatis (misalnya DON-20260717-000123).
Penyimpanan data ke MariaDB selain pengiriman email, sehingga ada arsip jika email terlambat atau gagal.
Halaman admin sederhana untuk melihat riwayat donasi.
Tombol ekspor ke Excel.
Desain responsif agar nyaman digunakan di ponsel (yang kemungkinan besar akan menjadi perangkat utama para donatur).
Perlindungan dasar terhadap spam (misalnya CSRF token dan validasi input).

Menurut saya, website ini dapat dibuat tetap ringan namun cukup profesional dan mudah dikembangkan di masa depan. Saya juga dapat membantu membuatnya secara bertahap, mulai dari database, halaman demi halaman, hingga siap dipasang di server Ubuntu Anda.
Tahap 1 - Struktur Direktori
Jangan membuat file PHP dulu.
Saya ingin memastikan struktur direktori sudah benar terlebih dahulu.
Memastikan Direktori
Silakan lakukan langkah-langkah di atas, kemudian kirimkan hasil dari:
tree /var/www/html/lembaga-pelayanan-gereja-donation-portal
Setelah itu kita akan membuat file pertama, yaitu:
config/database.php

yang berfungsi sebagai pusat koneksi ke database MariaDB. Dari sana, semua halaman PHP akan menggunakan koneksi yang sama sehingga kode tetap rapi dan mudah dipelihara.

lembaga@gereja-B150M-DS3H:/var/www/html/lembaga-pelayanan-gereja-donation-portal$ tree /var/www/html/lembaga-pelayanan-donation-portal /var/www/html/lembaga-pelayanan-donation-portal ├── app ├── assets │   ├── css │   ├── images │   └── js ├── config ├── public └── storage 8 directories, 0 files lembaga@gereja-B150M-DS3H:/var/www/html/lembaga-pelayanan-donation-portal$

Bagus sekali. 👍
Hasilnya sudah sesuai dengan yang kita rencanakan.
lembaga-pelayanan-gereja-donation-portal
├── app
├── assets
│   ├── css
│   ├── images
│   └── js
├── config
├── public
└── storage
Ini akan menjadi fondasi proyek Lembaga Pelayanan-Gereja Donation Portal.

Tahap 2.2 - Membuat Koneksi Database
Sekarang kita akan membuat file pertama.
Masuk ke direktori config:
cd /var/www/html/lembaga-pelayanan-gereja-donation-portal/config
Kemudian buat file:
nano database.php
Isikan kode berikut:
<?php

$host     = "localhost";
$dbname   = "para_donation";
$username = "root";
$password = "";      // Ganti jika MariaDB Anda menggunakan password

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Koneksi database gagal : " . $e->getMessage());

}
Simpan:
Ctrl + O
Enter
Ctrl + X

Mengapa memakai PDO?
PDO→ PHP Data Objects untuk mengoneksi MariaDB ke PHP.

Saya sengaja memilih PDO daripada mysqli karena:
lebih aman (mudah menggunakan prepared statement),
mudah jika suatu hari ingin berpindah ke PostgreSQL,
lebih modern,
cocok untuk aplikasi yang akan berkembang.

Tahap 2.3 - Menguji Koneksi
Sekarang masuk ke direktori public:
cd ../public
Buat file:
nano test_database.php
Isi:
<?php

require_once "../config/database.php";

echo "<h2>Koneksi ke database berhasil.</h2>";
Simpan.

Uji di Browser
Buka:
http://IP-SERVER/lembaga-pelayanan-gereja-donation-portal/public/test_database.php
Jika server dijalankan di komputer yang sama:
http://localhost/lembaga-pelayanan-gereja-donation-portal/public/test_database.php
atau
http://127.0.0.1/lembaga-pelayanan-gereja-donation-portal/public/test_database.php

Hasil yang diharapkan
Jika berhasil, browser akan menampilkan:
Koneksi ke database berhasil.
Jika muncul pesan seperti:
Koneksi database gagal :
Access denied...
berarti hanya perlu menyesuaikan username atau password MariaDB.

Tujuan Membuat test_database.php
File ini hanya untuk pengujian awal. Setelah kita yakin koneksi berfungsi, file tersebut akan kita hapus. Dengan begitu, aplikasi yang nantinya dipublikasikan tidak menyisakan halaman uji yang tidak diperlukan.

Silakan:
Buat config/database.php.
Buat public/test_database.php.
Buka http://localhost/lembaga-pelayanan-gereja-donation-portal/public/test_database.php.
Beri tahu saya hasilnya.
Kalau koneksi berhasil, kita akan langsung membuat halaman utama index.php dengan tampilan awal Lembaga Pelayanan-Gereja Donation Portal. Saya memperkirakan setelah tahap itu, Anda sudah bisa melihat website pertama kita berjalan di browser.
Pesan Error MariaDB
Kalau koneksi berhasil, kita akan langsung membuat halaman utama index.php dengan tampilan awal Lembaga Pelayanan-Gereja Donation Portal. Saya memperkirakan setelah tahap itu, Anda sudah bisa melihat website pertama kita berjalan di browser.
Bagus, justru ini langkah yang penting. Error ini bukan karena PHP atau PDO, melainkan karena MariaDB menolak login sebagai root.
Pesan yang muncul adalah:
SQLSTATE[HY000] [1698]
Access denied for user 'root'@'localhost'
Di Ubuntu, ini sangat umum terjadi. Biasanya user root MariaDB menggunakan unix_socket authentication, sehingga:
sudo mariadb → ✅ bisa login
PHP → ❌ tidak bisa login sebagai root
Jadi, jangan mengubah konfigurasi root. Lebih baik kita membuat user database khusus untuk aplikasi. Ini juga merupakan praktik keamanan yang baik.

Bagus, kita semakin dekat. Error ini berbeda dari sebelumnya.
Sekarang pesannya:
Access denied for user 'para_app'@'localhost' (using password: YES)
Artinya:
✅ PHP sudah berhasil mencoba login menggunakan user para_app.
❌ Tetapi MariaDB menolak username/password tersebut.
Ini biasanya disebabkan oleh salah satu dari tiga hal:
Password di database.php tidak sama dengan password saat CREATE USER.
User para_app belum benar-benar dibuat.
Hak akses (GRANT) belum diberikan atau belum diterapkan.
Mari kita cek satu per satu.
Langkah 1 - Masuk ke MariaDB
sudo mariadb
Langkah 2 - Periksa apakah user ada
Jalankan:
SELECT User, Host
FROM mysql.user
WHERE User='para_app';
Kirimkan hasilnya kepada saya.

Langkah 3 - Jika user ada, reset password
Saya sarankan kita tidak menebak password. Jalankan saja:
ALTER USER 'para_app'@'localhost'
IDENTIFIED BY '1@3$5^';
Lalu:
GRANT ALL PRIVILEGES
ON para_donation.*
TO 'para_app'@'localhost';
FLUSH PRIVILEGES;
Kemudian coba login menggunakan user tersebut langsung dari terminal:
mysql -u para_app -p
Masukkan password:
1@3$5^
Kalau berhasil masuk dan prompt berubah menjadi:
MariaDB [(none)]>
berarti user dan password sudah benar. Setelah itu database.php juga pasti bisa terhubung.

Yang saya perlukan dari Anda
Tolong kirimkan dua hal:
Hasil dari:
SELECT User, Host
FROM mysql.user
WHERE User='para_app';
Apakah perintah berikut berhasil atau gagal?
mysql -u para_app -p
Dari dua informasi itu saya bisa memastikan apakah masalahnya ada pada user MariaDB atau hanya pada konfigurasi database.php.
perintah berhasil
Bagus, itu kabar baik. 🎉
Kalau perintah:
mysql -u para_app -p
berhasil login, berarti:
✅ User para_app sudah benar.
✅ Password yang Anda masukkan benar.
✅ Hak akses MariaDB sudah benar.
Artinya, masalahnya tinggal di file config/database.php.
Mari kita periksa.
Tolong kirimkan isi file config/database.php
Di terminal, jalankan:
cat /var/www/html/lembaga-pelayanan-gereja-donation-portal/config/database.php
Lalu salin hasilnya ke sini.

Sementara itu, saya ingin Anda memastikan isinya seperti ini:
<?php

$host     = "localhost";
$dbname   = "para_donation";
$username = "para_app";
$password = "1@3$5^";   // sesuaikan dengan password yang Anda buat

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {

    die("Koneksi database gagal : " . $e->getMessage());

}

Satu kemungkinan lagi
Jika isi database.php sudah benar, kemungkinan berikutnya adalah password mengandung karakter khusus yang berbeda dari yang diketik saat membuat user.
Untuk memastikan, kita bisa menggunakan password yang sederhana terlebih dahulu (khusus untuk tahap pengembangan lokal).
Misalnya di MariaDB:
ALTER USER 'para_app'@'localhost'
IDENTIFIED BY 'para123';
FLUSH PRIVILEGES;
Lalu di database.php:
$username = "para_app";
$password = "para123";
Jika dengan password sederhana ini koneksi berhasil, berarti sebelumnya hanya ada ketidaksesuaian password yang digunakan.
Tolong kirimkan isi database.php terlebih dahulu. Saya akan memeriksanya baris demi baris.
$ cat /var/www/html/lembaga-pelayanan-gereja-donation-portal/config/database.php <?php $host = "localhost"; $dbname = "para_donation"; $username = "para_app"; $password = "1@3$5"; // Ganti jika MariaDB Anda menggunakan password try { $pdo = new PDO( "mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password ); $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); } catch (PDOException $e) { die("Koneksi database gagal : " . $e->getMessage()); } lembaga@gereja-B150M-DS3H:/var/www/html/lembaga-pelayanan-gereja-donation-portal/config$
Terima kasih. Saya langsung melihat kemungkinan penyebabnya.
Di database.php Anda tertulis:

Terima kasih sudah berhasil.
Selamat! 🎉🎉
Saya ikut senang melihat hasilnya.
Dari gambar yang Anda kirim, saya melihat:
Koneksi ke database berhasil.
Artinya seluruh fondasi proyek sudah bekerja dengan baik.
✅ Ubuntu Server
 ✅ Apache
 ✅ PHP
 ✅ MariaDB
 ✅ PDO
 ✅ User database para_app
 ✅ Struktur proyek
 ✅ Koneksi aplikasi ke database
Ini adalah pencapaian yang penting. Mulai dari titik ini, kita tidak lagi mengurusi konfigurasi server, tetapi mulai membangun fitur aplikasi.

Kebiasaan Kerja
Mulai sekarang, setiap tahap akan memiliki target yang jelas.
Misalnya:
Tahap
Status
Persiapan Server
✅
Database
✅
Struktur direktori
✅
Koneksi Database
✅
Halaman Utama
⏳
Form Donasi
⏳
Email
⏳
Transfer
⏳
QRIS
⏳
Halaman Terima Kasih
⏳

Dengan begitu kita selalu tahu posisi proyek.

Tujuan awal proyek:
"Membantu donatur mengirim informasi donasi dengan mudah, sehingga admin tidak perlu menghubungi donatur lagi untuk menanyakan alokasinya."
Maka fungsi jauh lebih penting daripada tampilan.
Saya mengusulkan kita memakai prinsip berikut:
Function First, Beauty Later
Artinya:
Semua fungsi berjalan dengan baik.
Semua data tersimpan dengan benar.
Email terkirim dengan benar.
Setelah aplikasi stabil, baru kita mempercantik tampilannya.
Dengan cara ini, kita tidak akan menghabiskan waktu untuk desain di awal.

Tidak memakai template
Artinya kita tidak perlu dulu:
header.php
footer.php
Bootstrap
JavaScript yang rumit
Framework CSS
Cukup memakai HTML biasa.
Misalnya halaman pertama:
<!DOCTYPE html>

<html>

<head>

<title>Lembaga Pelayanan-Gereja Donation Portal</title>

</head>

<body>

<h1>Lembaga Pelayanan-Gereja Donation Portal</h1>

<p>
Selamat datang.
</p>

<a href="donasi.php">
Mulai Donasi
</a>

</body>

</html>
Sangat sederhana.
Tetapi sudah bisa dipakai.

Saya bahkan mengusulkan lebih sederhana lagi
Untuk versi 1.0, saya ingin seluruh website hanya terdiri dari sekitar 8 file PHP.
public/

index.php
donasi.php
konfirmasi.php
transfer.php
qris.php
terima_kasih.php

config/
database.php

app/
proses_donasi.php
Tidak lebih. Saya rasa ini sudah cukup.

Target Versi 1.0
Saya ingin menetapkan target yang realistis.
Versi pertama nanti sudah bisa:
✅ Mengisi data donatur
✅ Memilih alokasi donasi
✅ Menghitung total
✅ Menyimpan ke MariaDB
✅ Mengirim email ke admin
✅ Memilih Transfer atau QRIS
✅ Menampilkan ucapan terima kasih
Selesai.
Belum ada:
Login Admin
Dashboard
Bootstrap
Laporan Excel
Receipt otomatis
Responsive design yang rumit
Semuanya bisa ditambahkan pada versi berikutnya jika memang diperlukan.

Langkah berikutnya
Menurut saya, kita langsung membuat public/index.php.
Halaman ini hanya berisi:
Lembaga Pelayanan-Gereja

Donation Portal

Selamat datang.

Website ini membantu Anda menyampaikan informasi donasi kepada Lembaga Pelayanan-Gereja. Setelah mengisi formulir, Anda dapat memilih metode pembayaran melalui transfer bank atau QRIS.

[ Mulai Donasi ]
Halaman ini bisa selesai dalam beberapa menit, lalu kita langsung masuk ke inti proyek: membuat formulir donasi (donasi.php).
Baik. Kita akan membuat website yang berfungsi dulu, tanpa memikirkan desain. Fokus kita adalah agar alur donasi berjalan dengan benar.
Saya juga ingin menjaga satu prinsip selama proyek ini:
Satu file = satu fungsi.
Dengan begitu nanti jika ada kesalahan, kita mudah menemukannya.

Tahap 3 - Membuat Halaman Utama
Masuk ke direktori:
cd /var/www/html/lembaga-pelayanan-gereja-donation-portal/public
Buat file:
nano index.php
Isi dengan kode berikut:
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lembaga Pelayanan-Gereja Donation Portal</title>
</head>

<body>

    <h1>Lembaga Pelayanan-Gereja Donation Portal</h1>

    <hr>

    <p>
        Selamat datang.
    </p>

    <p>
        Website ini membantu Anda menyampaikan informasi donasi kepada
        Lembaga Pelayanan-Gereja.
    </p>

    <p>
        Setelah mengisi formulir, Anda dapat memilih pembayaran melalui
        <strong>Transfer Bank</strong> atau <strong>QRIS</strong>.
    </p>

    <hr>

    <a href="donasi.php">
        <button>Mulai Donasi</button>
    </a>

</body>

</html>
Simpan:
Ctrl + O
Enter
Ctrl + X

Membuat halaman kedua
Sekarang buat:
nano donasi.php
Isi sementara:
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Donasi</title>
</head>

<body>

<h2>Form Donasi</h2>

<p>
Halaman ini sedang kita bangun.
</p>

<p>
Nanti di sinilah donatur akan mengisi data diri dan alokasi donasi.
</p>

<p>
<a href="index.php">Kembali ke Halaman Utama</a>
</p>

</body>

</html>

Uji di browser
Buka:
http://192.168.100.100/lembaga-pelayanan-gereja-donation-portal/public/
Yang diharapkan:
Lembaga Pelayanan-Gereja Donation Portal

Selamat datang.

Website ini membantu Anda ...

[ Mulai Donasi ]
Saat tombol Mulai Donasi diklik, akan tampil:
Form Donasi

Halaman ini sedang kita bangun.
Alasan membuat donasi.php kosong?
Karena pada tahap berikutnya kita akan merancang formulir dengan hati-hati.
Berdasarkan diskusi kita sebelumnya, saya membayangkan isi formulir akan seperti ini:
DATA DONATUR

Sapaan
( ) Bapak
( ) Ibu
( ) Saudara
( ) Saudari

Nama Lengkap
______________________

Domisili
______________________

E-mail
______________________

-------------------------------------

ALOKASI DONASI

+----------------------------------------+------------+
| Tujuan Donasi                          | Nominal    |
+----------------------------------------+------------+
| ________________________________       | __________ |
| ________________________________       | __________ |
| ________________________________       | __________ |
| ________________________________       | __________ |
| ________________________________       | __________ |
+----------------------------------------+------------+

                     TOTAL : Rp __________

                [ Lanjut ]
Perhatikan bahwa kolom "Tujuan Donasi" adalah teks yang diisi sendiri oleh donatur, sesuai keputusan kita sebelumnya. Jadi kita tidak menggunakan daftar program yang tetap, karena donatur dapat menuliskan sendiri alokasi donasinya (misalnya nama proyek atau pelayanan tertentu).
Kalau tampilan index.php dan donasi.php sudah berjalan, pada langkah berikutnya kita akan mulai membuat formulir yang benar-benar dapat menyimpan data ke database MariaDB. Saya akan memandu Anda langkah demi langkah agar setiap bagian bisa diuji sebelum kita melanjutkan ke bagian berikutnya.

Karena halaman ini berada dalam website yang lebih umum (tidak berdiri sendiri), saya usul tampilannya lebih sederhana, apakah bisa?


Saya setuju dengan mockup yang Anda buat. Bahkan menurut saya lebih baik daripada rancangan awal saya, karena:
Donatur langsung melihat formulir tanpa klik tambahan.
Sangat sedikit teks.
Fokus langsung ke pengisian data.
Mudah dipasang sebagai salah satu halaman di website Lembaga Pelayanan-Gereja yang sudah ada.
Saya usulkan kita membuat versi pertama yang tampilannya hampir sama dengan gambar. Kita belum menyimpan ke database dulu, hanya memastikan tampilan sudah sesuai.
Buat file public/index.php dengan isi berikut.
<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Lembaga Pelayanan-Gereja Donation Portal</title>

<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    background:#4f7f32;
    color:white;
}

.container{
    width:760px;
    margin:20px auto;
}

.header{
    display:flex;
    align-items:flex-start;
    margin-bottom:25px;
}

.logo{
    width:60px;
    margin-right:18px;
}

.title{
    font-size:28px;
    font-weight:bold;
    margin-bottom:8px;
}

.subtitle{
    font-size:20px;
    line-height:1.5;
}

table{
    border-collapse:collapse;
}

.form td{
    padding:5px;
}

.form input{
    width:260px;
    height:28px;
    font-size:16px;
}

.alokasi{
    margin-top:25px;
}

.alokasi th{
    background:#d9d9d9;
    color:black;
    border:1px solid black;
    padding:8px;
}

.alokasi td{
    border:1px solid black;
}

.alokasi input[type=text]{
    width:340px;
    height:28px;
    border:none;
    padding-left:8px;
}

.alokasi input[type=number]{
    width:180px;
    height:28px;
    border:none;
    text-align:right;
    padding-right:8px;
}

.total{
    margin-top:12px;
    font-size:24px;
    text-align:right;
}

.button{
    margin-top:30px;
    text-align:center;
}

button{
    font-size:18px;
    padding:10px 35px;
}

</style>

</head>

<body>

<div class="container">

<div class="header">

<img src="../assets/images/logo.png"
class="logo">

<div>

<div class="title">
Lembaga Pelayanan-Gereja Donation Portal
</div>

<div class="subtitle">
Laman ini membantu Anda menyampaikan
informasi donasi kepada admin Lembaga Pelayanan-Gereja.
<br><br>

Setelah mengisi formulir, Anda dapat memilih
pembayaran melalui
<b>Transfer Bank</b>
atau
<b>QRIS</b>.
</div>

</div>

</div>


<table class="form">

<tr>
<td>Nama</td>
<td><input type="text" name="nama"></td>
</tr>

<tr>
<td>E-mail</td>
<td><input type="email" name="email"></td>
</tr>

<tr>
<td>Kota/Kabupaten Domisili</td>
<td><input type="text" name="domisili"></td>
</tr>

</table>


<h2>Persembahan</h2>

<table class="alokasi">

<tr>
<th width="40">No</th>
<th width="360">Alokasi</th>
<th width="200">Jumlah</th>
</tr>

<?php
for($i=1;$i<=4;$i++){
?>
<tr>

<td align="center"><?php echo $i;?></td>

<td>
<input
type="text"
name="alokasi[]">
</td>

<td>
<input
type="number"
name="jumlah[]"
value="0">
</td>

</tr>

<?php
}
?>

</table>

<div class="total">

TOTAL :
Rp 0

</div>

<div class="button">

<button type="submit">
Lanjut
</button>

</div>

</div>

</body>

</html>
Dua Perubahan Kecil
Dari mockup Anda, saya ingin menambahkan dua hal:
Gunakan logo asli Lembaga Pelayanan-Gereja, simpan sebagai:


assets/images/logo.png

Gunakan elemen <form> sejak sekarang, meskipun tombol Lanjut belum melakukan apa-apa. Nanti kita tinggal menambahkan action dan method tanpa mengubah struktur halaman.

Contohnya:
<form action="proses_donasi.php" method="post">

    <!-- seluruh isi formulir -->

</form>
Untuk tahap ini, action bisa dikosongkan dulu:
<form method="post">

Saya juga mempunyai satu usulan yang menurut saya akan membuat aplikasi terasa lebih profesional, tetapi hanya membutuhkan sekitar 15 baris JavaScript:
Total donasi dihitung otomatis saat donatur mengetik nominal.
Misalnya donatur mengisi:
7.000.000
250.000
1.500.000
89
maka bagian bawah langsung berubah menjadi:
TOTAL : Rp 8.750.089
Tanpa perlu menekan tombol apa pun. Ini sangat membantu donatur untuk memastikan jumlah yang mereka masukkan sudah benar, dan implementasinya tetap sederhana tanpa memerlukan framework apa pun.

Sekarang kita mulai menambahkan JavaScript sederhana agar TOTAL dihitung otomatis. Ini akan menjadi satu-satunya JavaScript yang kita gunakan pada tahap awal.
Saya juga ingin sedikit memperbaiki struktur HTML supaya lebih sesuai dengan standar.

Langkah 1
Tambahkan tag <form>.
Setelah <div class="container">, tambahkan:
<form method="post">
Lalu tepat sebelum:
</div>

</body>
tambahkan:
</form>

Langkah 2
Ubah input jumlah menjadi seperti berikut.
Dari:
<input
type="number"
name="jumlah[]"
value="0">
menjadi
<input
type="number"
name="jumlah[]"
class="jumlah"
min="0"
step="1"
value="">
Perhatikan saya menambahkan:
class="jumlah"
karena JavaScript nanti akan mencari semua kotak jumlah berdasarkan class tersebut.

Langkah 3
Bagian TOTAL sekarang masih berupa:
<div class="total">

TOTAL :
Rp 0

</div>
Ubah menjadi:
<div class="total">

TOTAL :
Rp
<span id="grandTotal">0</span>

</div>
Nanti JavaScript hanya mengubah isi <span>.

Langkah 4
Tepat sebelum
</body>
tambahkan script berikut.
<script>

function hitungTotal(){

    let total = 0;

    document.querySelectorAll(".jumlah").forEach(function(item){

        let nilai = parseFloat(item.value);

        if(!isNaN(nilai))
            total += nilai;

    });

    document.getElementById("grandTotal").innerHTML =
        total.toLocaleString("id-ID");

}

document.querySelectorAll(".jumlah").forEach(function(item){

    item.addEventListener("input", hitungTotal);

});

</script>

Hasilnya
Misalnya donatur mengetik:
Jumlah
7000000
250000
1500000
89

Bagian bawah otomatis berubah menjadi:
TOTAL :
Rp 8.750.089
Tidak perlu menekan tombol apa pun.

Pilih JavaScript Biasa
Karena proyek ini memang kita buat sederhana.
Saya sengaja tidak menggunakan:
jQuery
React
Vue
Bootstrap
library lain
Website tetap ringan dan cepat dimuat.
