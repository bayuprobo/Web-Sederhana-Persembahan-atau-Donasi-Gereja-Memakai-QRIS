<?php
/*
=========================================================
Lembaga Pelayanan-Gereja Donation Portal
Version : 1.0-dev
File    : proses_donasi.php
Status  : Development
Created : 18 Juli 2026
=========================================================
*/

// hanya menerima POST


/*
TODO:
[✓] Menerima data POST
[ ] Validasi data
[ ] Simpan donatur
[ ] Simpan detail_donasi
[ ] Kirim email
[ ] Redirect ke pilih_pembayaran.php
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Akses tidak diperbolehkan.");
}

$nama      = trim($_POST['nama'] ?? '');
$email     = trim($_POST['email'] ?? '');
$domisili  = trim($_POST['domisili'] ?? '');

$alokasi = $_POST['alokasi'] ?? [];
$jumlah  = $_POST['jumlah'] ?? [];

/*
=========================================================
VALIDASI SERVER-SIDE
=========================================================
*/

$error = [];

/* ---------- Data Donatur ---------- */

if ($nama === '') {
    $error[] = "Nama lengkap harus diisi.";
}

if ($email === '') {
    $error[] = "Alamat e-mail harus diisi.";
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = "Format alamat e-mail tidak valid.";
}

if ($domisili === '') {
    $error[] = "Kota/Kabupaten domisili harus diisi.";
}


/* ---------- Perincian Donasi ---------- */

$jumlahBaris = count($alokasi);

$adaDonasi = false;

for ($i = 0; $i < $jumlahBaris; $i++) {

    $tujuan = trim($alokasi[$i]);

    $nominal = isset($jumlah[$i])
        ? (int)$jumlah[$i]
        : 0;

    if ($tujuan === '' && $nominal === 0) {
        continue;
    }

    if ($tujuan === '' && $nominal > 0) {

        $error[] =
            "Baris " . ($i + 1) .
            ": Tujuan Donasi harus diisi.";

        continue;
    }

    if ($tujuan !== '' && $nominal <= 0) {

        $error[] =
            "Baris " . ($i + 1) .
            ": Jumlah Donasi harus lebih dari nol.";

        continue;
    }

    $adaDonasi = true;

}

if (!$adaDonasi) {

    $error[] =
        "Minimal satu Perincian Donasi harus diisi.";

}

// MENYIMPAN TIMESTAMP

date_default_timezone_set('Asia/Jakarta');
$waktuEmail = date('d F Y H:i:s') . " WIB";

/*
=========================================================
KONEKSI DATABASE
=========================================================
*/

require_once __DIR__ . '/../config/database.php';



/*
=========================================================
SIMPAN KE DATABASE
=========================================================
*/

$donaturId = 0;

if (empty($error)) {

    try {

        $pdo->beginTransaction();

        // INSERT donatur

          $sql = "
            INSERT INTO donatur
            (
                nama,
                email,
                domisili
            )
            VALUES
            (
                :nama,
                :email,
                :domisili
            )
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([

            ':nama'     => $nama,
            ':email'    => $email,
            ':domisili' => $domisili

        ]);

	$donaturId = $pdo->lastInsertId();


$total = 0;

foreach ($jumlah as $nominal) {

    $total += (int)$nominal;

}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['donatur_id'] = $donaturId;

$_SESSION['nama'] = $nama;

$_SESSION['email'] = $email;

$_SESSION['domisili'] = $domisili;

$_SESSION['alokasi'] = $alokasi;

$_SESSION['jumlah'] = $jumlah;

$_SESSION['total'] = $total;

$_SESSION['waktu_email'] = $waktuEmail;

	$donaturId = (int)$pdo->lastInsertId();

      // SIMPAN detail_donasi
/*
=========================================================
SIMPAN DETAIL DONASI
=========================================================
*/

$sql = "
    INSERT INTO detail_donasi
    (
        donatur_id,
        tujuan,
        nominal
    )
    VALUES
    (
        :donatur_id,
        :tujuan,
        :nominal
    )
";

$stmt = $pdo->prepare($sql);

for ($i = 0; $i < $jumlahBaris; $i++) {

    $tujuan = trim($alokasi[$i]);

    $nominal = isset($jumlah[$i])
        ? (int)$jumlah[$i]
        : 0;

    if ($tujuan === '' && $nominal === 0) {
        continue;
    }

    if ($tujuan === '' || $nominal <= 0) {
        continue;
    }

    $stmt->execute([

        ':donatur_id' => $donaturId,
        ':tujuan'     => $tujuan,
        ':nominal'    => $nominal

    ]);

}

        $pdo->commit();



header("Location: ../public/pilih_pembayaran.php?id=" . $donaturId);
exit;

}
    catch (PDOException $e) {

        $pdo->rollBack();

        $error[] =
            "Terjadi kesalahan database.";

    }

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<title>Debug Data Donasi</title>

<link rel="stylesheet" href="../assets/css/app.css">

</head>


<body>

<div class="container">


<?php

if (!empty($error)) {

?>

<div class="error">

<h2>Terjadi Kesalahan</h2>

<p>
Silakan perbaiki data berikut:
</p>

<ul>

<?php

foreach ($error as $pesan) {

?>

<li>

<?= htmlspecialchars($pesan) ?>

</li>

<?php

}

?>

</ul>

<p>

<a href="../public/index.php">

← Kembali ke Formulir

</a>

</p>

</div>

<?php

exit;

}

?>

<h2>Data berhasil diterima</h2>

<p>

<b>Nama :</b>

<?= htmlspecialchars($nama) ?>

</p>

<p>

<b>Email :</b>

<?= htmlspecialchars($email) ?>

</p>

<p>

<b>Domisili :</b>

<?= htmlspecialchars($domisili) ?>

</p>

<h3>Perincian Donasi</h3>

<table>

<tr>

<th>No</th>

<th>Tujuan Donasi</th>

<th>Jumlah</th>

</tr>

<?php

$total = 0;


for($i = 0; $i < $jumlahBaris;$i++){

    $tujuan = trim($alokasi[$i]);

    $nominal = isset($jumlah[$i])
            ? (int)$jumlah[$i]
            : 0;

    if ($tujuan === '' && $nominal === 0) {
    continue;
}

    $total += $nominal;

?>

<tr>

<td><?= $i+1 ?></td>

<td><?= htmlspecialchars($tujuan) ?></td>

<td class="text-right">

Rp <?= number_format($nominal,0,",",".") ?>

</td>

</tr>

<?php
}
?>

<tr>

<th colspan="2">

TOTAL

</th>

<th class="text-right">

Rp <?= number_format($total,0,",",".") ?>

</th>

</tr>

</table>

</div>
</body>

</html>
