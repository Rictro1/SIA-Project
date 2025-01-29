<?php
$host = 'localhost';
$user = 'root';
$password_db = '';
$dbname = 'sia';

$conn = new mysqli($host, $user, $password_db, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>