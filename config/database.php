<?php

$host     = "localhost";
$dbname   = "para_donation";
$username = "para_app";
$password = "1@3$5^";      // Ganti jika MariaDB Anda menggunakan password

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
