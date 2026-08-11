<?php
/*
=========================================================
Lembaga Pelayanan-Gereja Donation Portal
Version : 1.0-dev
File    : terima_kasih.php
Status  : Development
Created : 29 Juli 2026
=========================================================
*/

$id = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

if ($id <= 0) {
    die("ID Donatur tidak valid.");
}
?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Terima Kasih</title>

<link rel="stylesheet" href="../assets/css/app.css">

</head>

<body>

<div class="container">

<h1>Terima Kasih</h1>

<p>

Terima kasih atas dukungan Anda kepada pelayanan
Lembaga Pelayanan-Gereja di Indonesia.

</p>

<p>

Data donasi Anda telah kami terima.

</p>

<p>

Setelah dana diterima pada rekening atau QRIS resmi
Lembaga Pelayanan-Gereja di Indonesia, receipt donasi akan
dikirim ke alamat e-mail yang telah Anda daftarkan.

</p>

<hr>

<h2>2 Korintus 9:7</h2>

<p style="font-style:italic;">

"Hendaklah masing-masing memberikan menurut
kerelaan hatinya, jangan dengan sedih hati atau
karena paksaan, sebab Allah mengasihi orang yang
memberi dengan sukacita."

</p>

<br>

<p>

Tuhan memberkati.

</p>

</div>

</body>

</html>
