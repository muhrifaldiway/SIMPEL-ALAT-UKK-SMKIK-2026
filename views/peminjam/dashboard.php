<?php require_once BASE_PATH . '/views/peminjam/templates/header.php'; ?>

<style>
    .katalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .alat-card {
        background: white; border: 1px solid var(--border-color);
        border-radius: var(--radius); padding: 20px;
        box-shadow: var(--shadow); display: flex; flex-direction: column;
    }
    .alat-kategori { font-size: 12px; color: var(--primary-color); font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
    .alat-nama { font-size: 1.1rem; color: var(--text-main); margin-bottom: 10px; font-weight: 600; }
    .alat-stok { font-size: 13px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color); }
    .stok-badge { background: #dcfce3; color: #166534; padding: 3px 8px; border-radius: 4px; font-weight: bold; }
    .stok-habis { background: #fee2e2; color: #b91c1c; padding: 3px 8px; border-radius: 4px; font-weight: bold; }
    .form-pinjam { margin-top: auto; display: flex; gap: 10px; }
</style>

<div class="card" style="margin-bottom: 20px;">
    <h3>Katalog Peminjaman Alat</h3>
    <p style="color: var(--text-muted); font-size: 14px;">Silakan pilih alat yang ingin Anda pinjam. Tentukan jumlahnya, lalu masukkan ke keranjang.</p>
</div>

<div class="katalog-grid">
    <?php if(count($data_alat) > 0): ?>
        <?php foreach($data_alat as $alat): ?>
            <div class="alat-card">
                <div class="alat-kategori"><?= htmlspecialchars($alat['nama_kategori'] ?? 'Umum'); ?></div>
                <div class="alat-nama"><?= htmlspecialchars($alat['nama_alat']); ?></div>
                <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 15px; flex: 1;">
                    <?= htmlspecialchars($alat['deskripsi']); ?>
                </div>
                
                <div class="alat-stok">
                    Stok Tersedia: 
                    <?php if($alat['stok'] > 0): ?>
                        <span class="stok-badge"><?= $alat['stok']; ?> Unit</span>
                    <?php else: ?>
                        <span class="stok-habis">Habis</span>
                    <?php endif; ?>
                </div>

                <?php if($alat['stok'] > 0): ?>
                    <form action="index.php?c=peminjam&a=tambahKeranjang" method="POST" class="form-pinjam">
                        <input type="hidden" name="id_alat" value="<?= $alat['id_alat']; ?>">
                        <input type="hidden" name="nama_alat" value="<?= htmlspecialchars($alat['nama_alat']); ?>">
                        <input type="hidden" name="stok_tersedia" value="<?= $alat['stok']; ?>">
                        
                        <input type="number" name="jumlah" min="1" max="<?= $alat['stok']; ?>" value="1" 
                               class="form-control" style="width: 70px; padding: 8px;" required>
                        <button type="submit" class="btn btn-primary" style="flex: 1; padding: 8px;">+ Keranjang</button>
                    </form>
                <?php else: ?>
                    <button class="btn" style="background: #9ca3af; cursor: not-allowed; width: 100%;" disabled>Stok Habis</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Belum ada alat yang tersedia di sistem.</p>
    <?php endif; ?>
</div>

<?php require_once BASE_PATH . '/views/peminjam/templates/footer.php'; ?>