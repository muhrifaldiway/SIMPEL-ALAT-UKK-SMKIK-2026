<?php 
$title = "Keranjang Saya";
require_once BASE_PATH . '/views/peminjam/templates/header.php'; 
?>

<div class="card" style="margin-bottom: 20px;">
    <h3>Daftar Alat yang Akan Dipinjam</h3>
    <p style="color: var(--text-muted); font-size: 14px;">Periksa kembali daftar alat di bawah ini sebelum mengajukan peminjaman.</p>
</div>

<div class="table-responsive" style="margin-bottom: 30px;">
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Alat</th>
                <th width="15%" style="text-align: center;">Jumlah</th>
                <th width="15%" style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(count($keranjang) > 0):
                $no = 1;
                foreach($keranjang as $item): 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td style="font-weight: 500;"><?= htmlspecialchars($item['nama_alat']); ?></td>
                <td style="text-align: center; font-weight: bold; color: var(--primary-color);"><?= $item['jumlah']; ?> Unit</td>
                <td style="text-align: center;">
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" 
                       onclick="showConfirm('index.php?c=peminjam&a=hapusKeranjang&id=<?= $item['id_alat']; ?>', '<?= addslashes($item['nama_alat']); ?>')">
                       Batal Pinjam
                    </a>
                </td>
            </tr>
            <?php 
                endforeach;
            else: 
            ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 30px;">
                    <div style="color: var(--text-muted); margin-bottom: 10px;">Keranjang Anda masih kosong.</div>
                    <a href="index.php?c=peminjam&a=dashboard" class="btn btn-primary">Lihat Katalog Alat</a>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if(count($keranjang) > 0): ?>
<div class="card" style="max-width: 500px; background-color: #f8fafc; border-color: #cbd5e1;">
    <h4 style="margin-bottom: 15px; color: var(--text-main);">Formulir Pengajuan</h4>
    
    <form action="index.php?c=peminjam&a=prosesPinjam" method="POST">
        <div class="form-group">
            <label for="tanggal_rencana_kembali">Tanggal Rencana Dikembalikan</label>
            <input type="date" id="tanggal_rencana_kembali" name="tanggal_rencana_kembali" class="form-control" 
                   min="<?= date('Y-m-d'); ?>" required style="background-color: white;">
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-success" style="width: 100%; font-size: 16px; padding: 12px;">Ajukan Peminjaman Sekarang</button>
        </div>
    </form>
</div>
<?php endif; ?>

<?php require_once BASE_PATH . '/views/peminjam/templates/footer.php'; ?>