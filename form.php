<div class="mb-3">
  <label for="nomor_kendaraan" class="form-label">Nomor Kendaraan</label>
  <input type="text" name="nomor_kendaraan" maxlength="12" class="form-control"
         id="nomor_kendaraan" placeholder="Contoh: B 1234 XYZ"
         value="<?= htmlspecialchars($d['nomor_kendaraan'], ENT_QUOTES, 'UTF-8') ?>" required>
</div>
<div class="mb-3">
  <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
  <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select" required>
    <option value="">-- Pilih --</option>
    <?php foreach ($JENIS as $j): ?>
      <option value="<?= htmlspecialchars($j, ENT_QUOTES, 'UTF-8') ?>"
        <?= $d['jenis_kendaraan'] == $j ? 'selected' : '' ?>>
        <?= htmlspecialchars($j, ENT_QUOTES, 'UTF-8') ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>
<div class="mb-3">
  <label for="pemilik" class="form-label">Nama Pemilik</label>
  <input type="text" name="pemilik" id="pemilik" maxlength="50" class="form-control"
         placeholder="Masukkan nama pemilik"
         value="<?= htmlspecialchars($d['pemilik'], ENT_QUOTES, 'UTF-8') ?>" required>
</div>
<div class="mb-3">
  <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
  <input type="number" name="tahun_pembuatan" id="tahun_pembuatan" min="1900"
         max="<?= date('Y') + 1 ?>" class="form-control" placeholder="Contoh: 2022"
         value="<?= htmlspecialchars($d['tahun_pembuatan'], ENT_QUOTES, 'UTF-8') ?>" required>
  <div class="form-text">Masukkan tahun kendaraan dibuat.</div>
</div>