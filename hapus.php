<?php
session_start();
if (!isset($_SESSION['id'])) { header("Location: login.php"); exit; }
require "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $stmt = mysqli_prepare($koneksi, "DELETE FROM $TABEL WHERE no_id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}
header("Location: kendaraan.php?pesan=" . urlencode("Data berhasil dihapus"));