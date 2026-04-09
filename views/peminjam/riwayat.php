<?php 
$title = "Riwayat Peminjaman";
require_once BASE_PATH . '/views/peminjam/templates/header.php'; 
?>

<div class="card" style="margin-bottom: 20px;">
    <h3>Riwayat Transaksi Saya</h3>
    <p style="color: var(--text-muted); font-size: 14px;">Pantau status pengajuan alat yang telah Anda pinjam di sini.</p>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal Pengajuan</th>
                <th>Rencana Kembali</th>
                <th>Petugas Penanggung Jawab</th>
                <th width="15%" style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(count($data_riwayat) > 0):
                $no = 1;
                foreach($data_riwayat as $row): 
                    // Menentukan warna badge berdasarkan status
                    $badge_style = '';
                    switch($row['status']) {
                        case 'menunggu':
                            $badge_style = 'background: #fef08a; color: #854d0e;'; // Kuning
                            break;
                        case 'disetujui':
                            $badge_style = 'background: #bfdbfe; color: #1e3a8a;'; // Biru
                            break;
                        case 'ditolak':
                            $badge_style = 'background: #fecaca; color: #991b1b;'; // Merah
                            break;
                        case 'selesai':
                            $badge_style = 'background: #dcfce3; color: #166534;'; // Hijau
                            break;
                    }
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td>
                    <?= date('d M Y', strtotime($row['tanggal_pinjam'])); ?>
                </td>
                <td>
                    <span style="font-weight: 500; color: var(--text-main);">
                        <?= date('d M Y', strtotime($row['tanggal_rencana_kembali'])); ?>
                    </span>
                </td>
                <td>
                    <?= $row['nama_petugas'] ? htmlspecialchars($row['nama_petugas']) : '<span style="color: var(--text-muted); font-style: italic;">Belum diproses</span>'; ?>
                </td>
                <td style="text-align: center;">
                    <span style="<?= $badge_style; ?> padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                        <?= htmlspecialchars($row['status']); ?>
                    </span>
                </td>
            </tr>
            <?php 
                endforeach;
            else: 
            ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px;">Belum ada riwayat peminjaman.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/views/peminjam/templates/footer.php'; ?>