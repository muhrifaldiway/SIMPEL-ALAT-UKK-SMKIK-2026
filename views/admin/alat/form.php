<?php require_once BASE_PATH . '/views/admin/templates/header.php'; ?>

<div class="header-action">
    <div>
        <h3>
            <i class="fa-solid fa-toolbox" style="color: var(--primary-color); margin-right: 8px;"></i> 
            <?= isset($title) ? $title : 'Form Alat'; ?>
        </h3>
        <p style="color: var(--text-muted); font-size: 14px;">Silakan lengkapi data spesifikasi alat/barang peminjaman di bawah ini.</p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <form action="<?= $action_url; ?>" method="POST">
        
        <div class="form-group">
            <label for="id_kategori">
                <i class="fa-solid fa-tags" style="margin-right: 5px; color: var(--text-muted);"></i> Kategori Alat
            </label>
            <select id="id_kategori" name="id_kategori" class="form-control" required style="background-color: white;">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach($data_kategori as $kat): ?>
                    <option value="<?= $kat['id_kategori']; ?>" 
                        <?= (isset($alat['id_kategori']) && $alat['id_kategori'] == $kat['id_kategori']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($kat['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nama_alat">
                <i class="fa-solid fa-box" style="margin-right: 5px; color: var(--text-muted);"></i> Nama Alat
            </label>
            <input type="text" id="nama_alat" name="nama_alat" class="form-control" 
                   value="<?= isset($alat['nama_alat']) ? htmlspecialchars($alat['nama_alat']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">
                <i class="fa-solid fa-align-left" style="margin-right: 5px; color: var(--text-muted);"></i> Deskripsi / Spesifikasi
            </label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"><?= isset($alat['deskripsi']) ? htmlspecialchars($alat['deskripsi']) : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="stok">
                <i class="fa-solid fa-cubes" style="margin-right: 5px; color: var(--text-muted);"></i> Jumlah Stok
            </label>
            <input type="number" id="stok" name="stok" class="form-control" min="0" 
                   value="<?= isset($alat['stok']) ? $alat['stok'] : '0'; ?>" required>
        </div>
        
        <div style="margin-top: 25px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Data
            </button>
            <a href="index.php?c=admin&a=alat" class="btn" style="background-color: var(--text-muted); color: white;">
                <i class="fa-solid fa-arrow-rotate-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>