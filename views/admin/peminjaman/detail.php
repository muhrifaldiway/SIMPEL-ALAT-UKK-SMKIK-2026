<?php 
$title = "Detail Peminjaman";
require_once BASE_PATH . '/views/admin/templates/header.php'; 
?>

<div class="header-action">
    <div>
        <h3>Rincian Barang Pinjaman</h3>
        <p style="color: var(--text-muted); font-size: 14px;">Daftar alat pada ID Transaksi: #<?= htmlspecialchars($_GET['id']); ?></p>
    </div>
    <a href="index.php?c=admin&a=peminjaman" class="btn" style="background-color: var(--text-muted); color: white;">&larr; Kembali</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Alat</th>
                <th width="20%" style="text-align: center;">Jumlah Dipinjam</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(isset($detail_alat) && count($detail_alat) > 0):
                $no = 1;
                foreach($detail_alat as $item): 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td style="font-weight: 500; font-size: 1.1rem; color: var(--primary-color);">
                    <?= htmlspecialchars($item['nama_alat']); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 1.1rem;">
                    <?= $item['jumlah']; ?> Unit
                </td>
            </tr>
            <?php 
                endforeach;
            else: 
            ?>
            <tr><td colspan="3" style="text-align: center;">Tidak ada detail barang.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>