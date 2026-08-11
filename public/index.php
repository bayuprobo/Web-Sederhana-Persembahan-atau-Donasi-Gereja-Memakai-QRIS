<?php
/*
=====================================================
Lembaga Pelayanan-Gereja Donation Portal
Version : 0.1
File    : index.php
Status  : Stable (Frozen)
Created : 18 Juli 2026
=====================================================
*/
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Lembaga Pelayanan-Gereja Donation Portal</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container">

<form action="../app/proses_donasi.php" method="post">

    <h1>lembaga Pelayanan-Gereja Donation Portal</h1>

    <p>
        Laman ini membantu Anda menyampaikan informasi
        donasi kepada admin Para Navigator.
    </p>

    <p>
        Setelah mengisi formulir,
        Anda dapat memilih pembayaran melalui
        <b>Transfer Bank</b> atau <b>QRIS</b>.
    </p>

    <hr>

    <h2>Data Donatur</h2>

    <table class="form">

        <tr>
            <td>Nama Lengkap *</td>
            <td>
                <input
                    type="text"
                    name="nama"
                    required>
            </td>
        </tr>

        <tr>
            <td>Alamat E-mail *</td>
            <td>
                <input
                    type="email"
                    name="email"
                    required>
            </td>
        </tr>

        <tr>
            <td>Kota/Kabupaten Domisili *</td>
            <td>
                <input
                    type="text"
                    name="domisili"
                    required>
            </td>
        </tr>

    </table>

    <hr>

    <h2>Perincian Donasi</h2>

    <table class="alokasi">

        <tr>
            <th>No</th>
            <th>Tujuan  Donasi</th>
            <th>Jumlah (Rp)</th>
        </tr>

<?php
for ($i = 1; $i <= 5; $i++) {
?>

<tr>

<td class="nomor">
<?= $i ?>
</td>

<td>

<input
type="text"
name="alokasi[]">

</td>

<td>

<input
type="number"
name="jumlah[]"
class="jumlah"
min="0"
step="1">

</td>

</tr>

<?php
}
?>

    </table>

    <div class="total">

        Total Donasi:
        Rp
        <span id="grandTotal">0</span>

    </div>

    <div class="tombol">

        <button type="submit">

            Pilih Metode Pembayaran

        </button>

    </div>

</form>

</div>

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

</body>

</html>
