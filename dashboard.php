<?php
session_start();
if (!isset($_SESSION['id'])) { header("Location: login.php"); exit; }
require_once __DIR__ . "/koneksi.php";

$judul = 'Dashboard';
$jenisData = array_fill_keys($JENIS, 0);

$stmtJenis = mysqli_prepare($koneksi,
    "SELECT jenis_kendaraan, COUNT(*) AS jumlah FROM $TABEL GROUP BY jenis_kendaraan");
mysqli_stmt_execute($stmtJenis);
$hasilJenis = mysqli_stmt_get_result($stmtJenis);
$totalKendaraan = 0;
while ($barisJenis = mysqli_fetch_assoc($hasilJenis)) {
    $jumlah = (int)$barisJenis['jumlah'];
    $totalKendaraan += $jumlah;
    if (array_key_exists($barisJenis['jenis_kendaraan'], $jenisData)) {
        $jenisData[$barisJenis['jenis_kendaraan']] = $jumlah;
    }
}

$stmtTerbaru = mysqli_prepare($koneksi,
    "SELECT no_id, nomor_kendaraan, jenis_kendaraan, pemilik, tahun_pembuatan
     FROM $TABEL ORDER BY no_id DESC LIMIT 5");
mysqli_stmt_execute($stmtTerbaru);
$kendaraanTerbaru = mysqli_stmt_get_result($stmtTerbaru);

require __DIR__ . "/header.php";
?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
  <div>
    <h1 class="h3 page-heading mb-1">Dashboard</h1>
    <p class="text-secondary mb-0">
      Selamat datang, <?= htmlspecialchars($_SESSION['nama'], ENT_QUOTES, 'UTF-8') ?>.
      Berikut ringkasan data kendaraan.
    </p>
  </div>
  <a href="tambah.php" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i>Tambah Kendaraan
  </a>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <p class="text-secondary mb-1">Total Kendaraan</p>
          <p class="h2 mb-0"><?= $totalKendaraan ?></p>
        </div>
        <span class="rounded-circle bg-primary-subtle text-primary p-3">
          <i class="bi bi-car-front-fill fs-4"></i>
        </span>
      </div>
      <div class="card-footer bg-white border-0 pt-0">
        <a href="kendaraan.php" class="small text-decoration-none">Lihat semua kendaraan <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>
  <?php foreach ($JENIS as $indeks => $jenis): ?>
    <?php
      $warnaIkon = ['text-success bg-success-subtle', 'text-warning bg-warning-subtle',
                    'text-info bg-info-subtle', 'text-danger bg-danger-subtle'];
      $ikon = ['bi-car-front', 'bi-truck', 'bi-truck-front', 'bi-bus-front'];
      $warna = $warnaIkon[$indeks % count($warnaIkon)];
      $namaIkon = $ikon[$indeks % count($ikon)];
    ?>
    <div class="col-sm-6 col-xl-3">
      <div class="card shadow-sm h-100">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <p class="text-secondary mb-1"><?= htmlspecialchars($jenis, ENT_QUOTES, 'UTF-8') ?></p>
            <p class="h2 mb-0"><?= $jenisData[$jenis] ?></p>
          </div>
          <span class="rounded-circle <?= $warna ?> p-3">
            <i class="bi <?= $namaIkon ?> fs-4"></i>
          </span>
        </div>
        <div class="card-footer bg-white border-0 pt-0">
          <a href="kendaraan.php?cari=<?= urlencode($jenis) ?>" class="small text-decoration-none">Lihat data jenis ini <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="card shadow-sm">
  <div class="card-header bg-white border-0 pt-3 px-3 px-lg-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
      <div>
        <h2 class="h5 mb-1">Kendaraan Terbaru</h2>
        <p class="text-secondary small mb-0">Lima data terakhir yang ditambahkan.</p>
      </div>
      <a href="kendaraan.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th scope="col">Nomor Kendaraan</th>
          <th scope="col">Jenis</th>
          <th scope="col">Pemilik</th>
          <th scope="col">Tahun</th>
          <th scope="col" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php $adaKendaraan = false; while ($kendaraan = mysqli_fetch_assoc($kendaraanTerbaru)): $adaKendaraan = true; ?>
        <tr>
          <td class="fw-semibold"><?= htmlspecialchars($kendaraan['nomor_kendaraan'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><span class="badge rounded-pill text-bg-info"><?= htmlspecialchars($kendaraan['jenis_kendaraan'], ENT_QUOTES, 'UTF-8') ?></span></td>
          <td><?= htmlspecialchars($kendaraan['pemilik'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($kendaraan['tahun_pembuatan'], ENT_QUOTES, 'UTF-8') ?></td>
          <td class="text-end">
            <a href="edit.php?id=<?= (int)$kendaraan['no_id'] ?>" class="btn btn-sm btn-outline-primary">
              <i class="bi bi-pencil-square me-1"></i>Edit
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
      <?php if (!$adaKendaraan): ?>
        <tr>
          <td colspan="5" class="text-center py-5">
            <i class="bi bi-car-front display-6 text-secondary"></i>
            <p class="text-secondary mt-2 mb-0">Belum ada data kendaraan.</p>
          </td>
        </tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . "/footer_layout.php"; ?>
