<?php 
$title = "Dashboard";
require_once BASE_PATH . '/views/admin/templates/header.php'; 
?>

<div class="card" style="margin-bottom: 20px;">
    <h3>
        <i class="fa-solid fa-gauge-high" style="color: var(--primary-color); margin-right: 8px;"></i> 
        Selamat Datang di Panel Administrator!
    </h3>
    <p style="color: var(--text-muted); margin-top: 5px; margin-left: 32px;">
        Di sini Anda dapat mengelola data master pengguna, alat, kategori, dan memantau seluruh transaksi peminjaman.
    </p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h4 style="display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-boxes-stacked" style="color: var(--primary-color);"></i> Total Alat
        </h4>
        <div class="number"><?= isset($total_alat) ? $total_alat : 0; ?></div>
    </div>
    
    <div class="stat-card">
        <h4 style="display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-users" style="color: var(--primary-color);"></i> Total Pengguna
        </h4>
        <div class="number"><?= isset($total_user) ? $total_user : 0; ?></div>
    </div>
    
    <div class="stat-card" style="border-left-color: #10b981;">
        <h4 style="display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-clipboard-check" style="color: #10b981;"></i> Peminjaman Aktif
        </h4>
        <div class="number"><?= isset($total_peminjaman) ? $total_peminjaman : 0; ?></div>
    </div>
</div>

<?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>