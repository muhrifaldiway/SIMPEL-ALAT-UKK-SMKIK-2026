<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Admin'; ?> - Aplikasi Peminjaman</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-toolbox" style="margin-right: 8px;">
            <h3>SIMPEL Alat</h3></i>
        </div>
        <ul class="sidebar-menu">
            <?php $c = isset($_GET['c']) ? $_GET['c'] : ''; ?>
            
            <li class="<?= ($c == 'admin' && (!isset($_GET['a']) || $_GET['a'] == 'dashboard')) ? 'active' : ''; ?>">
                <a href="index.php?c=admin&a=dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
            </li>
            <li class="<?= (isset($_GET['a']) && strpos(strtolower($_GET['a']), 'user') !== false) ? 'active' : ''; ?>">
                <a href="index.php?c=admin&a=user"><i class="fa-solid fa-users-gear"></i> Kelola User</a>
            </li>
            <li class="<?= (isset($_GET['a']) && strpos(strtolower($_GET['a']), 'kategori') !== false) ? 'active' : ''; ?>">
                <a href="index.php?c=admin&a=kategori"><i class="fa-solid fa-tags"></i> Kelola Kategori</a>
            </li>
            <li class="<?= (isset($_GET['a']) && strpos(strtolower($_GET['a']), 'alat') !== false) ? 'active' : ''; ?>">
                <a href="index.php?c=admin&a=alat"><i class="fa-solid fa-boxes-stacked"></i> Kelola Alat</a>
            </li>
            <li class="<?= (isset($_GET['a']) && strpos(strtolower($_GET['a']), 'peminjaman') !== false) ? 'active' : ''; ?>">
                <a href="index.php?c=admin&a=peminjaman"><i class="fa-solid fa-clipboard-list"></i> Data Peminjaman</a>
            </li>
            <li style="margin-top: 20px;">
                <a href="javascript:void(0)" class="logout-link" onclick="showConfirm('index.php?c=auth&a=logout', '', 'logout')">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <h2>
                <?php 
                if (isset($title)) {
                    // Jika $title di-set manual, gunakan itu
                    echo $title;
                } else {
                    // Jika tidak, ambil dari parameter URL (contoh: a=tambahKategori)
                    $aksi = isset($_GET['a']) ? $_GET['a'] : 'Dashboard';
                    
                    // Memisahkan huruf kapital dengan spasi (tambahKategori -> tambah Kategori)
                    $aksi_rapi = preg_replace('/(?<!^)([A-Z])/', ' $1', $aksi);
                    
                    // Mengubah huruf awal menjadi kapital (tambah Kategori -> Tambah Kategori)
                    echo ucwords($aksi_rapi);
                }
                ?>
            </h2>
            <div class="user-profile">
                <span style="font-weight: 500;">Halo, <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?></span>
                <span style="font-size: 12px; background: var(--primary-color); color: white; padding: 2px 8px; border-radius: 12px; margin-left: 10px;">
                    <?= htmlspecialchars($_SESSION['level'] ?? ''); ?>
                </span>
            </div>
        </header>

        <div class="content-area">