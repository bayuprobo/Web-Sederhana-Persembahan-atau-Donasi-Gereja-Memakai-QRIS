<?php
/*
=========================================================
Lembaga Pelayanan-Gereja Donation Portal
Version : 1.0-dev
File    : kirim_email.php
Status  : Development
Created : 30 Juli 2026
=========================================================
*/

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/mail.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function kirimEmailDonasi(
    $donaturId,
    $waktuEmail,
    $metodePembayaran,
    $nama,
    $email,
    $domisili,
    $alokasi,
    $jumlah,
    $total
)
{
    global $config;

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();

        $mail->Host = $config['host'];

        $mail->SMTPAuth = true;

        $mail->Username = $config['username'];

        $mail->Password = $config['password'];

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $mail->Port = $config['port'];

        $mail->CharSet = "UTF-8";

        $mail->setFrom(
            $config['from_email'],
            $config['from_name']
        );

        $mail->addAddress(
            $config['admin_email']
        );

        $mail->Subject = "Donasi Baru - Para Navigator Donation Portal";

        $isi = "";

        $isi .= "Donasi Baru\n";
        $isi .= "=====================================\n\n";

        $isi .= "ID Donatur : $donaturId\n";
        $isi .= "Waktu     : $waktuEmail\n\n";
	$isi .= "Metode Pembayaran : $metodePembayaran\n\n";
        $isi .= "Nama      : $nama\n";
        $isi .= "E-mail    : $email\n";
        $isi .= "Domisili  : $domisili\n\n";

        $isi .= "Perincian Donasi\n";
        $isi .= "-------------------------------------\n";

        for ($i = 0; $i < count($alokasi); $i++) {

            $tujuan = trim($alokasi[$i]);

            $nominal = isset($jumlah[$i])
                ? (int)$jumlah[$i]
                : 0;

            if ($tujuan == '' && $nominal == 0) {
                continue;
            }

            $isi .= ($i + 1) . ". ";
            $isi .= $tujuan;
            $isi .= " : Rp ";
            $isi .= number_format($nominal, 0, ",", ".");
            $isi .= "\n";
        }

        $isi .= "-------------------------------------\n";

        $isi .= "TOTAL : Rp ";

        $isi .= number_format(
            $total,
            0,
            ",",
            "."
        );

        $isi .= "\n\n";

        $isi .= "Email ini dibuat otomatis oleh\n";
        $isi .= "Lembaga Pelayanan-Gereja Donation Portal.";

        $mail->Body = $isi;

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;

    }
}
