<?php
$koneksi = mysqli_connect("localhost", "root", "", "ats613250005");
if (!$koneksi) { die("Koneksi gagal: " . mysqli_connect_error()); }
$TABEL = "mobil_005";
$JENIS = ['Sedan', 'Pickup', 'Truk', 'Bemo'];