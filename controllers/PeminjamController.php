<?php
    // controllers/PeminjamController.php
    require_once BASE_PATH . '/models/Peminjaman.php';
    class PeminjamController {
        private $peminjamanModel;
        public function __construct() {
            // Proteksi: Cek apakah user sudah login
            if(!isset($_SESSION['id_user'])) {
                header("Location: index.php?c=auth&a=login");
                exit;
            }

            // Proteksi Role: Hanya Peminjam yang boleh mengakses
            if($_SESSION['level'] !== 'peminjam') {
                die("Akses Ditolak! Halaman ini khusus untuk Peminjam.");
            }

            // Inisialisasi session keranjang jika belum ada
            if(!isset($_SESSION['keranjang'])) {
                $_SESSION['keranjang'] = [];
            }
        }

        // Menampilkan Katalog Alat
        public function dashboard() {
            require_once BASE_PATH . '/models/Alat.php';
            $alatModel = new Alat();
            $data_alat = $alatModel->getAll(); // Ambil semua alat yang tersedia

            $title = "Katalog Alat";
            require_once BASE_PATH . '/views/peminjam/dashboard.php';
        }

        // Menampilkan isi keranjang
        public function keranjang() {
            $keranjang = $_SESSION['keranjang'] ?? [];
            $title = "Keranjang Saya";
            require_once BASE_PATH . '/views/peminjam/keranjang.php';
        }
        // Memasukkan alat ke keranjang
        public function tambahKeranjang() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id_alat = $_POST['id_alat'];
                $nama_alat = $_POST['nama_alat'];
                $jumlah = (int)$_POST['jumlah'];
                $stok_tersedia = (int)$_POST['stok_tersedia'];

                if($jumlah > 0 && $jumlah <= $stok_tersedia) {
                    // Cek apakah alat sudah ada di keranjang
                    $index = array_search($id_alat, array_column($_SESSION['keranjang'], 'id_alat'));

                    if($index !== false) {
                        // Jika sudah ada, tambahkan jumlahnya
                        $_SESSION['keranjang'][$index]['jumlah'] += $jumlah;
                    } else {
                        // Jika belum, masukkan sebagai item baru
                        $_SESSION['keranjang'][] = [
                            'id_alat' => $id_alat,
                            'nama_alat' => $nama_alat,
                            'jumlah' => $jumlah
                        ];
                    }
                    $_SESSION['flash'] = ['type' => 'success', 'title' => 'Berhasil!', 'message' => "$nama_alat dimasukkan ke keranjang."];
                } else {
                    $_SESSION['flash'] = ['type' => 'error', 'title' => 'Gagal!', 'message' => 'Jumlah tidak valid atau melebihi stok.'];
                }
            }
            header("Location: index.php?c=peminjam&a=dashboard");
            exit;
        }

        // Menghapus item dari keranjang
        public function hapusKeranjang() {
            $id_alat = isset($_GET['id']) ? $_GET['id'] : null;

            if($id_alat) {
                foreach($_SESSION['keranjang'] as $key => $item) {
                    if($item['id_alat'] == $id_alat) {
                        unset($_SESSION['keranjang'][$key]);
                        // Re-index array setelah dihapus agar urutannya rapi
                        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
                        break;
                    }
                }
                $_SESSION['flash'] = ['type' => 'success', 'title' => 'Dihapus!', 'message' => 'Alat berhasil dihapus dari keranjang.'];
            }
            header("Location: index.php?c=peminjam&a=keranjang");
            exit;
        }

        // Memproses transaksi peminjaman (Simpan ke Database)
        public function prosesPinjam() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $tanggal_rencana_kembali = $_POST['tanggal_rencana_kembali'];
                $keranjang = $_SESSION['keranjang'] ?? [];

                if(empty($keranjang)) {
                    $_SESSION['flash'] = ['type' => 'error', 'title' => 'Gagal!', 'message' => 'Keranjang Anda kosong.'];
                    header("Location: index.php?c=peminjam&a=dashboard");
                    exit;
                }

                // Validasi tanggal kembali tidak boleh lebih kecil dari hari ini
                if(strtotime($tanggal_rencana_kembali) < strtotime(date('Y-m-d'))) {
                    $_SESSION['flash'] = ['type' => 'error', 'title' => 'Gagal!', 'message' => 'Tanggal pengembalian tidak valid.'];
                    header("Location: index.php?c=peminjam&a=keranjang");
                    exit;
                }

                // Panggil Model Peminjaman
                $peminjamanModel = new Peminjaman();

                // Eksekusi fungsi ajukanPeminjaman yang berisi Commit & Rollback
                $result = $peminjamanModel->ajukanPeminjaman($_SESSION['id_user'], $tanggal_rencana_kembali, $keranjang);

                if($result === true) {
                    // Jika berhasil, kosongkan keranjang
                    $_SESSION['keranjang'] = [];
                    $_SESSION['flash'] = ['type' => 'success', 'title' => 'Berhasil!', 'message' => 'Pengajuan peminjaman berhasil dibuat. Menunggu persetujuan petugas.'];
                    header("Location: index.php?c=peminjam&a=riwayat"); // Arahkan ke halaman riwayat
                    exit;
                } else {
                    $_SESSION['flash'] = ['type' => 'error', 'title' => 'Gagal!', 'message' => 'Terjadi kesalahan sistem: ' . $result];
                    header("Location: index.php?c=peminjam&a=keranjang");
                    exit;
                }
            }
        }

        // Menampilkan riwayat peminjaman user yang sedang login
        public function riwayat() {
            $peminjamanModel = new Peminjaman();

            // Ambil data peminjaman KHUSUS untuk user yang sedang login
            $data_riwayat = $peminjamanModel->getByUserId($_SESSION['id_user']);

            $title = "Riwayat Peminjaman";
            require_once BASE_PATH . '/views/peminjam/riwayat.php';
        }

    }
    ?>