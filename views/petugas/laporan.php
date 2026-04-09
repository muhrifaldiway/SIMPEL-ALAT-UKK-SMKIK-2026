<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Peminjaman</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; color: #333; line-height: 1.5; padding: 20px; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h2 { margin: 0 0 5px 0; font-size: 24px; text-transform: uppercase; }
        .kop-surat p { margin: 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; font-size: 13px; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
        .btn-print { 
            display: block; width: 150px; margin: 0 auto 20px; padding: 10px; 
            background: #2563eb; color: white; text-align: center; text-decoration: none; 
            border-radius: 5px; font-weight: bold; cursor: pointer; border: none;
        }
        .ttd { float: right; width: 250px; text-align: center; margin-top: 30px; }
        
        /* Sembunyikan tombol print saat dicetak di kertas */
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

<button onclick="window.print()" class="btn-print no-print">🖨️ Cetak Laporan PDF</button>

<div class="kop-surat">
    <h2>LAPORAN TRANSAKSI PEMINJAMAN ALAT</h2>
    <p>Aplikasi SIMPEL Alat - SMK Informatika Komputer Ampana Kota</p>
    <p>Tanggal Cetak: <?= date('d F Y'); ?></p>
</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Nama Peminjam</th>
            <th>Tanggal Pinjam</th>
            <th>Tgl Rencana Kembali</th>
            <th>Status Akhir</th>
            <th>Petugas ACC</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        if(count($data_laporan) > 0):
            foreach($data_laporan as $row): 
        ?>
        <tr>
            <td class="text-center"><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_peminjam']); ?></td>
            <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])); ?></td>
            <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal_rencana_kembali'])); ?></td>
            
            <td class="text-center">
                <span style="text-transform: uppercase; font-weight: bold;">
                    <?= htmlspecialchars($row['status']); ?>
                </span>
                
                <?php 
                // Cek apakah status 'selesai' dan ada nominal denda > 0
                if(strtolower($row['status']) == 'selesai' && isset($row['denda']) && $row['denda'] > 0): 
                ?>
                    <br>
                    <span style="color: #ef4444; font-size: 12px; font-weight: bold;">
                        Denda: Rp <?= number_format($row['denda'], 0, ',', '.'); ?>
                    </span>
                <?php endif; ?>
            </td>
            
            <td><?= $row['nama_petugas'] ? htmlspecialchars($row['nama_petugas']) : '-'; ?></td>
        </tr>
        <?php 
            endforeach;
        else:
        ?>
        <tr><td colspan="6" class="text-center">Tidak ada data transaksi.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="ttd">
    <p>Ampana, <?= date('d F Y'); ?></p>
    <p style="margin-bottom: 70px;">Petugas / Administrator</p>
    <p style="font-weight: bold; text-decoration: underline;">
        <?= htmlspecialchars($_SESSION['nama_lengkap']); ?>
    </p>
</div>

<div style="clear: both; text-align: center; margin-top: 50px;" class="no-print">
    <a href="index.php?c=petugas&a=dashboard" style="color: #666; text-decoration: none;">&larr; Kembali ke Dashboard</a>
</div>

</body>
</html>