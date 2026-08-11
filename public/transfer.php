<?php
/*
=========================================================
Lembaga Pelayanan-Gereja Donation Portal
Version : 1.0-dev
File    : transfer.php
Status  : Development
Created : 29 Juli 2026
=========================================================
*/


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../config/database.php";
require_once "../app/kirim_email.php";

$id = $_SESSION['donatur_id'] ?? 0;

if ($id > 0) {

    $stmt = $pdo->prepare("
        UPDATE donatur
        SET metode_pembayaran='Transfer'
        WHERE id=?
    ");

    $stmt->execute([$id]);

}

kirimEmailDonasi(

    $_SESSION['donatur_id'],

    $_SESSION['waktu_email'],

    "Transfer",

    $_SESSION['nama'],

    $_SESSION['email'],

    $_SESSION['domisili'],

    $_SESSION['alokasi'],

    $_SESSION['jumlah'],

    $_SESSION['total']

);

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

<title>Transfer Bank</title>

<link rel="stylesheet" href="../assets/css/app.css">

</head>

<body>

<div class="container">

<h1>Transfer Bank</h1>

<p>

Silakan melakukan transfer ke rekening berikut.

</p>

<table>

<tr>

<th>Bank</th>

<td>Bank Central Asia (BCA)</td>

</tr>

<tr>

<th>Nomor Rekening</th>

<td>1231986432</td>

</tr>

<tr>

<th>Atas Nama</th>

<td>Lembaga Pelayanan-Gereja di Indonesia</td>

</tr>

</table>

<br>

<p>

Setelah dana diterima oleh Lembaga Pelayanan-Gereja,
receipt resmi akan dikirim ke alamat e-mail Anda.

</p>

<br>

<p style="text-align:center;">

<a
class="button"
href="terima_kasih.php?id=<?= $id ?>"
>

Saya Sudah Melakukan Transfer

</a>

</p>

</div>

</body>

</html>
