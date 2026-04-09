<?php 
$title = "Detail Peminjaman";
require_once BASE_PATH . '/views/petugas/templates/header.php'; 

// Cek status transaksi untuk menentukan apakah tombol hapus boleh muncul
$status_transaksi = $data_utama['status']; 
?>

<div class="header-action" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h3>Rincian Barang Pinjaman</h3>
        <p style="color: var(--text-muted); font-size: 14px;">
            ID Transaksi: #<?= htmlspecialchars($_GET['id']); ?> | Status: <strong><?= strtoupper($status_transaksi); ?></strong>
        </p>
    </div>
    <a href="index.php?c=petugas&a=dashboard" class="btn btn-secondary" style="background-color: var(--text-muted); color: white;">&larr; Kembali ke Dashboard</a>
</div>

<div class="card">
    <div style="margin-bottom: 15px; padding: 10px; background-color: #e8f4f8; border-left: 4px solid #17a2b8; border-radius: 4px;">
        <p style="margin: 0; font-size: 14px;"><strong>Info:</strong> Pastikan stok tersedia sebelum menyetujui transaksi di Dashboard. Jika ada alat dengan stok kurang, klik "Tolak Alat" untuk menghapusnya dari daftar ini.</p>
    </div>

    <table class="table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 2px solid #eee;">
                <th width="5%" style="padding: 10px; text-align: left;">No</th>
                <th style="padding: 10px; text-align: left;">Nama Alat</th>
                <th width="15%" style="padding: 10px; text-align: center;">Stok Gudang</th>
                <th width="15%" style="padding: 10px; text-align: center;">Jml Diminta</th>
                <?php if($status_transaksi == 'menunggu'): ?>
                <th width="15%" style="padding: 10px; text-align: center;">Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(isset($detail_alat) && count($detail_alat) > 0):
                $no = 1;
                foreach($detail_alat as $item): 
                    // Logika pengecekan stok
                    $stok_kurang = $item['jumlah'] > $item['stok'];
            ?>
            <tr style="<?= ($stok_kurang && $status_transaksi == 'menunggu') ? 'background-color: #ffe6e6;' : '' ?> border-bottom: 1px solid #eee;">
                <td style="padding: 10px;"><?= $no++; ?></td>
                
                <td style="padding: 10px; font-weight: 500; font-size: 1.1rem; color: var(--primary-color);">
                    <?= htmlspecialchars($item['nama_alat']); ?>
                    <?php if($stok_kurang && $status_transaksi == 'menunggu'): ?>
                        <br><small style="color: #dc3545; font-weight: bold;"><i class="fa-solid fa-triangle-exclamation"></i> Stok Kurang!</small>
                    <?php endif; ?>
                </td>
                
                <td style="padding: 10px; text-align: center; font-size: 1.1rem; font-weight: <?= $stok_kurang ? 'bold' : 'normal'; ?>; color: <?= $stok_kurang ? '#dc3545' : '#28a745'; ?>;">
                    <?= $item['stok']; ?> Unit
                </td>
                
                <td style="padding: 10px; text-align: center; font-weight: bold; font-size: 1.1rem;">
                    <?= $item['jumlah']; ?> Unit
                </td>
                
                <?php if($status_transaksi == 'menunggu'): ?>
                <td style="padding: 10px; text-align: center;">
                    <a href="index.php?c=petugas&a=hapusItem&id=<?= $_GET['id']; ?>&id_alat=<?= $item['id_alat']; ?>" 
                       class="btn btn-sm" 
                       style="background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px;"
                       onclick="return confirm('Apakah Anda yakin ingin menolak dan menghapus alat ini dari daftar peminjaman?');">
                       <i class="fa-solid fa-trash-can"></i> Tolak Alat
                    </a>
                </td>
                <?php endif; ?>
            </tr>
            <?php 
                endforeach;
            else: 
            ?>
            <tr><td colspan="5" style="text-align: center; padding: 20px;">Tidak ada detail barang pada transaksi ini.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/views/petugas/templates/footer.php'; ?>