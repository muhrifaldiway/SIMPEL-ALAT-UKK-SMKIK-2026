<?php 
$title = "Kelola User";
require_once BASE_PATH . '/views/admin/templates/header.php'; 
?>

<div class="header-action">
    <p>Daftar seluruh akun Admin, Petugas, dan Peminjam.</p>
    <a href="index.php?c=admin&a=tambahUser" class="btn btn-success">
        <i class="fa-solid fa-user-plus"></i> Tambah User
    </a>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Hak Akses</th>
                <th width="20%" style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if(count($data_user) > 0):
                foreach($data_user as $row): 
                    // Pewarnaan Badge Level & Penambahan Ikon
                    $badge_color = '';
                    $badge_icon = '';
                    
                    if($row['level'] == 'admin') {
                        $badge_color = 'background:#ef4444; color:white;';
                        $badge_icon = '<i class="fa-solid fa-user-shield"></i>'; // Ikon Perisai
                    } else if($row['level'] == 'petugas') {
                        $badge_color = 'background:#f59e0b; color:white;';
                        $badge_icon = '<i class="fa-solid fa-user-tie"></i>'; // Ikon Berdasi/Petugas
                    } else {
                        $badge_color = 'background:#e2e8f0; color:#475569;';
                        $badge_icon = '<i class="fa-solid fa-user"></i>'; // Ikon User Biasa
                    }
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td style="font-weight: 500;"><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                <td><span style="font-family: monospace; color: var(--primary-color); font-weight: bold;"><?= htmlspecialchars($row['username']); ?></span></td>
                <td>
                    <span style="<?= $badge_color; ?> padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px;">
                        <?= $badge_icon; ?> <?= htmlspecialchars($row['level']); ?>
                    </span>
                </td>
                <td style="text-align: center; display: flex; gap: 5px; justify-content: center;">
                    <a href="index.php?c=admin&a=editUser&id=<?= $row['id_user']; ?>" class="btn btn-sm btn-warning">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    
                    <?php if($row['id_user'] != $_SESSION['id_user']): ?>
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger" 
                           onclick="showConfirm('index.php?c=admin&a=hapusUser&id=<?= $row['id_user']; ?>', '<?= addslashes($row['nama_lengkap']); ?>')">
                           <i class="fa-solid fa-trash-can"></i> Hapus
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php 
                endforeach;
            else: 
            ?>
            <tr><td colspan="5" style="text-align: center; padding: 30px;">Belum ada data pengguna.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>