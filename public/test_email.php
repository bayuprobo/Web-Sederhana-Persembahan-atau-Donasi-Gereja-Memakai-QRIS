<?php
/*
=========================================================
Lembaga Pelayanan-Gereja Donation Portal
File    : test_email.php
Status  : Development
=========================================================
*/

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/mail.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();

    $mail->Host = $config['host'];

    $mail->SMTPAuth = true;

    $mail->Username = $config['username'];

    $mail->Password = $config['password'];

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

    $mail->Port = $config['port'];

    $mail->CharSet = 'UTF-8';

    $mail->setFrom(
        $config['from_email'],
        $config['from_name']
    );

    $mail->addAddress(
        $config['admin_email']
    );

    $mail->Subject = 'Test PHPMailer';

    $mail->Body =
        "Selamat!\n\n" .
        "PHPMailer berhasil terhubung ke SMTP Lembaga Pelayanan-Gereja.\n\n" .
        "Email ini dikirim sebagai pengujian.";

    $mail->send();

    echo "<h2>Email berhasil dikirim.</h2>";

}
catch (Exception $e) {

    echo "<h2>Gagal mengirim email.</h2>";

    echo "<pre>";

    echo $mail->ErrorInfo;

    echo "</pre>";

}
