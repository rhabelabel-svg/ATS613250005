<?php
session_start();
if (!isset($_SESSION['id'])) { header("Location: login.php"); exit; }
require_once __DIR__ . "/koneksi.php";
$judul = 'Tambah Kendaraan';

$d = ['nomor_kendaraan'=>'', 'jenis_kendaraan'=>'', 'pemilik'=>'', 'tahun_pembuatan'=>''];

if (isset($_POST['simpan'])) {
    $stmt = mysqli_prepare($koneksi,
      "INSERT INTO $TABEL (nomor_kendaraan, jenis_kendaraan, pemilik, tahun_pembuatan) VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "ssss",
      $_POST['nomor_kendaraan'], $_POST['jenis_kendaraan'],
      $_POST['pemilik'], $_POST['tahun_pembuatan']);
    mysqli_stmt_execute($stmt);
    header("Location: kendaraan.php?pesan=" . urlencode("Data berhasil ditambahkan"));
    exit;
}
?>
<?php require __DIR__ . "/header.php"; ?>
<div class="row justify-content-center">
  <div class="col-md-9 col-lg-7 col-xl-6">
    <div class="mb-4">
      <h1 class="h3 page-heading mb-1">Tambah Kendaraan</h1>
      <p class="text-secondary mb-0">Lengkapi informasi kendaraan pada formulir berikut.</p>
    </div>
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <form method="post">
          <?php include __DIR__ . "/form.php"; ?>
          <div class="d-flex gap-2 pt-2">
            <button type="submit" name="simpan" class="btn btn-primary">
              <i class="bi bi-check-lg me-1"></i>Simpan Data
            </button>
            <a href="kendaraan.php" class="btn btn-outline-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . "/footer_layout.php"; ?>