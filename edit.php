<?php
session_start();
if (!isset($_SESSION['id'])) { header("Location: login.php"); exit; }
require_once __DIR__ . "/koneksi.php";
$judul = 'Edit Kendaraan';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if (isset($_POST['update'])) {
    $stmt = mysqli_prepare($koneksi,
      "UPDATE $TABEL SET nomor_kendaraan=?, jenis_kendaraan=?, pemilik=?, tahun_pembuatan=? WHERE no_id=?");
    mysqli_stmt_bind_param($stmt, "ssssi",
      $_POST['nomor_kendaraan'], $_POST['jenis_kendaraan'],
      $_POST['pemilik'], $_POST['tahun_pembuatan'], $id);
    mysqli_stmt_execute($stmt);
    header("Location: kendaraan.php?pesan=" . urlencode("Data berhasil diubah"));
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM $TABEL WHERE no_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$d = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$d) { header("Location: kendaraan.php"); exit; }
?>
<?php require __DIR__ . "/header.php"; ?>
<div class="row justify-content-center">
  <div class="col-md-9 col-lg-7 col-xl-6">
    <div class="mb-4">
      <h1 class="h3 page-heading mb-1">Edit Kendaraan</h1>
      <p class="text-secondary mb-0">Perbarui informasi kendaraan yang dipilih.</p>
    </div>
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <form method="post">
          <input type="hidden" name="id" value="<?= $id ?>">
          <?php include __DIR__ . "/form.php"; ?>
          <div class="d-flex gap-2 pt-2">
            <button type="submit" name="update" class="btn btn-primary">
              <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
            </button>
            <a href="kendaraan.php" class="btn btn-outline-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . "/footer_layout.php"; ?>