<?php 
$title = "Kelola Kategori";
require_once BASE_PATH . '/views/admin/templates/header.php'; 
?>

<div class="header-action">
    <p>
        <i class="fa-solid fa-tags" style="color: var(--primary-color); margin-right: 5px;"></i> 
        Daftar semua kategori alat yang tersedia di sistem.
    </p>
    <a href="index.php?c=admin&a=tambahKategori" class="btn btn-success">
        <i class="fa-solid fa-folder-plus"></i> Tambah Kategori
    </a>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>Nama Kategori</th>
                <th width="25%" style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if(count($data_kategori) > 0):
                foreach($data_kategori as $row): 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td style="font-weight: 500;"><?= htmlspecialchars($row['nama_kategori']); ?></td>
                <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                    <a href="index.php?c=admin&a=editKategori&id=<?= $row['id_kategori']; ?>" class="btn btn-sm btn-warning">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                     
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" 
                       onclick="showConfirm('index.php?c=admin&a=hapusKategori&id=<?= $row['id_kategori']; ?>', '<?= addslashes($row['nama_kategori']); ?>')">
                       <i class="fa-solid fa-trash-can"></i> Hapus
                    </a>
                </td>
            </tr>
            <?php 
                endforeach;
            else: 
            ?>
            <tr>
                <td colspan="3" style="text-align: center; padding: 30px;">Belum ada data kategori.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>