<?php
// controllers/AdminController.php
require_once BASE_PATH . '/models/User.php';
require_once BASE_PATH . '/models/Kategori.php';
require_once BASE_PATH . '/models/Alat.php';
require_once BASE_PATH . '/models/Peminjaman.php';


class AdminController {
    
    public function __construct() {
        // Proteksi: Cek apakah user sudah login
        if(!isset($_SESSION['id_user'])) {
            header("Location: index.php?c=auth&a=login");
            exit;
        }

        // Proteksi Role: Hanya Admin yang boleh mengakses controller ini 
        if($_SESSION['level'] !== 'admin') {
            die("Akses Ditolak! Anda bukan Administrator.");
        }
    }

    public function dashboard() {
        $alatModel = new Alat();
        $userModel = new User();
        $peminjamanModel = new Peminjaman();

        // 3. Menghitung Total Alat
        $total_alat = count($alatModel->getAll());

        // 4. Menghitung Total User
        $total_user = count($userModel->getAll());

        // 5. Menghitung Peminjaman Aktif (Hanya yang berstatus 'menunggu' atau 'disetujui')
        $data_peminjaman = $peminjamanModel->getAll();
        $total_peminjaman = 0;
        foreach($data_peminjaman as $row) {
            if($row['status'] == 'menunggu' || $row['status'] == 'disetujui') {
                $total_peminjaman++;
            }
        }

        $title = "Dashboard Admin";

        // 6. Memuat view dashboard admin
        require_once BASE_PATH . '/views/admin/dashboard.php';
    }

    // 1. Menampilkan Daftar User
    public function user() {
        $userModel = new User();
        $data_user = $userModel->getAll();
        
        require_once BASE_PATH . '/views/admin/user/index.php';
    }

    // 2. Menambah User Baru
    public function tambahUser() {
        
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $level = $_POST['level'];

            if(!empty($nama_lengkap) && !empty($username) && !empty($password)) {
                $userModel = new User();
                // Menggunakan fungsi register dari model
                $result = $userModel->register($username, $password, $nama_lengkap, $level);
                
                if($result === true) {
                    $_SESSION['flash'] = ['type' => 'success', 'title' => 'Berhasil!', 'message' => 'Pengguna baru berhasil ditambahkan.'];
                    header("Location: index.php?c=admin&a=user");
                    exit;
                } else {
                    $_SESSION['flash'] = ['type' => 'error', 'title' => 'Gagal!', 'message' => $result];
                }
            } else {
                $_SESSION['flash'] = ['type' => 'warning', 'title' => 'Perhatian!', 'message' => 'Semua kolom wajib diisi.'];
            }
        }
        
