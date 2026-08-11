# Web-Sederhana-Persembahan-atau-Donasi-Kristen-Memakai-QRIS
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
