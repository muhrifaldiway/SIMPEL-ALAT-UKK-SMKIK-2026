<?php 
$title = "Kelola Alat";
require_once BASE_PATH . '/views/admin/templates/header.php'; ?>
<body>
<div class="dashboard-wrapper">

    <main class="main-content">
    
        <div class="content-area">
            <div class="header-action">
                <p>Daftar semua alat/barang yang dapat dipinjam.</p>
                <a href="index.php?c=admin&a=tambahAlat" class="btn btn-success">
                    <i class="fa-solid fa-plus"></i> Tambah Alat
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Alat</th>
                            <th>Kategori</th>
                            <th width="10%">Stok</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if(count($data_alat) > 0):
                            foreach($data_alat as $row): 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <strong><?= htmlspecialchars($row['nama_alat']); ?></strong><br>
                                <small style="color: var(--text-muted);"><?= htmlspecialchars($row['deskripsi']); ?></small>
                            </td>
                            <td><span style="background: var(--bg-color); padding: 4px 10px; border-radius: 12px; font-size: 13px; border: 1px solid var(--border-color);"><?= htmlspecialchars($row['nama_kategori'] ?? 'Tidak ada'); ?></span></td>
                            <td>
                                <span style="font-weight: bold; color: <?= $row['stok'] > 0 ? 'var(--primary-color)' : '#ef4444'; ?>">
                                    <?= $row['stok']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?c=admin&a=editAlat&id=<?= $row['id_alat']; ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" 
                                   onclick="showConfirm('index.php?c=admin&a=hapusAlat&id=<?= $row['id_alat']; ?>', '<?= addslashes($row['nama_alat']); ?>')">
                                   <i class="fa-solid fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php 
                            endforeach;
                        else: 
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Belum ada data alat.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>