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

Detailnya dapat dibaca lengkap di https://docs.google.com/document/d/1CSYwtV334HBOe09ihHrqQ0wpcY7aA1ZoBoKzrcMgDTk/edit?usp=sharing
