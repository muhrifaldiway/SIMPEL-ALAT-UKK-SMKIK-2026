<?php require_once BASE_PATH . '/views/petugas/templates/header.php'; ?>

<div class="card" style="margin-bottom: 20px;">
    <h3>Daftar Transaksi Peminjaman</h3>
    <p style="color: var(--text-muted); font-size: 14px;">Lakukan verifikasi persetujuan dan proses pengembalian alat di sini.</p>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Batas Kembali</th>
                <th style="text-align: center;">Status</th>
                <th width="25%" style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(count($data_peminjaman) > 0):
                $no = 1;
                foreach($data_peminjaman as $row): 
                    $badge_style = '';
                    if($row['status'] == 'menunggu') $badge_style = 'background: #fef08a; color: #854d0e;';
                    else if($row['status'] == 'disetujui') $badge_style = 'background: #bfdbfe; color: #1e3a8a;';
                    else if($row['status'] == 'ditolak') $badge_style = 'background: #fecaca; color: #991b1b;';
                    else $badge_style = 'background: #dcfce3; color: #166534;';
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td style="font-weight: bold;"><?= htmlspecialchars($row['nama_peminjam']); ?></td>
                <td><?= date('d M Y', strtotime($row['tanggal_pinjam'])); ?></td>
                <td><span style="color: #ef4444; font-weight: 500;"><?= date('d M Y', strtotime($row['tanggal_rencana_kembali'])); ?></span></td>
                <td style="text-align: center;">
                    <span style="<?= $badge_style; ?> padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                        <?= htmlspecialchars($row['status']); ?>
                    </span>
                </td>
                <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                    <a href="index.php?c=petugas&a=detail&id=<?= $row['id_peminjaman']; ?>" class="btn btn-sm" style="background: #64748b; color: white;"><i class="fa-solid fa-eye"></i>Detail</a>
                    
                    <?php if($row['status'] == 'menunggu'): ?>
                        <a href="javascript:void(0)" onclick="showConfirm('index.php?c=petugas&a=ubahStatus&status=disetujui&id=<?= $row['id_peminjaman']; ?>', '', 'approve')" class="btn btn-sm btn-success"><i class="fa-solid fa-check"></i> Setujui</a>
                        
                        <a href="javascript:void(0)" onclick="showConfirm('index.php?c=petugas&a=ubahStatus&status=ditolak&id=<?= $row['id_peminjaman']; ?>', '', 'reject')" class="btn btn-sm btn-danger"><i class="fa-solid fa-xmark"></i> Tolak</a>
                    
                    <?php elseif($row['status'] == 'disetujui'): ?>
                        <a href="javascript:void(0)" onclick="showConfirm('index.php?c=petugas&a=prosesKembali&id=<?= $row['id_peminjaman']; ?>', '', 'return')" class="btn btn-sm" style="background: #8b5cf6; color: white;"><i class="fa-solid fa-clipboard-check"></i> Terima Pengembalian</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php 
                endforeach;
            else: 
            ?>
            <tr><td colspan="6" style="text-align: center; padding: 30px;">Belum ada data transaksi.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/views/petugas/templates/footer.php'; ?>