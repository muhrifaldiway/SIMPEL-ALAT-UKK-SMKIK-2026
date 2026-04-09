<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Petugas'; ?> - Aplikasi Peminjaman</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="dashboard-wrapper">
    <aside class="sidebar" style="background-color: #1e3a8a;"> <div class="sidebar-header">
    <i class="fa-solid fa-toolbox" style="margin-right: 8px;">
            <h3>SIMPEL Alat</h3></i>
        </div>
        <ul class="sidebar-menu">
            <?php $a = isset($_GET['a']) ? strtolower($_GET['a']) : 'dashboard'; ?>
            <li class="<?= $a == 'dashboard' ? 'active' : ''; ?>">
                <a href="index.php?c=petugas&a=dashboard"><i class="fa-solid fa-clipboard-list"></i> Kelola Peminjaman</a>
            </li>
            <li class="<?= $a == 'laporan' ? 'active' : ''; ?>">
                <a href="index.php?c=petugas&a=laporan"><i class="fa-solid fa-print"></i> Cetak Laporan</a>
            </li>
            <li style="margin-top: 20px;">
                <a class="logout-link" href="javascript:void(0)" onclick="showConfirm('index.php?c=auth&a=logout', '', 'logout')">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <h2><?= isset($title) ? $title : 'Panel Petugas'; ?></h2>
            <div class="user-profile">
                <span style="font-weight: 500;">Halo, <?= htmlspecialchars($_SESSION['nama_lengkap']); ?></span>
                <span style="font-size: 12px; background: #f59e0b; color: white; padding: 2px 8px; border-radius: 12px; margin-left: 10px;">Petugas</span>
            </div>
        </header>
        <div class="content-area">