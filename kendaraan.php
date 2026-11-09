<?php
$judul = 'Data Kendaraan';
require __DIR__ . "/header.php";

$cari = trim($_GET['cari'] ?? '');
$like = "%$cari%";
$stmt = mysqli_prepare($koneksi,
  "SELECT * FROM $TABEL
   WHERE nomor_kendaraan LIKE ? OR pemilik LIKE ? OR jenis_kendaraan LIKE ?
   ORDER BY no_id");
mysqli_stmt_bind_param($stmt, "sss", $like, $like, $like);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$pesan = $_GET['pesan'] ?? '';
?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
  <div>
    <h1 class="h3 page-heading mb-1">Data Kendaraan</h1>
    <p class="text-secondary mb-0">Kelola informasi kendaraan yang terdaftar.</p>
  </div>
  <a href="tambah.php" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i>Tambah Kendaraan
  </a>
</div>

<?php if ($pesan): ?>
  <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
  </div>
<?php endif; ?>

<div class="card shadow-sm mb-4">
  <div class="card-body">
    <form class="row g-2" method="get" role="search">
      <div class="col-md-8 col-lg-6">
        <label for="cari" class="visually-hidden">Cari kendaraan</label>
        <div class="input-group">
          <span class="input-group-text bg-white"><i class="bi bi-search text-secondary"></i></span>
          <input type="search" id="cari" name="cari" class="form-control"
                 placeholder="Cari nomor, pemilik, atau jenis kendaraan"
                 value="<?= htmlspecialchars($cari, ENT_QUOTES, 'UTF-8') ?>">
        </div>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary">Cari</button>
        <?php if ($cari !== ''): ?>
          <a href="kendaraan.php" class="btn btn-outline-secondary">Reset</a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-header bg-white border-0 pt-3 px-3 px-lg-4">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="h6 mb-0">Daftar Kendaraan</h2>
      <span class="badge text-bg-light"><?= mysqli_num_rows($hasil) ?> data</span>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col" class="text-secondary">No.</th>
          <th scope="col">Nomor Kendaraan</th>
          <th scope="col">Jenis</th>
          <th scope="col">Pemilik</th>
          <th scope="col">Tahun</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php $no = 1; while ($r = mysqli_fetch_assoc($hasil)): ?>
        <tr>
          <td class="text-secondary"><?= $no++ ?></td>
          <td class="fw-semibold"><?= htmlspecialchars($r['nomor_kendaraan'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><span class="badge rounded-pill text-bg-info"><?= htmlspecialchars($r['jenis_kendaraan'], ENT_QUOTES, 'UTF-8') ?></span></td>
          <td><?= htmlspecialchars($r['pemilik'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($r['tahun_pembuatan'], ENT_QUOTES, 'UTF-8') ?></td>
          <td class="text-end text-nowrap">
            <a href="edit.php?id=<?= (int)$r['no_id'] ?>" class="btn btn-sm btn-outline-primary" aria-label="Edit kendaraan">
              <i class="bi bi-pencil-square me-1"></i>Edit
            </a>
            <form action="hapus.php" method="post" class="d-inline"
                  onsubmit="return confirm('Yakin ingin menghapus data kendaraan ini?')">
              <input type="hidden" name="id" value="<?= (int)$r['no_id'] ?>">
              <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash me-1"></i>Hapus
              </button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
      <?php if ($no === 1): ?>
        <tr>
          <td colspan="6" class="text-center py-5">
            <i class="bi bi-car-front display-6 text-secondary"></i>
            <p class="text-secondary mt-2 mb-0">Data kendaraan tidak ditemukan.</p>
          </td>
        </tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . "/footer_layout.php"; ?>