<?php
$servername = "localhost";
$username = "root";   // ganti sesuai user kamu
$password = "";       // ganti sesuai password kamu
$dbname = "db_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
