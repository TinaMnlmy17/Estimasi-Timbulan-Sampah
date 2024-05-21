<?php
// Informasi koneksi database
$servername = "localhost"; // Lokasi server database
$username = "estimasiregresil_tina"; // Nama pengguna database
$password = "JDN~kZSLrHWh"; // Kata sandi database
$database = "estimasiregresil_tina"; // Nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}