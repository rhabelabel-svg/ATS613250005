<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>
<p>Selamat datang, <?= $_SESSION['nama'] ?> (<?= $_SESSION['email'] ?>)
   | <a href="logout.php">Logout</a></p>