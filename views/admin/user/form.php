<?php 
require_once BASE_PATH . '/views/admin/templates/header.php'; 
?>

<div class="header-action">
    <div>
        <h3>
            <i class="fa-solid fa-user-pen" style="color: var(--primary-color); margin-right: 8px;"></i> 
            <?= isset($title) ? $title : 'Form Pengguna'; ?>
        </h3>
        <p style="color: var(--text-muted); font-size: 14px;">Silakan isi kelengkapan data form di bawah ini dengan benar.</p>
    </div>
</div>

<div class="card" style="max-width: 500px;">
    <form action="<?= $action_url; ?>" method="POST">
        
        <div class="form-group">
            <label for="nama_lengkap">
                <i class="fa-regular fa-id-card" style="margin-right: 5px; color: var(--text-muted);"></i> Nama Lengkap
            </label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" 
                   value="<?= isset($user['nama_lengkap']) ? htmlspecialchars($user['nama_lengkap']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="username">
                <i class="fa-solid fa-at" style="margin-right: 5px; color: var(--text-muted);"></i> Username (Untuk Login)
            </label>
            <input type="text" id="username" name="username" class="form-control" 
                   value="<?= isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="password">
                <i class="fa-solid fa-lock" style="margin-right: 5px; color: var(--text-muted);"></i> Password 
                <?= isset($user) ? '<small style="color:#ef4444; font-weight:normal;">(Kosongkan jika tidak ingin diubah)</small>' : ''; ?>
            </label>
            <input type="password" id="password" name="password" class="form-control" <?= isset($user) ? '' : 'required'; ?>>
        </div>

        <div class="form-group">
            <label for="level">
                <i class="fa-solid fa-user-shield" style="margin-right: 5px; color: var(--text-muted);"></i> Hak Akses (Level)
            </label>
            <select id="level" name="level" class="form-control" required style="background-color: white;">
                <option value="peminjam" <?= (isset($user['level']) && $user['level'] == 'peminjam') ? 'selected' : ''; ?>>Peminjam</option>
                <option value="petugas" <?= (isset($user['level']) && $user['level'] == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                <option value="admin" <?= (isset($user['level']) && $user['level'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        
        <div style="margin-top: 25px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Data
            </button>
            <a href="index.php?c=admin&a=user" class="btn" style="background-color: var(--text-muted); color: white;">
                <i class="fa-solid fa-arrow-rotate-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>