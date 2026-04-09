<?php require_once BASE_PATH . '/views/admin/templates/header.php'; ?>

<div class="header-action">
    <div>
        <h3>
            <i class="fa-solid fa-folder-pen" style="color: var(--primary-color); margin-right: 8px;"></i> 
            <?= isset($title) ? $title : 'Form Kategori'; ?>
        </h3>
        <p style="color: var(--text-muted); font-size: 14px;">Silakan masukkan nama kategori alat dengan benar.</p>
    </div>
</div>

<div class="card" style="max-width: 500px;">
    <form action="<?= $action_url; ?>" method="POST">
        <div class="form-group">
            <label for="nama_kategori">
                <i class="fa-solid fa-tag" style="margin-right: 5px; color: var(--text-muted);"></i> Nama Kategori
            </label>
            <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" 
                   value="<?= isset($kategori['nama_kategori']) ? htmlspecialchars($kategori['nama_kategori']) : ''; ?>" required autofocus>
        </div>
        
        <div style="margin-top: 25px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Data
            </button>
            <a href="index.php?c=admin&a=kategori" class="btn" style="background-color: var(--text-muted); color: white;">
                <i class="fa-solid fa-arrow-rotate-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>