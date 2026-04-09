<?php
// controllers/PetugasController.php

class PetugasController {
    
    public function __construct() {
        if(!isset($_SESSION['id_user'])) {
            header("Location: index.php?c=auth&a=login");
            exit;
        }
        if($_SESSION['level'] == 'peminjam') {
            die("Akses Ditolak!");
        }
    }

    public function dashboard() {
        require_once BASE_PATH . '/models/Peminjaman.php';
        $peminjamanModel = new Peminjaman();
        $data_peminjaman = $peminjamanModel->getAll();
        
        $title = "Kelola Peminjaman";
        require_once BASE_PATH . '/views/petugas/dashboard.php';
    }

    // UPDATE: Mengambil data utama peminjaman untuk cek status
    public function detail() {
        require_once BASE_PATH . '/models/Peminjaman.php';
        $id_peminjaman = isset($_GET['id']) ? $_GET['id'] : null;
        
        if(!$id_peminjaman) {
            header("Location: index.php?c=petugas&a=dashboard");
            exit;
        }

        $peminjamanModel = new Peminjaman();
        $data_utama = $peminjamanModel->getById($id_peminjaman); // Ambil status & tgl
        $detail_alat = $peminjamanModel->getDetailPeminjaman($id_peminjaman); // Ambil alat & stok
        
        $title = "Detail Transaksi";
        require_once BASE_PATH . '/views/petugas/detail.php';
    }

    // FUNGSI BARU (UPDATE): Aksi untuk menghapus item alat dan mengembalikan stok
    public function hapusItem() {
        require_once BASE_PATH . '/models/Peminjaman.php';
        $id_peminjaman = isset($_GET['id']) ? $_GET['id'] : null;
        $id_alat = isset($_GET['id_alat']) ? $_GET['id_alat'] : null;

        if($id_peminjaman && $id_alat) {
            $peminjamanModel = new Peminjaman();
            $db = (new Database())->getConnection();
            
            // 1. CEK JUMLAH PINJAMAN: Ambil jumlah alat yang ingin ditolak/dihapus
            $stmt = $db->prepare("SELECT jumlah FROM detail_peminjaman WHERE id_peminjaman = ? AND id_alat = ?");
            $stmt->execute([$id_peminjaman, $id_alat]);
            $detail = $stmt->fetch(PDO::FETCH_ASSOC);

            if($detail) {
                $jumlah_kembali = $detail['jumlah'];

                // 2. HAPUS DATA: Hapus item alat dari daftar pinjaman
                if($peminjamanModel->hapusItemDetail($id_peminjaman, $id_alat)) {
                    
                    // 3. KEMBALIKAN STOK: Kembalikan stok secara manual ke tabel alat
                    $db->query("UPDATE alat SET stok = stok + {$jumlah_kembali} WHERE id_alat = {$id_alat}");

                    $_SESSION['flash'] = ['type' => 'success', 'title' => 'Berhasil!', 'message' => 'Alat ditolak dan stok ('.$jumlah_kembali.' unit) berhasil dikembalikan ke sistem.'];
                } else {
                    $_SESSION['flash'] = ['type' => 'error', 'title' => 'Gagal!', 'message' => 'Gagal menghapus item dari sistem.'];
                }
            }
        }
        
        // Kembali ke halaman detail peminjaman tersebut
        header("Location: index.php?c=petugas&a=detail&id=" . $id_peminjaman);
        exit;
    }

    public function ubahStatus() {
        require_once BASE_PATH . '/models/Peminjaman.php';
        $id_peminjaman = isset($_GET['id']) ? $_GET['id'] : null;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        
        if($id_peminjaman && $status) {
            $peminjamanModel = new Peminjaman();
            $id_petugas = $_SESSION['id_user'];
            
            if($peminjamanModel->updateStatus($id_peminjaman, $id_petugas, $status)) {
                if($status == 'ditolak') {
                    require_once BASE_PATH . '/models/Alat.php';
                    $details = $peminjamanModel->getDetailPeminjaman($id_peminjaman);
                    $db = (new Database())->getConnection();
                    foreach($details as $item) {
                        $db->query("UPDATE alat SET stok = stok + {$item['jumlah']} WHERE id_alat = {$item['id_alat']}");
                    }
                }
                $_SESSION['flash'] = ['type' => 'success', 'title' => 'Berhasil!', 'message' => 'Status peminjaman berhasil diperbarui.'];
            }
        }
        header("Location: index.php?c=petugas&a=dashboard");
        exit;
    }

    public function prosesKembali() {
        require_once BASE_PATH . '/models/Peminjaman.php';
        $id_peminjaman = isset($_GET['id']) ? $_GET['id'] : null;
        
        if($id_peminjaman) {
            $peminjamanModel = new Peminjaman();
            $id_petugas = $_SESSION['id_user'];
            $data_pinjam = $peminjamanModel->getById($id_peminjaman);
            
            if($data_pinjam) {
                $tgl_rencana = strtotime($data_pinjam['tanggal_rencana_kembali']);
                $tgl_sekarang = strtotime(date('Y-m-d'));
                
                $denda = 0;
                $tarif_per_hari = 5000;
                
                if ($tgl_sekarang > $tgl_rencana) {
                    $selisih_detik = $tgl_sekarang - $tgl_rencana;
                    $selisih_hari = floor($selisih_detik / (60 * 60 * 24));
                    $denda = $selisih_hari * $tarif_per_hari;
                }

                $result = $peminjamanModel->prosesPengembalian($id_peminjaman, $id_petugas, $denda); 
                
                if($result === true) {
                    $pesan = 'Barang telah dikembalikan.';
                    if ($denda > 0) {
                        $pesan = 'Terlambat ' . $selisih_hari . ' hari. Total denda: Rp ' . number_format($denda, 0, ',', '.');
                    }
                    $_SESSION['flash'] = ['type' => 'success', 'title' => 'Selesai!', 'message' => $pesan];
                }
            }
        }
        header("Location: index.php?c=petugas&a=dashboard");
        exit;
    }

    public function laporan() {
        require_once BASE_PATH . '/models/Peminjaman.php';
        $peminjamanModel = new Peminjaman();
        $data_laporan = $peminjamanModel->getAll();
        $title = "Laporan Transaksi";
        require_once BASE_PATH . '/views/petugas/laporan.php';
    }
}