        $action_url = "index.php?c=admin&a=tambahUser";
        $title = "Tambah User";
        require_once BASE_PATH . '/views/admin/user/form.php';
    }

    // 3. Mengubah Data User
   // Mengubah Data User (DENGAN PERBAIKAN UX & VALIDASI)
    public function editUser() {
        
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $userModel = new User();
        
        // Ambil data asli dari database sebagai default awal
        $user = $userModel->getById($id);
        if(!$user) {
            die("Data pengguna tidak ditemukan!");
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $username = trim($_POST['username']);
            $password = $_POST['password']; // Opsional
            $level = $_POST['level'];

            // Validasi Server-Side: Jika form dikosongkan paksa
            if(empty($nama_lengkap) || empty($username)) {
                $_SESSION['flash'] = ['type' => 'warning', 'title' => 'Peringatan!', 'message' => 'Nama Lengkap dan Username tidak boleh dikosongkan.'];
                
                // TIMPA variabel $user agar ketikan tidak hilang di layar
                $user['nama_lengkap'] = $nama_lengkap;
                $user['username'] = $username;
                $user['level'] = $level;
                
            } else {
                // Lempar ke Model untuk di-update (termasuk cek duplikasi)
                $result = $userModel->update($id, $username, $nama_lengkap, $level, $password);
                
                if($result === true) {
                    // Sukses!
                    $_SESSION['flash'] = ['type' => 'success', 'title' => 'Diperbarui!', 'message' => 'Data pengguna berhasil diperbarui.'];
                    header("Location: index.php?c=admin&a=user");
                    exit;
                } else {
                    // Gagal! (Misal: Username sudah dipakai orang lain)
                    $_SESSION['flash'] = ['type' => 'error', 'title' => 'Gagal!', 'message' => $result];
                    
                    // TIMPA variabel $user agar admin tidak ngetik ulang
                    $user['nama_lengkap'] = $nama_lengkap;
                    $user['username'] = $username;
                    $user['level'] = $level;
                }
            }
        }

        $action_url = "index.php?c=admin&a=editUser&id=" . $id;
        $title = "Edit User";
        require_once BASE_PATH . '/views/admin/user/form.php';
    }
    // 4. Menghapus Data User
    public function hapusUser() {
        
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if($id) {
            // Mencegah Admin menghapus dirinya sendiri saat sedang login
            if($id == $_SESSION['id_user']) {
                $_SESSION['flash'] = ['type' => 'error', 'title' => 'Ditolak!', 'message' => 'Anda tidak dapat menghapus akun yang sedang Anda gunakan saat ini.'];
            } else {
                $userModel = new User();
                if($userModel->delete($id)) {
                    $_SESSION['flash'] = ['type' => 'success', 'title' => 'Dihapus!', 'message' => 'Data pengguna berhasil dihapus permanen.'];
                } else {
                    $_SESSION['flash'] = ['type' => 'error', 'title' => 'Gagal!', 'message' => 'Tidak dapat menghapus data pengguna ini (mungkin data ini masih terhubung dengan tabel peminjaman).'];
                }
            }
        }
        header("Location: index.php?c=admin&a=user");
        exit;
    }
    // --- CRUD KATEGORI ---

    // 1. Menampilkan data kategori (Read)
    public function kategori() {
        $katModel = new Kategori();
        $data_kategori = $katModel->getAll();
        require_once BASE_PATH . '/views/admin/kategori/index.php';
    }

    // 2. Menambah data (Create)
    public function tambahKategori() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_kategori = trim($_POST['nama_kategori']);
            if(!empty($nama_kategori)) {
                $katModel = new Kategori();
                $katModel->insert($nama_kategori);
                $_SESSION['flash'] = ['type' => 'success', 'title' => 'Berhasil!', 'message' => 'Kategori baru berhasil ditambahkan.'];
                header("Location: index.php?c=admin&a=kategori");
                exit;

            }
        }
        // Gunakan view form (bisa dipakai untuk tambah & edit)
        $action_url = "index.php?c=admin&a=tambahKategori";
        $title = "Tambah Kategori";
        require_once BASE_PATH . '/views/admin/kategori/form.php';
    }

    // 3. Mengubah data (Update)
    public function editKategori() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $katModel = new Kategori();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_kategori = trim($_POST['nama_kategori']);
            if(!empty($nama_kategori) && $id) {
                $katModel->update($id, $nama_kategori);
                $_SESSION['flash'] = ['type' => 'success', 'title' => 'Diperbarui!', 'message' => 'Nama kategori berhasil diubah.'];
                header("Location: index.php?c=admin&a=kategori");
                exit;
            }
        }

        $kategori = $katModel->getById($id);
        if(!$kategori) die("Data tidak ditemukan!");

        $action_url = "index.php?c=admin&a=editKategori&id=" . $id;
        $title = "Edit Kategori";
        require_once BASE_PATH . '/views/admin/kategori/form.php';
    }

    // 4. Menghapus data (Delete)
    public function hapusKategori() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if($id) {
            $katModel = new Kategori();
            $katModel->delete($id);
        }
        $_SESSION['flash'] = ['type' => 'success', 'title' => 'Dihapus!', 'message' => 'Data kategori berhasil dihapus permanen.'];
        header("Location: index.php?c=admin&a=kategori");
        exit;
    }

    // --- CRUD ALAT ---

    public function alat() {
        $alatModel = new Alat();
        $data_alat = $alatModel->getAll();
        require_once BASE_PATH . '/views/admin/alat/index.php';
    }

    public function tambahAlat() {
        $katModel = new Kategori();
        $data_kategori = $katModel->getAll(); // Ambil data kategori untuk dropdown

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_kategori = $_POST['id_kategori'];
            $nama_alat = trim($_POST['nama_alat']);
            $deskripsi = trim($_POST['deskripsi']);
            $stok = $_POST['stok'];

            if(!empty($nama_alat) && !empty($id_kategori) && $stok !== '') {
                $alatModel = new Alat();
                $alatModel->insert($id_kategori, $nama_alat, $deskripsi, $stok);
                
                $_SESSION['flash'] = ['type' => 'success', 'title' => 'Berhasil!', 'message' => 'Alat baru berhasil ditambahkan.'];
                header("Location: index.php?c=admin&a=alat");
                exit;
            }
        }

        $action_url = "index.php?c=admin&a=tambahAlat";
        $title = "Tambah Alat";
        require_once BASE_PATH . '/views/admin/alat/form.php';
    }

    public function editAlat() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $alatModel = new Alat();
        $katModel = new Kategori();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_kategori = $_POST['id_kategori'];
            $nama_alat = trim($_POST['nama_alat']);
            $deskripsi = trim($_POST['deskripsi']);
            $stok = $_POST['stok'];

            if(!empty($nama_alat) && !empty($id_kategori) && $id) {
                $alatModel->update($id, $id_kategori, $nama_alat, $deskripsi, $stok);
                
                $_SESSION['flash'] = ['type' => 'success', 'title' => 'Diperbarui!', 'message' => 'Data alat berhasil diubah.'];
                header("Location: index.php?c=admin&a=alat");
                exit;
            }
        }

        $alat = $alatModel->getById($id);
        $data_kategori = $katModel->getAll(); // Ambil data kategori untuk dropdown
        
        if(!$alat) die("Data tidak ditemukan!");

        $action_url = "index.php?c=admin&a=editAlat&id=" . $id;
        $title = "Edit Alat";
        require_once BASE_PATH . '/views/admin/alat/form.php';
    }

    public function hapusAlat() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if($id) {
            $alatModel = new Alat();
            $alatModel->delete($id);
            $_SESSION['flash'] = ['type' => 'success', 'title' => 'Dihapus!', 'message' => 'Data alat berhasil dihapus.'];
        }
        header("Location: index.php?c=admin&a=alat");
        exit;
    }

    // ==========================================
    // --- FITUR DATA PEMINJAMAN (MONITORING ADMIN) ---
    // ==========================================

    public function peminjaman() {
        require_once BASE_PATH . '/models/Peminjaman.php';
        $peminjamanModel = new Peminjaman();
        
        // Ambil semua data peminjaman dari Model
        $data_peminjaman = $peminjamanModel->getAll();
        
        $title = "Data Peminjaman";
        require_once BASE_PATH . '/views/admin/peminjaman/index.php';
    }

    public function detailPeminjaman() {
        require_once BASE_PATH . '/models/Peminjaman.php';
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if(!$id) {
            header("Location: index.php?c=admin&a=peminjaman");
            exit;
        }

        $peminjamanModel = new Peminjaman();
        // Ambil detail alat berdasarkan ID Transaksi
        $detail_alat = $peminjamanModel->getDetailPeminjaman($id);
        
        $title = "Detail Peminjaman";
        require_once BASE_PATH . '/views/admin/peminjaman/detail.php';
    }
}
?>