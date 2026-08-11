<?php
/*
=========================================================
Lembaga Pelayanan-Gereja Donation Portal
Version : 1.0-dev
File    : pilih_pembayaran.php
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

<title>Pilih Metode Pembayaran</title>

<link rel="stylesheet" href="../assets/css/app.css">

</head>

<body>

<div class="container">

<h1>Lembaga Pelayanan-Gereja Donation Portal</h1>

<p>

Terima kasih.

</p>

<p>

Data donasi Anda telah kami terima.

</p>

<p>

Silakan memilih metode pembayaran berikut.

</p>

<div class="button-group">

<a class="button"
href="transfer.php?id=<?= $id ?>">

Transfer Bank

</a>

<a class="button"
href="qris.php?id=<?= $id ?>">

QRIS

</a>

</div>

</div>

</body>

</html>
