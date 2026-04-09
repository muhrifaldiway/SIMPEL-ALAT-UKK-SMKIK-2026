# 🛠️ SIMPEL ALAT (Sistem Peminjaman Alat)

**SIMPEL ALAT** adalah aplikasi berbasis web yang dirancang untuk mengelola sirkulasi peminjaman dan pengembalian barang/alat (inventaris) di lingkungan sekolah atau instansi.

Aplikasi ini dibangun menggunakan arsitektur **MVC (Model-View-Controller)** dengan pendekatan **OOP (Object-Oriented Programming)** menggunakan **PHP Native dan PDO (PHP Data Objects)**. Aplikasi ini dirancang khusus untuk memenuhi standar ketat Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak (RPL).

## 🏗️ Arsitektur & Struktur Direktori (MVC)

Aplikasi ini memisahkan logika _Database_ (Model), Antarmuka (View), dan Pengendali Alur (Controller) secara ketat.

## TRIGGER DATABASE

```sql

BEGIN
    UPDATE alat
    SET stok = stok - NEW.jumlah
    WHERE id_alat = NEW.id_alat;
END

```

```sql

BEGIN
    -- Menambah stok kembali berdasarkan detail peminjaman yang direlasikan
    UPDATE alat a
    JOIN detail_peminjaman dp ON a.id_alat = dp.id_alat
    SET a.stok = a.stok + dp.jumlah
    WHERE dp.id_peminjaman = NEW.id_peminjaman;
END

```

```text
📦simpel-alat
 ┣ 📂assets
 ┃ ┣ 📂css
   ┗ 📜style.css
 ┣ 📂config
 ┃ ┗ 📜database.php
 ┣ 📂controllers
 ┃ ┣ 📜AdminController.php
 ┃ ┣ 📜AuthController.php
 ┃ ┣ 📜PeminjamController.php
 ┃ ┗ 📜PetugasController.php
 ┣ 📂models
 ┃ ┣ 📜Alat.php
 ┃ ┣ 📜Kategori.php
 ┃ ┣ 📜Peminjaman.php
 ┃ ┗ 📜User.php
 ┣ 📂views
 ┃ ┣ 📂admin
   ┃ ┣ 📂alat
     ┃ ┣ 📜form.php
     ┃ ┣ 📜index.php
   ┃ ┣ 📂kategori
     ┃ ┣ 📜form.php
     ┃ ┣ 📜index.php
   ┃ ┣ 📂peminjaman
     ┃ ┣ 📜detail.php
     ┃ ┣ 📜index.php
   ┃ ┣ 📂templates
     ┃ ┣ 📜footer.php
     ┃ ┣ 📜header.php
   ┃ ┣ 📂user
     ┃ ┣ 📜form.php
     ┃ ┣ 📜index.php
   ┃ ┣ 📜dashboard.php
 ┃ ┣ 📂auth
   ┃ ┣ 📂templates
     ┃ ┣ 📜footer.php
     ┃ ┣ 📜header.php
   ┃ ┣ 📜login.php
   ┃ ┣ 📜register.php
 ┃ ┣ 📂components
     ┃ ┣ 📜alert.php
     ┃ ┣ 📜confirm.php
 ┃ ┣ 📂peminjam
   ┃ ┣ 📂templates
     ┃ ┣ 📜footer.php
     ┃ ┣ 📜header.php
   ┃ ┣ 📜dashboard.php
   ┃ ┣ 📜keranjang.php
   ┃ ┣ 📜riwayat.php
 ┃ ┗ 📂petugas
   ┃ ┣ 📂templates
     ┃ ┣ 📜footer.php
     ┃ ┣ 📜header.php
   ┃ ┣ 📜dashboard.php
   ┃ ┣ 📜detail.php
   ┃ ┣ 📜laporan.php
 ┣ 📜index.php
 ┗ 📜README.md
```

## Folder assets

## FOLDER CSS

## style.css

```css
/* assets/css/style.css */

/* --- CSS Variables untuk Tema --- */
:root {
  --primary-color: #2563eb; /* Biru elegan */
  --primary-hover: #1d4ed8;
  --bg-color: #f3f4f6; /* Abu-abu sangat terang untuk background */
  --card-bg: #ffffff;
  --text-main: #1f2937; /* Abu-abu gelap untuk teks */
  --text-muted: #6b7280;
  --border-color: #e5e7eb;
  --radius: 8px;
  --shadow:
    0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* --- Base & Reset --- */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family:
    "Segoe UI",
    system-ui,
    -apple-system,
    sans-serif;
}

body {
  background-color: var(--bg-color);
  color: var(--text-main);
  line-height: 1.5;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* --- Komponen Elegan --- */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.card {
  background-color: var(--card-bg);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  padding: 24px;
  border: 1px solid var(--border-color);
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  background-color: var(--primary-color);
  color: white;
  text-decoration: none;
  border-radius: var(--radius);
  border: none;
  cursor: pointer;
  font-weight: 500;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: var(--primary-hover);
}

/* Form Styling */
.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  color: var(--text-main);
}

.form-control {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid var(--border-color);
  border-radius: var(--radius);
  outline: none;
  transition: border-color 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* --- Dashboard Layout --- */
.dashboard-wrapper {
  display: flex;
  min-height: 100vh;
}

/* Sidebar Styling */
.sidebar {
  width: 250px;
  background-color: #1e293b; /* Biru sangat gelap elegan */
  color: #ffffff;
  display: flex;
  flex-direction: column;
  transition: all 0.3s;
}

.sidebar-header {
  padding: 20px;
  text-align: center;
  border-bottom: 1px solid #334155;
}

.sidebar-header h3 {
  color: var(--card-bg);
  font-size: 1.2rem;
  letter-spacing: 1px;
}

.sidebar-menu {
  list-style: none;
  padding: 20px 0;
  flex: 1;
}

.sidebar-menu li {
  padding: 5px 20px;
}

.sidebar-menu a {
  display: block;
  color: #cbd5e1;
  text-decoration: none;
  padding: 10px 15px;
  border-radius: var(--radius);
  transition: all 0.3s;
}

.sidebar-menu a:hover,
.sidebar-menu li.active a {
  background-color: var(--primary-color);
  color: #ffffff;
}

/* --- Khusus Tombol Logout di Sidebar --- */
.sidebar-menu .logout-link {
  color: #fca5a5; /* Teks merah muda */
  transition: all 0.3s ease; /* Tambahkan sedikit transisi agar animasi hover-nya smooth */
}

.sidebar-menu .logout-link:hover {
  background-color: #ef4444; /* Background merah tegas saat di-hover */
  color: white;
}

.main-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  background-color: var(--bg-color);
}

.topbar {
  background-color: var(--card-bg);
  padding: 15px 30px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.content-area {
  padding: 30px;
  flex: 1;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-bottom: 30px;
}

.stat-card {
  background: var(--card-bg);
  padding: 20px;
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  border-left: 4px solid var(--primary-color);
}

.stat-card h4 {
  color: var(--text-muted);
  font-size: 0.9rem;
  margin-bottom: 10px;
}

.stat-card .number {
  font-size: 1.8rem;
  font-weight: bold;
  color: var(--text-main);
}

.table-responsive {
  overflow-x: auto;
  background: var(--card-bg);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  border: 1px solid var(--border-color);
}

.table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.table th,
.table td {
  padding: 15px 20px;
  border-bottom: 1px solid var(--border-color);
}

.table th {
  background-color: #f8fafc;
  color: var(--text-main);
  font-weight: 600;
}

.table tr:last-child td {
  border-bottom: none;
}

.table tbody tr:hover {
  background-color: #f1f5f9;
}

.btn-sm {
  padding: 6px 12px;
  font-size: 0.85rem;
}

.btn-warning {
  background-color: #f59e0b;
  color: white;
}
.btn-warning:hover {
  background-color: #d97706;
}

.btn-danger {
  background-color: #ef4444;
  color: white;
}
.btn-danger:hover {
  background-color: #dc2626;
}

.btn-success {
  background-color: #10b981;
  color: white;
}
.btn-success:hover {
  background-color: #059669;
}

.header-action {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
.swal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}
.swal-overlay.show {
  opacity: 1;
  visibility: visible;
}
.swal-modal {
  background: white;
  width: 90%;
  max-width: 400px;
  border-radius: 16px;
  padding: 30px 20px;
  text-align: center;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  transform: scale(0.8);
  transition: all 0.3s ease;
}
.swal-overlay.show .swal-modal {
  transform: scale(1);
}
.swal-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  border: 4px solid;
  margin: 0 auto 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 35px;
  font-weight: bold;
}
.swal-icon.success {
  border-color: #10b981;
  color: #10b981;
}
.swal-icon.error {
  border-color: #ef4444;
  color: #ef4444;
}
.swal-icon.warning {
  border-color: #f59e0b;
  color: #f59e0b;
}

.swal-title {
  font-size: 1.5rem;
  color: var(--text-main);
  margin-bottom: 10px;
  font-weight: 600;
}
.swal-text {
  color: var(--text-muted);
  margin-bottom: 25px;
  line-height: 1.5;
  font-size: 0.95rem;
}
.swal-btn {
  background: var(--primary-color);
  color: white;
  border: none;
  padding: 10px 35px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 500;
  transition: 0.3s;
}
.swal-btn:hover {
  background: var(--primary-hover);
}
.swal-btn.error {
  background: #ef4444;
}
.swal-btn.error:hover {
  background: #dc2626;
}
/* --- Tambahan untuk Modal Konfirmasi --- */
.swal-actions {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 10px;
}
.swal-btn.cancel {
  background: #9ca3af; /* Warna abu-abu untuk tombol batal */
  color: white;
}
.swal-btn.cancel:hover {
  background: #6b7280;
}
/* Memastikan tombol a link berbentuk seperti button di dalam modal */
a.swal-btn {
  text-decoration: none;
  display: inline-block;
}

/* --- Jarak untuk Ikon Font Awesome --- */
.sidebar-menu a i {
  margin-right: 10px;
  width: 20px; /* Agar semua ikon rata tengah sejajar */
  text-align: center;
}

.btn i {
  margin-right: 5px;
}
```

## Folder config

## database.php

```php

<?php

class Database {
    private $host = "localhost";
    private $db_name = "app_pinjam"; // Sesuaikan dengan nama database Anda
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Mengatur error mode PDO menjadi exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Koneksi database gagal: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>

```

## Folder controllers

## AdminController.php

```php

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


```

## AuthController.php

```php


        <?php
    // controllers/AuthController.php
    require_once BASE_PATH . '/models/User.php';

    class AuthController {

        public function login() {
            if(isset($_SESSION['id_user'])) {
                $this->redirectByLevel($_SESSION['level']);
            }

            $old_username = '';
            $old_password = '';

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);

                $old_username = $username;
                $old_password = $password;

                $userModel = new User();

                // 1. CEK USERNAME DULU
                $userExists = $userModel->isUsernameExists($username);

                if($userExists) {
                    // Jika Username BETUL, baru cek Passwordnya
                    $loggedInUser = $userModel->login($username, $password);

                    if($loggedInUser) {
                        // SKENARIO A: SEMUA BETUL
                        $_SESSION['id_user'] = $loggedInUser['id_user'];
                        $_SESSION['nama_lengkap'] = $loggedInUser['nama_lengkap'];
                        $_SESSION['level'] = $loggedInUser['level'];

                        $_SESSION['flash'] = ['type' => 'success', 'title' => 'Berhasil!', 'message' => 'Selamat datang kembali.'];
                        $this->redirectByLevel($loggedInUser['level']);
                    } else {
                        // SKENARIO B: USERNAME BETUL, PASSWORD SALAH
                        // Kita kosongkan password demi keamanan, tapi biarkan username terisi
                        $old_password = '';
                        $_SESSION['flash'] = [
                            'type' => 'error',
                            'title' => 'Password Salah!',
                            'message' => 'Username ditemukan, tapi password-nya keliru.'
                        ];
                    }
                } else {
                    // SKENARIO C: USERNAME TIDAK DITEMUKAN
                    // Karena username tidak ada, otomatis password dianggap salah juga (Skenario Keduanya Salah)

                    if(empty($username) && empty($password)) {
                        $msg = "Username dan Password tidak boleh kosong!";
                    } else {
                        $msg = "Username dan Password yang Anda masukkan tidak terdaftar!";
                    }

                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'title' => 'Login Gagal!',
                        'message' => $msg
                    ];
                }
            }

            require_once BASE_PATH . '/views/auth/login.php';
        }

        public function register() {
            // Jika user sudah login, arahkan ke dashboard
            if(isset($_SESSION['id_user'])) {
                $this->redirectByLevel($_SESSION['level']);
            }

            $error = '';
            $success = '';

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nama_lengkap = trim($_POST['nama_lengkap']);
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);

                // Level default untuk registrasi mandiri adalah peminjam
                $level = 'peminjam';

                if(empty($nama_lengkap) || empty($username) || empty($password)) {
                    $error = "Semua kolom wajib diisi!";
                } else {
                    $userModel = new User();
                    $result = $userModel->register($username, $password, $nama_lengkap, $level);

                    // Di dalam method register(), ubah bagian hasil result registrasi menjadi:
                    if($result === true) {
                        $_SESSION['flash'] = ['type' => 'success', 'title' => 'Registrasi Berhasil!', 'message' => 'Akun Anda telah dibuat. Silakan login.'];
                        header("Location: index.php?c=auth&a=login"); // Langsung arahkan ke login
                        exit;
                    } else {
                        $_SESSION['flash'] = ['type' => 'error', 'title' => 'Registrasi Gagal!', 'message' => $result];
                    }
                }
            }

            // Tampilkan halaman view register
            require_once BASE_PATH . '/views/auth/register.php';
        }

        public function logout() {
            // 1. Hapus semua session data yang aktif
            session_unset();
            session_destroy();

            // 2. Mulai session baru KHUSUS untuk membawa pesan Flash ke halaman login
            session_start();
            $_SESSION['flash'] = [
                'type' => 'success',
                'title' => 'Berhasil Keluar!',
                'message' => 'Anda telah berhasil logout dari aplikasi.'
            ];

            // 3. Arahkan kembali ke halaman login
            header("Location: index.php?c=auth&a=login");
            exit;
        }

        // Fungsi bantuan untuk redirect sesuai hak akses
        private function redirectByLevel($level) {
            if($level == 'admin') {
                header("Location: index.php?c=admin&a=dashboard");
            } else if($level == 'petugas') {
                header("Location: index.php?c=petugas&a=dashboard");
            } else if($level == 'peminjam') {
                header("Location: index.php?c=peminjam&a=dashboard");
            }
            exit;
        }
    }
    ?>

```

## PeminjamController.php

```php

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

```

## PetugasController.php

```php

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

```

## FOLDER models

## Alat.php

```php

        <?php
    // models/Alat.php
    require_once __DIR__ . '/../config/database.php';

    class Alat {
        private $conn;
        private $table_name = "alat";

        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        // Mengambil semua data alat beserta nama kategorinya (JOIN)
        public function getAll() {
            $query = "SELECT a.*, k.nama_kategori
                      FROM " . $this->table_name . " a
                      LEFT JOIN kategori k ON a.id_kategori = k.id_kategori
                      ORDER BY a.id_alat DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Mengambil satu data alat berdasarkan ID
        public function getById($id) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id_alat = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Menambah data alat
        public function insert($id_kategori, $nama_alat, $deskripsi, $stok) {
            $query = "INSERT INTO " . $this->table_name . " (id_kategori, nama_alat, deskripsi, stok)
                      VALUES (:id_kategori, :nama_alat, :deskripsi, :stok)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_kategori', $id_kategori);
            $stmt->bindParam(':nama_alat', $nama_alat);
            $stmt->bindParam(':deskripsi', $deskripsi);
            $stmt->bindParam(':stok', $stok);
            return $stmt->execute();
        }

        // Mengubah data alat
        public function update($id, $id_kategori, $nama_alat, $deskripsi, $stok) {
            $query = "UPDATE " . $this->table_name . "
                      SET id_kategori = :id_kategori, nama_alat = :nama_alat, deskripsi = :deskripsi, stok = :stok
                      WHERE id_alat = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_kategori', $id_kategori);
            $stmt->bindParam(':nama_alat', $nama_alat);
            $stmt->bindParam(':deskripsi', $deskripsi);
            $stmt->bindParam(':stok', $stok);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        // Menghapus data alat
        public function delete($id) {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_alat = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
    }
    ?>

```

## Kategori.php

```php

        <?php
    // models/Kategori.php
    require_once 'config/database.php';

    class Kategori {
        private $conn;
        private $table_name = "kategori";

        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        // Mengambil semua data kategori
        public function getAll() {
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_kategori DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Mengambil satu data kategori berdasarkan ID
        public function getById($id) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id_kategori = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Menambah data kategori baru
        public function insert($nama_kategori) {
            $query = "INSERT INTO " . $this->table_name . " (nama_kategori) VALUES (:nama_kategori)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nama_kategori', $nama_kategori);
            return $stmt->execute();
        }

        // Mengubah data kategori
        public function update($id, $nama_kategori) {
            $query = "UPDATE " . $this->table_name . " SET nama_kategori = :nama_kategori WHERE id_kategori = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nama_kategori', $nama_kategori);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        // Menghapus data kategori
        public function delete($id) {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_kategori = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
    }
    ?>

```

## Peminjaman.php

```php

       <?php
// models/Peminjaman.php
require_once BASE_PATH . '/config/database.php';

class Peminjaman {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // 1. Mengambil semua data peminjaman (Digunakan oleh Admin & Petugas)
    public function getAll() {
        $query = "SELECT p.*, u.nama_lengkap as nama_peminjam, pt.nama_lengkap as nama_petugas,
                         pg.denda, pg.tanggal_aktual_kembali
                  FROM peminjaman p
                  JOIN users u ON p.id_user = u.id_user
                  LEFT JOIN users pt ON p.id_petugas = pt.id_user
                  LEFT JOIN pengembalian pg ON p.id_peminjaman = pg.id_peminjaman
                  ORDER BY p.id_peminjaman DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. [DIKEMBALIKAN] Mengambil data peminjaman berdasarkan Peminjam (Digunakan oleh User Peminjam)
    public function getByUserId($id_user) {
        $query = "SELECT p.*, pt.nama_lengkap as nama_petugas
                  FROM peminjaman p
                  LEFT JOIN users pt ON p.id_petugas = pt.id_user
                  WHERE p.id_user = :id_user
                  ORDER BY p.id_peminjaman DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Mengambil 1 data spesifik berdasarkan ID Peminjaman (Untuk Hitung Denda & Cek Status)
    public function getById($id_peminjaman) {
        $query = "SELECT * FROM peminjaman WHERE id_peminjaman = :id_peminjaman";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_peminjaman', $id_peminjaman);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 4. Mengambil Detail Barang yang Dipinjam (UPDATE: Menambahkan stok)
    public function getDetailPeminjaman($id_peminjaman) {
        $query = "SELECT dp.*, a.nama_alat, a.stok
                  FROM detail_peminjaman dp
                  JOIN alat a ON dp.id_alat = a.id_alat
                  WHERE dp.id_peminjaman = :id_peminjaman";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_peminjaman', $id_peminjaman);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. [FUNGSI BARU] Menghapus satu alat spesifik dari daftar pinjaman (Fitur Tolak Alat)
    public function hapusItemDetail($id_peminjaman, $id_alat) {
        $query = "DELETE FROM detail_peminjaman
                  WHERE id_peminjaman = :id_peminjaman AND id_alat = :id_alat";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_peminjaman', $id_peminjaman);
        $stmt->bindParam(':id_alat', $id_alat);
        return $stmt->execute();
    }

    // 6. [DIKEMBALIKAN] TRANSAKSI PENGAJUAN (SYARAT MUTLAK UKK: COMMIT & ROLLBACK)
    public function ajukanPeminjaman($id_user, $tanggal_rencana_kembali, $keranjang_alat) {
        try {
            $this->conn->beginTransaction();

            // A. Insert ke tabel utama (peminjaman)
            $query_main = "INSERT INTO peminjaman (id_user, tanggal_pinjam, tanggal_rencana_kembali, status)
                           VALUES (:id_user, CURRENT_DATE, :tgl_kembali, 'menunggu')";
            $stmt_main = $this->conn->prepare($query_main);
            $stmt_main->bindParam(':id_user', $id_user);
            $stmt_main->bindParam(':tgl_kembali', $tanggal_rencana_kembali);
            $stmt_main->execute();

            $id_peminjaman = $this->conn->lastInsertId();

            // B. Insert ke tabel detail (detail_peminjaman)
            $query_detail = "INSERT INTO detail_peminjaman (id_peminjaman, id_alat, jumlah)
                             VALUES (:id_peminjaman, :id_alat, :jumlah)";
            $stmt_detail = $this->conn->prepare($query_detail);

            foreach($keranjang_alat as $item) {
                $stmt_detail->bindParam(':id_peminjaman', $id_peminjaman);
                $stmt_detail->bindParam(':id_alat', $item['id_alat']);
                $stmt_detail->bindParam(':jumlah', $item['jumlah']);
                $stmt_detail->execute();
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // 7. Update Status oleh Petugas (Menyetujui / Menolak)
    public function updateStatus($id_peminjaman, $id_petugas, $status) {
        $query = "UPDATE peminjaman
                  SET status = :status, id_petugas = :id_petugas
                  WHERE id_peminjaman = :id_peminjaman";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_petugas', $id_petugas);
        $stmt->bindParam(':id_peminjaman', $id_peminjaman);
        return $stmt->execute();
    }

    // 8. Proses Pengembalian Alat (Memasukkan data ke tabel pengembalian)
    public function prosesPengembalian($id_peminjaman, $id_petugas, $denda = 0) {
        try {
            $this->conn->beginTransaction();

            $query_update = "UPDATE peminjaman SET status = 'selesai' WHERE id_peminjaman = :id_peminjaman";
            $stmt_update = $this->conn->prepare($query_update);
            $stmt_update->bindParam(':id_peminjaman', $id_peminjaman);
            $stmt_update->execute();

            $tgl_sekarang = date('Y-m-d');
            $query_insert = "INSERT INTO pengembalian (id_peminjaman, tanggal_aktual_kembali, denda, id_petugas)
                             VALUES (:id_peminjaman, :tgl_kembali, :denda, :id_petugas)";

            $stmt_insert = $this->conn->prepare($query_insert);
            $stmt_insert->bindParam(':id_peminjaman', $id_peminjaman);
            $stmt_insert->bindParam(':tgl_kembali', $tgl_sekarang);
            $stmt_insert->bindParam(':denda', $denda);
            $stmt_insert->bindParam(':id_petugas', $id_petugas);
            $stmt_insert->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return $e->getMessage();
        }
    }
}
?>

```

## User.php

```php

           <?php
    // models/User.php
    require_once 'config/database.php';

    class User {
        private $conn;
        private $table_name = "users";


        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        // Fungsi untuk memverifikasi login
        public function login($username, $password) {
            // Query menggunakan Prepared Statement untuk mencegah SQL Injection (Best Practice)
            $query = "SELECT id_user, username, password, nama_lengkap, level
                      FROM " . $this->table_name . "
                      WHERE username = :username LIMIT 1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Menggunakan password_verify (Sangat disarankan untuk keamanan UKK)
                // Catatan: Pastikan password di database di-hash menggunakan password_hash()
                if(password_verify($password, $row['password'])) {
                    return $row; // Kembalikan data user jika cocok
                }
            }
            return false; // Kembalikan false jika gagal
        }

        // Fungsi untuk mengecek apakah username sudah ada (Mendukung pengecualian ID saat Edit)
        public function isUsernameExists($username, $exclude_id = null) {

            if ($exclude_id) {
                // Logika untuk form EDIT (Kecualikan ID yang sedang diedit)
                $query = "SELECT id_user FROM " . $this->table_name . "
                          WHERE username = :username AND id_user != :exclude_id LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':exclude_id', $exclude_id);
            } else {
                // Logika untuk form TAMBAH BARU / REGISTER
                $query = "SELECT id_user FROM " . $this->table_name . "
                          WHERE username = :username LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':username', $username);
            }

            $stmt->execute();
            return $stmt->rowCount() > 0;
        }

        // Fungsi untuk registrasi user baru
        public function register($username, $password, $nama_lengkap, $level = 'peminjam') {
            // Cek username duplikat
            if ($this->isUsernameExists($username)) {
                return "Username sudah terdaftar, silakan gunakan yang lain!";
            }

            $query = "INSERT INTO " . $this->table_name . " (username, password, nama_lengkap, level)
                      VALUES (:username, :password, :nama_lengkap, :level)";

            $stmt = $this->conn->prepare($query);

            // Hash password sebelum disimpan (Best Practice)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Bind parameter
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':nama_lengkap', $nama_lengkap);
            $stmt->bindParam(':level', $level);

            // Eksekusi query
            if ($stmt->execute()) {
                return true; // Berhasil
            }
            return "Terjadi kesalahan saat menyimpan data.";
        }

        // ==========================================
        // TAMBAHAN FUNGSI CRUD USER
        // ==========================================

        // --- FUNGSI CRUD USER ---

        // 2. READ ALL (Tanpa mengambil password untuk keamanan)
        public function getAll() {
            $query = "SELECT id_user, username, nama_lengkap, level FROM " . $this->table_name . " ORDER BY id_user DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // 3. READ BY ID
        public function getById($id) {
            $query = "SELECT id_user, username, nama_lengkap, level FROM " . $this->table_name . " WHERE id_user = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }



        // 4. UPDATE
        public function update($id, $username, $nama_lengkap, $level, $password = null) {
            if ($this->isUsernameExists($username, $id)) {
                return "Username sudah dipakai oleh pengguna lain!";
            }

            if (!empty($password)) {
                $query = "UPDATE " . $this->table_name . "
                          SET username = :username, nama_lengkap = :nama_lengkap, level = :level, password = :password
                          WHERE id_user = :id";
                $stmt = $this->conn->prepare($query);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hashed_password);
            } else {
                // Jika password dikosongkan, jangan ubah password lamanya
                $query = "UPDATE " . $this->table_name . "
                          SET username = :username, nama_lengkap = :nama_lengkap, level = :level
                          WHERE id_user = :id";
                $stmt = $this->conn->prepare($query);
            }

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':nama_lengkap', $nama_lengkap);
            $stmt->bindParam(':level', $level);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return true;
            }
            return "Gagal memperbarui data pengguna.";
        }

        // 5. DELETE
        public function delete($id) {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_user = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
    }
    ?>


```

## FOLDER views

## FOLDER admin

## FOLDER alat

## form.php

```php

        <?php require_once BASE_PATH . '/views/admin/templates/header.php'; ?>

    <div class="header-action">
        <div>
            <h3>
                <i class="fa-solid fa-toolbox" style="color: var(--primary-color); margin-right: 8px;"></i>
                <?= isset($title) ? $title : 'Form Alat'; ?>
            </h3>
            <p style="color: var(--text-muted); font-size: 14px;">Silakan lengkapi data spesifikasi alat/barang peminjaman di bawah ini.</p>
        </div>
    </div>

    <div class="card" style="max-width: 600px;">
        <form action="<?= $action_url; ?>" method="POST">

            <div class="form-group">
                <label for="id_kategori">
                    <i class="fa-solid fa-tags" style="margin-right: 5px; color: var(--text-muted);"></i> Kategori Alat
                </label>
                <select id="id_kategori" name="id_kategori" class="form-control" required style="background-color: white;">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach($data_kategori as $kat): ?>
                        <option value="<?= $kat['id_kategori']; ?>"
                            <?= (isset($alat['id_kategori']) && $alat['id_kategori'] == $kat['id_kategori']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($kat['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nama_alat">
                    <i class="fa-solid fa-box" style="margin-right: 5px; color: var(--text-muted);"></i> Nama Alat
                </label>
                <input type="text" id="nama_alat" name="nama_alat" class="form-control"
                       value="<?= isset($alat['nama_alat']) ? htmlspecialchars($alat['nama_alat']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">
                    <i class="fa-solid fa-align-left" style="margin-right: 5px; color: var(--text-muted);"></i> Deskripsi / Spesifikasi
                </label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"><?= isset($alat['deskripsi']) ? htmlspecialchars($alat['deskripsi']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="stok">
                    <i class="fa-solid fa-cubes" style="margin-right: 5px; color: var(--text-muted);"></i> Jumlah Stok
                </label>
                <input type="number" id="stok" name="stok" class="form-control" min="0"
                       value="<?= isset($alat['stok']) ? $alat['stok'] : '0'; ?>" required>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                </button>
                <a href="index.php?c=admin&a=alat" class="btn" style="background-color: var(--text-muted); color: white;">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>

```

## index.php

```php

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

```

## FOLDER kategori

## form.php

```php

       <?php require_once BASE_PATH . '/views/admin/templates/header.php'; ?>

    <div class="header-action">
        <div>
            <h3>
                <i class="fa-solid fa-folder-pen" style="color: var(--primary-color); margin-right: 8px;"></i>
                <?= isset($title) ? $title : 'Form Kategori'; ?>
            </h3>
            <p style="color: var(--text-muted); font-size: 14px;">Silakan masukkan nama kategori alat dengan benar.</p>
        </div>
    </div>

    <div class="card" style="max-width: 500px;">
        <form action="<?= $action_url; ?>" method="POST">
            <div class="form-group">
                <label for="nama_kategori">
                    <i class="fa-solid fa-tag" style="margin-right: 5px; color: var(--text-muted);"></i> Nama Kategori
                </label>
                <input type="text" id="nama_kategori" name="nama_kategori" class="form-control"
                       value="<?= isset($kategori['nama_kategori']) ? htmlspecialchars($kategori['nama_kategori']) : ''; ?>" required autofocus>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                </button>
                <a href="index.php?c=admin&a=kategori" class="btn" style="background-color: var(--text-muted); color: white;">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>

```

## index.php

```php

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

```

## FOLDER peminjaman

## detail.php

```php

        <?php
    $title = "Detail Peminjaman";
    require_once BASE_PATH . '/views/admin/templates/header.php';
    ?>

    <div class="header-action">
        <div>
            <h3>Rincian Barang Pinjaman</h3>
            <p style="color: var(--text-muted); font-size: 14px;">Daftar alat pada ID Transaksi: #<?= htmlspecialchars($_GET['id']); ?></p>
        </div>
        <a href="index.php?c=admin&a=peminjaman" class="btn" style="background-color: var(--text-muted); color: white;">&larr; Kembali</a>
    </div>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Alat</th>
                    <th width="20%" style="text-align: center;">Jumlah Dipinjam</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($detail_alat) && count($detail_alat) > 0):
                    $no = 1;
                    foreach($detail_alat as $item):
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td style="font-weight: 500; font-size: 1.1rem; color: var(--primary-color);">
                        <?= htmlspecialchars($item['nama_alat']); ?>
                    </td>
                    <td style="text-align: center; font-weight: bold; font-size: 1.1rem;">
                        <?= $item['jumlah']; ?> Unit
                    </td>
                </tr>
                <?php
                    endforeach;
                else:
                ?>
                <tr><td colspan="3" style="text-align: center;">Tidak ada detail barang.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>

```

## index.php

```php


        <?php
    $title = "Data Peminjaman";
    require_once BASE_PATH . '/views/admin/templates/header.php';
    ?>

    <div class="header-action">
        <p>Pantau seluruh riwayat transaksi peminjaman dan pengembalian alat di sini.</p>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Petugas ACC</th>
                    <th style="text-align: center;">Status</th>
                    <th width="10%" style="text-align: center;">Aksi</th>
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
                    <td>
                        <?= $row['nama_petugas'] ? htmlspecialchars($row['nama_petugas']) : '-'; ?>
                    </td>
                    <td style="text-align: center;">
                        <span style="<?= $badge_style; ?> padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                            <?= htmlspecialchars($row['status']); ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="index.php?c=admin&a=detailPeminjaman&id=<?= $row['id_peminjaman']; ?>" class="btn btn-sm" style="background: #64748b; color: white;"><i class="fa-solid fa-eye"></i> Detail</a>
                    </td>
                </tr>
                <?php
                    endforeach;
                else:
                ?>
                <tr><td colspan="7" style="text-align: center; padding: 30px;">Belum ada data transaksi peminjaman.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>


```

## FOLDER templates

## footer.php

```php

</div> </main> </div> <?php require_once BASE_PATH . '/views/components/confirm.php'; ?>
<?php require_once BASE_PATH . '/views/components/alert.php'; ?>

</body>
</html>

```

## header.php

```php


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


```

## Folder user

## form.php

```php

        <?php
    require_once BASE_PATH . '/views/admin/templates/header.php';
    ?>

    <div class="header-action">
        <div>
            <h3>
                <i class="fa-solid fa-user-pen" style="color: var(--primary-color); margin-right: 8px;"></i>
                <?= isset($title) ? $title : 'Form Pengguna'; ?>
            </h3>
            <p style="color: var(--text-muted); font-size: 14px;">Silakan isi kelengkapan data form di bawah ini dengan benar.</p>
        </div>
    </div>

    <div class="card" style="max-width: 500px;">
        <form action="<?= $action_url; ?>" method="POST">

            <div class="form-group">
                <label for="nama_lengkap">
                    <i class="fa-regular fa-id-card" style="margin-right: 5px; color: var(--text-muted);"></i> Nama Lengkap
                </label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control"
                       value="<?= isset($user['nama_lengkap']) ? htmlspecialchars($user['nama_lengkap']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="username">
                    <i class="fa-solid fa-at" style="margin-right: 5px; color: var(--text-muted);"></i> Username (Untuk Login)
                </label>
                <input type="text" id="username" name="username" class="form-control"
                       value="<?= isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fa-solid fa-lock" style="margin-right: 5px; color: var(--text-muted);"></i> Password
                    <?= isset($user) ? '<small style="color:#ef4444; font-weight:normal;">(Kosongkan jika tidak ingin diubah)</small>' : ''; ?>
                </label>
                <input type="password" id="password" name="password" class="form-control" <?= isset($user) ? '' : 'required'; ?>>
            </div>

            <div class="form-group">
                <label for="level">
                    <i class="fa-solid fa-user-shield" style="margin-right: 5px; color: var(--text-muted);"></i> Hak Akses (Level)
                </label>
                <select id="level" name="level" class="form-control" required style="background-color: white;">
                    <option value="peminjam" <?= (isset($user['level']) && $user['level'] == 'peminjam') ? 'selected' : ''; ?>>Peminjam</option>
                    <option value="petugas" <?= (isset($user['level']) && $user['level'] == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                    <option value="admin" <?= (isset($user['level']) && $user['level'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                </button>
                <a href="index.php?c=admin&a=user" class="btn" style="background-color: var(--text-muted); color: white;">
                    <i class="fa-solid fa-arrow-rotate-left"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>

```

## index.php

```php


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


```

## dashboard.php

```php

        <?php
    $title = "Dashboard";
    require_once BASE_PATH . '/views/admin/templates/header.php';
    ?>

    <div class="card" style="margin-bottom: 20px;">
        <h3>
            <i class="fa-solid fa-gauge-high" style="color: var(--primary-color); margin-right: 8px;"></i>
            Selamat Datang di Panel Administrator!
        </h3>
        <p style="color: var(--text-muted); margin-top: 5px; margin-left: 32px;">
            Di sini Anda dapat mengelola data master pengguna, alat, kategori, dan memantau seluruh transaksi peminjaman.
        </p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h4 style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-boxes-stacked" style="color: var(--primary-color);"></i> Total Alat
            </h4>
            <div class="number"><?= isset($total_alat) ? $total_alat : 0; ?></div>
        </div>

        <div class="stat-card">
            <h4 style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-users" style="color: var(--primary-color);"></i> Total Pengguna
            </h4>
            <div class="number"><?= isset($total_user) ? $total_user : 0; ?></div>
        </div>

        <div class="stat-card" style="border-left-color: #10b981;">
            <h4 style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-clipboard-check" style="color: #10b981;"></i> Peminjaman Aktif
            </h4>
            <div class="number"><?= isset($total_peminjaman) ? $total_peminjaman : 0; ?></div>
        </div>
    </div>

    <?php require_once BASE_PATH . '/views/admin/templates/footer.php'; ?>

```

## FOLDER auth

## FOLDER templates

## footer.php

```php

</body>
</html>

```

## header.php

```php

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Aplikasi Peminjaman Alat</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <?php require_once BASE_PATH . '/views/components/confirm.php'; ?>
        <?php require_once BASE_PATH . '/views/components/alert.php'; ?>
        <style>
            /* Tambahan CSS khusus untuk layout halaman login agar ke tengah */
            .login-wrapper {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                background-color: var(--bg-color);
            }
            .login-card {
                width: 100%;
                max-width: 400px;
            }
            .login-header {
                text-align: center;
                margin-bottom: 24px;
            }
            .login-header h2 {
                color: var(--primary-color);
                margin-bottom: 8px;
            }
            .alert-error {
                background-color: #fee2e2;
                color: #b91c1c;
                padding: 12px;
                border-radius: var(--radius);
                margin-bottom: 20px;
                font-size: 14px;
                text-align: center;
                border: 1px solid #f87171;
            }

            .auth-wrapper {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                background-color: var(--bg-color);
            }
            .auth-card {
                width: 100%;
                max-width: 450px;
            }
            .auth-header {
                text-align: center;
                margin-bottom: 24px;
            }
            .auth-header h2 {
                color: var(--primary-color);
                margin-bottom: 8px;
            }
            .alert-error {
                background-color: #fee2e2;
                color: #b91c1c;
                padding: 12px;
                border-radius: var(--radius);
                margin-bottom: 20px;
                font-size: 14px;
                text-align: center;
                border: 1px solid #f87171;
            }
            .alert-success {
                background-color: #dcfce3;
                color: #166534;
                padding: 12px;
                border-radius: var(--radius);
                margin-bottom: 20px;
                font-size: 14px;
                text-align: center;
                border: 1px solid #86efac;
            }
            .link-text {
                display: block;
                text-align: center;
                margin-top: 15px;
                font-size: 14px;
                color: var(--text-muted);
            }
            .link-text a {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
            }
            .link-text a:hover {
                text-decoration: underline;
            }
        </style>
    </head>

```

## login.php

```php

        <?php require_once __DIR__ . '/templates/header.php'; ?>

    <div class="login-wrapper">
        <div class="card login-card" style="box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-radius: 12px; padding: 30px;">

            <div class="login-header" style="text-align: center; margin-bottom: 25px;">
                <h2 style="color: var(--primary-color); margin-bottom: 5px;">
                    <i class="fa-solid fa-toolbox" style="margin-right: 8px;"></i>SIMPEL Alat
                </h2>
                <p style="color: var(--text-muted); font-size: 14px;">Silakan login untuk melanjutkan</p>
            </div>

            <?php if(!empty($error)): ?>
                <div class="alert-error" style="background-color: #fee2e2; color: #b91c1c; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #ef4444;">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-right: 5px;"></i> <?= $error; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?c=auth&a=login" method="POST">
                <div class="form-group">
                    <label for="username">
                        <i class="fa-solid fa-user" style="color: var(--text-muted); margin-right: 5px;"></i> Username
                    </label>
                    <input type="text" id="username" name="username" class="form-control" value="<?= isset($old_username) ? htmlspecialchars($old_username) : ''; ?>" required autocomplete="off" autofocus placeholder="Masukkan username...">
                </div>

                <div class="form-group" style="margin-top: 15px;">
                    <label for="password">
                        <i class="fa-solid fa-lock" style="color: var(--text-muted); margin-right: 5px;"></i> Password
                    </label>
                    <input type="password" id="password" name="password" class="form-control" value="<?= isset($old_password) ? htmlspecialchars($old_password) : ''; ?>" required placeholder="Masukkan password...">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 25px; padding: 12px; font-size: 16px; font-weight: bold;">
                    <i class="fa-solid fa-right-to-bracket" style="margin-right: 5px;"></i> Masuk
                </button>

                <div style="text-align: center; margin-top: 20px; padding-top: 15px; font-size: 14px; color: var(--text-muted); border-top: 1px solid var(--border-color);">
                    Belum punya akun? <br>
                    <a href="index.php?c=auth&a=register" style="color: var(--primary-color); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 8px;">
                        <i class="fa-solid fa-user-plus" style="margin-right: 5px;"></i> Daftar sebagai Peminjam
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php require_once __DIR__ . '/templates/footer.php'; ?>

```

## register.php

```php

        <?php require_once __DIR__ . '/templates/header.php'; ?>

    <div class="auth-wrapper">
        <div class="card auth-card" style="box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-radius: 12px; padding: 30px; max-width: 450px; margin: 0 auto;">

            <div class="auth-header" style="text-align: center; margin-bottom: 25px;">
                <h2 style="color: var(--primary-color); margin-bottom: 5px;">
                    <i class="fa-solid fa-user-plus" style="margin-right: 8px;"></i>Daftar Akun Baru
                </h2>
                <p style="color: var(--text-muted); font-size: 14px;">Lengkapi data diri Anda sebagai Peminjam</p>
            </div>

            <?php if(!empty($error)): ?>
                <div class="alert-error" style="background-color: #fee2e2; color: #b91c1c; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #ef4444;">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-right: 5px;"></i> <?= $error; ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($success)): ?>
                <div class="alert-success" style="background-color: #dcfce3; color: #166534; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border-left: 4px solid #22c55e;">
                    <i class="fa-solid fa-circle-check" style="margin-right: 5px;"></i> <?= $success; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?c=auth&a=register" method="POST">
                <div class="form-group">
                    <label for="nama_lengkap">
                        <i class="fa-regular fa-id-card" style="color: var(--text-muted); margin-right: 5px;"></i> Nama Lengkap
                    </label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" required autocomplete="off" autofocus placeholder="Contoh: Budi Santoso">
                </div>

                <div class="form-group" style="margin-top: 15px;">
                    <label for="username">
                        <i class="fa-solid fa-user" style="color: var(--text-muted); margin-right: 5px;"></i> Username
                    </label>
                    <input type="text" id="username" name="username" class="form-control" required autocomplete="off" placeholder="Buat username baru...">
                </div>

                <div class="form-group" style="margin-top: 15px;">
                    <label for="password">
                        <i class="fa-solid fa-lock" style="color: var(--text-muted); margin-right: 5px;"></i> Password
                    </label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Buat kata sandi yang kuat...">
                </div>

                <button type="submit" class="btn btn-success" style="width: 100%; margin-top: 25px; padding: 12px; font-size: 16px; font-weight: bold;">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 5px;"></i> Daftar Sekarang
                </button>

                <div style="text-align: center; margin-top: 20px; padding-top: 15px; font-size: 14px; color: var(--text-muted); border-top: 1px solid var(--border-color);">
                    Sudah punya akun? <br>
                    <a href="index.php?c=auth&a=login" style="color: var(--primary-color); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 8px;">
                        <i class="fa-solid fa-right-to-bracket" style="margin-right: 5px;"></i> Login di sini
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php require_once __DIR__ . '/templates/footer.php'; ?>

```

## FOLDER components

## alert.php

```php

        <?php if (isset($_SESSION['flash'])): ?>
        <div class="swal-overlay show" id="customAlert">
            <div class="swal-modal">
                <div class="swal-icon <?= $_SESSION['flash']['type']; ?>">
                    <?php
                        if($_SESSION['flash']['type'] == 'success') echo '✓';
                        elseif($_SESSION['flash']['type'] == 'error') echo '✗';
                        else echo '!'; // Untuk warning
                    ?>
                </div>

                <h3 class="swal-title"><?= $_SESSION['flash']['title']; ?></h3>
                <p class="swal-text"><?= $_SESSION['flash']['message']; ?></p>

                <button class="swal-btn <?= $_SESSION['flash']['type'] == 'error' ? 'error' : ''; ?>"
                        onclick="document.getElementById('customAlert').classList.remove('show')">
                    OK Mengerti
                </button>
            </div>
        </div>

        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

```

## confirm.php

```php

        <div class="swal-overlay" id="customConfirm">
        <div class="swal-modal">
            <div class="swal-icon warning">!</div>

            <h3 class="swal-title" id="confirmTitle">Konfirmasi</h3>
            <p class="swal-text" id="confirmText">Apakah Anda yakin ingin melanjutkan?</p>

            <div class="swal-actions">
                <button class="swal-btn cancel" onclick="closeConfirm()">Batal</button>
                <a href="#" id="btnConfirmAction" class="swal-btn error">Ya, Lanjutkan!</a>
            </div>
        </div>
    </div>

    <script>
        function showConfirm(url, itemName = '', actionType = 'delete') {
            var titleEl = document.getElementById('confirmTitle');
            var textEl = document.getElementById('confirmText');
            var btnEl = document.getElementById('btnConfirmAction');

            // 1. Jika tombol Logout
            if (actionType === 'logout') {
                titleEl.innerText = "Konfirmasi Keluar";
                textEl.innerText = "Apakah Anda yakin ingin keluar dari aplikasi?";
                btnEl.innerText = "Ya, Keluar!";
                btnEl.style.backgroundColor = "#f59e0b"; // Oranye
            }
            // 2. Jika tombol Setujui Peminjaman
            else if (actionType === 'approve') {
                titleEl.innerText = "Konfirmasi Persetujuan";
                textEl.innerText = "Apakah Anda yakin ingin menyetujui pengajuan peminjaman ini?";
                btnEl.innerText = "Ya, Setujui!";
                btnEl.style.backgroundColor = "#10b981"; // Hijau
            }
            // 3. Jika tombol Tolak Peminjaman
            else if (actionType === 'reject') {
                titleEl.innerText = "Konfirmasi Penolakan";
                textEl.innerText = "Apakah Anda yakin ingin menolak pengajuan peminjaman ini?";
                btnEl.innerText = "Ya, Tolak!";
                btnEl.style.backgroundColor = "#ef4444"; // Merah
            }
            // 4. Jika tombol Terima Pengembalian
            else if (actionType === 'return') {
                titleEl.innerText = "Konfirmasi Pengembalian";
                textEl.innerText = "Apakah alat sudah dikembalikan oleh siswa dengan kondisi baik?";
                btnEl.innerText = "Ya, Terima Alat!";
                btnEl.style.backgroundColor = "#8b5cf6"; // Ungu
            }
            // 5. Default (Tombol Hapus Data)
            else {
                titleEl.innerText = "Konfirmasi Hapus";
                textEl.innerText = "Apakah Anda yakin ingin menghapus '" + itemName + "'? Tindakan ini tidak dapat dibatalkan.";
                btnEl.innerText = "Ya, Hapus!";
                btnEl.style.backgroundColor = "#ef4444"; // Merah
            }

            // Pasang URL tujuan ke tombol aksi
            btnEl.href = url;

            // Tampilkan modal
            document.getElementById('customConfirm').classList.add('show');
        }

        function closeConfirm() {
            document.getElementById('customConfirm').classList.remove('show');
        }
    </script>



```

## FOLDER peminjam

## FOLDER templates

## footer.php

```php

    </div>
        </main>
    </div>

    <?php require_once BASE_PATH . '/views/components/confirm.php'; ?>
    <?php require_once BASE_PATH . '/views/components/alert.php'; ?>
    </body>
    </html>

```

## header.php

```php

        <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= isset($title) ? $title : 'Peminjam'; ?> - Aplikasi Peminjaman</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
    <div class="dashboard-wrapper">
        <aside class="sidebar" style="background-color: #0f172a;"> <div class="sidebar-header">
        <i class="fa-solid fa-toolbox" style="margin-right: 8px;">
                <h3>SIMPEL Alat</h3></i>
            </div>
            <ul class="sidebar-menu">
                <?php $a = isset($_GET['a']) ? strtolower($_GET['a']) : 'dashboard'; ?>
                <li class="<?= $a == 'dashboard' ? 'active' : ''; ?>">
                    <a href="index.php?c=peminjam&a=dashboard"><i class="fa-solid fa-boxes-stacked"></i> Katalog Alat</a>
                </li>
                <li class="<?= $a == 'keranjang' ? 'active' : ''; ?>">
                    <a href="index.php?c=peminjam&a=keranjang">
                        <i class="fa-solid fa-cart-shopping"></i> Keranjang Saya
                        <?php if(count($_SESSION['keranjang']) > 0): ?>
                            <span style="background: #ef4444; color: white; padding: 2px 6px; border-radius: 50%; font-size: 11px; margin-left: 5px;"><?= count($_SESSION['keranjang']); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="<?= $a == 'riwayat' ? 'active' : ''; ?>">
                    <a href="index.php?c=peminjam&a=riwayat"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Peminjaman</a>
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
                <h2><?= isset($title) ? $title : 'Panel Peminjam'; ?></h2>
                <div class="user-profile">
                    <span style="font-weight: 500;">Halo, <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'User'); ?></span>
                    <span style="font-size: 12px; background: #64748b; color: white; padding: 2px 8px; border-radius: 12px; margin-left: 10px;">Peminjam</span>
                </div>
            </header>

            <div class="content-area">

```

## dashboard.php

```php


        <?php require_once BASE_PATH . '/views/peminjam/templates/header.php'; ?>

    <style>
        .katalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .alat-card {
            background: white; border: 1px solid var(--border-color);
            border-radius: var(--radius); padding: 20px;
            box-shadow: var(--shadow); display: flex; flex-direction: column;
        }
        .alat-kategori { font-size: 12px; color: var(--primary-color); font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .alat-nama { font-size: 1.1rem; color: var(--text-main); margin-bottom: 10px; font-weight: 600; }
        .alat-stok { font-size: 13px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color); }
        .stok-badge { background: #dcfce3; color: #166534; padding: 3px 8px; border-radius: 4px; font-weight: bold; }
        .stok-habis { background: #fee2e2; color: #b91c1c; padding: 3px 8px; border-radius: 4px; font-weight: bold; }
        .form-pinjam { margin-top: auto; display: flex; gap: 10px; }
    </style>

    <div class="card" style="margin-bottom: 20px;">
        <h3>Katalog Peminjaman Alat</h3>
        <p style="color: var(--text-muted); font-size: 14px;">Silakan pilih alat yang ingin Anda pinjam. Tentukan jumlahnya, lalu masukkan ke keranjang.</p>
    </div>

    <div class="katalog-grid">
        <?php if(count($data_alat) > 0): ?>
            <?php foreach($data_alat as $alat): ?>
                <div class="alat-card">
                    <div class="alat-kategori"><?= htmlspecialchars($alat['nama_kategori'] ?? 'Umum'); ?></div>
                    <div class="alat-nama"><?= htmlspecialchars($alat['nama_alat']); ?></div>
                    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 15px; flex: 1;">
                        <?= htmlspecialchars($alat['deskripsi']); ?>
                    </div>

                    <div class="alat-stok">
                        Stok Tersedia:
                        <?php if($alat['stok'] > 0): ?>
                            <span class="stok-badge"><?= $alat['stok']; ?> Unit</span>
                        <?php else: ?>
                            <span class="stok-habis">Habis</span>
                        <?php endif; ?>
                    </div>

                    <?php if($alat['stok'] > 0): ?>
                        <form action="index.php?c=peminjam&a=tambahKeranjang" method="POST" class="form-pinjam">
                            <input type="hidden" name="id_alat" value="<?= $alat['id_alat']; ?>">
                            <input type="hidden" name="nama_alat" value="<?= htmlspecialchars($alat['nama_alat']); ?>">
                            <input type="hidden" name="stok_tersedia" value="<?= $alat['stok']; ?>">

                            <input type="number" name="jumlah" min="1" max="<?= $alat['stok']; ?>" value="1"
                                   class="form-control" style="width: 70px; padding: 8px;" required>
                            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 8px;">+ Keranjang</button>
                        </form>
                    <?php else: ?>
                        <button class="btn" style="background: #9ca3af; cursor: not-allowed; width: 100%;" disabled>Stok Habis</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Belum ada alat yang tersedia di sistem.</p>
        <?php endif; ?>
    </div>

    <?php require_once BASE_PATH . '/views/peminjam/templates/footer.php'; ?>



```

## keranjang.php

```php


        <?php
    $title = "Keranjang Saya";
    require_once BASE_PATH . '/views/peminjam/templates/header.php';
    ?>

    <div class="card" style="margin-bottom: 20px;">
        <h3>Daftar Alat yang Akan Dipinjam</h3>
        <p style="color: var(--text-muted); font-size: 14px;">Periksa kembali daftar alat di bawah ini sebelum mengajukan peminjaman.</p>
    </div>

    <div class="table-responsive" style="margin-bottom: 30px;">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Alat</th>
                    <th width="15%" style="text-align: center;">Jumlah</th>
                    <th width="15%" style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($keranjang) > 0):
                    $no = 1;
                    foreach($keranjang as $item):
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td style="font-weight: 500;"><?= htmlspecialchars($item['nama_alat']); ?></td>
                    <td style="text-align: center; font-weight: bold; color: var(--primary-color);"><?= $item['jumlah']; ?> Unit</td>
                    <td style="text-align: center;">
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger"
                           onclick="showConfirm('index.php?c=peminjam&a=hapusKeranjang&id=<?= $item['id_alat']; ?>', '<?= addslashes($item['nama_alat']); ?>')">
                           Batal Pinjam
                        </a>
                    </td>
                </tr>
                <?php
                    endforeach;
                else:
                ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 30px;">
                        <div style="color: var(--text-muted); margin-bottom: 10px;">Keranjang Anda masih kosong.</div>
                        <a href="index.php?c=peminjam&a=dashboard" class="btn btn-primary">Lihat Katalog Alat</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if(count($keranjang) > 0): ?>
    <div class="card" style="max-width: 500px; background-color: #f8fafc; border-color: #cbd5e1;">
        <h4 style="margin-bottom: 15px; color: var(--text-main);">Formulir Pengajuan</h4>

        <form action="index.php?c=peminjam&a=prosesPinjam" method="POST">
            <div class="form-group">
                <label for="tanggal_rencana_kembali">Tanggal Rencana Dikembalikan</label>
                <input type="date" id="tanggal_rencana_kembali" name="tanggal_rencana_kembali" class="form-control"
                       min="<?= date('Y-m-d'); ?>" required style="background-color: white;">
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-success" style="width: 100%; font-size: 16px; padding: 12px;">Ajukan Peminjaman Sekarang</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <?php require_once BASE_PATH . '/views/peminjam/templates/footer.php'; ?>


```

## riwayat.php

```php


        <?php
    $title = "Riwayat Peminjaman";
    require_once BASE_PATH . '/views/peminjam/templates/header.php';
    ?>

    <div class="card" style="margin-bottom: 20px;">
        <h3>Riwayat Transaksi Saya</h3>
        <p style="color: var(--text-muted); font-size: 14px;">Pantau status pengajuan alat yang telah Anda pinjam di sini.</p>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Rencana Kembali</th>
                    <th>Petugas Penanggung Jawab</th>
                    <th width="15%" style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($data_riwayat) > 0):
                    $no = 1;
                    foreach($data_riwayat as $row):
                        // Menentukan warna badge berdasarkan status
                        $badge_style = '';
                        switch($row['status']) {
                            case 'menunggu':
                                $badge_style = 'background: #fef08a; color: #854d0e;'; // Kuning
                                break;
                            case 'disetujui':
                                $badge_style = 'background: #bfdbfe; color: #1e3a8a;'; // Biru
                                break;
                            case 'ditolak':
                                $badge_style = 'background: #fecaca; color: #991b1b;'; // Merah
                                break;
                            case 'selesai':
                                $badge_style = 'background: #dcfce3; color: #166534;'; // Hijau
                                break;
                        }
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <?= date('d M Y', strtotime($row['tanggal_pinjam'])); ?>
                    </td>
                    <td>
                        <span style="font-weight: 500; color: var(--text-main);">
                            <?= date('d M Y', strtotime($row['tanggal_rencana_kembali'])); ?>
                        </span>
                    </td>
                    <td>
                        <?= $row['nama_petugas'] ? htmlspecialchars($row['nama_petugas']) : '<span style="color: var(--text-muted); font-style: italic;">Belum diproses</span>'; ?>
                    </td>
                    <td style="text-align: center;">
                        <span style="<?= $badge_style; ?> padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase;">
                            <?= htmlspecialchars($row['status']); ?>
                        </span>
                    </td>
                </tr>
                <?php
                    endforeach;
                else:
                ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 30px;">Belum ada riwayat peminjaman.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php require_once BASE_PATH . '/views/peminjam/templates/footer.php'; ?>


```

## FOLDER petugas

## FOLDER templates

## footer.php

```php

    </div>
        </main>
    </div>
    <?php require_once BASE_PATH . '/views/components/confirm.php'; ?>
    <?php require_once BASE_PATH . '/views/components/alert.php'; ?>
    </body>
    </html>

```

## header.php

```php

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

```

## dashboard.php

```php


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



```

## detail.php

```php

     <?php
$title = "Detail Peminjaman";
require_once BASE_PATH . '/views/petugas/templates/header.php';

// Cek status transaksi untuk menentukan apakah tombol hapus boleh muncul
$status_transaksi = $data_utama['status'];
?>

<div class="header-action" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h3>Rincian Barang Pinjaman</h3>
        <p style="color: var(--text-muted); font-size: 14px;">
            ID Transaksi: #<?= htmlspecialchars($_GET['id']); ?> | Status: <strong><?= strtoupper($status_transaksi); ?></strong>
        </p>
    </div>
    <a href="index.php?c=petugas&a=dashboard" class="btn btn-secondary" style="background-color: var(--text-muted); color: white;">&larr; Kembali ke Dashboard</a>
</div>

<div class="card">
    <div style="margin-bottom: 15px; padding: 10px; background-color: #e8f4f8; border-left: 4px solid #17a2b8; border-radius: 4px;">
        <p style="margin: 0; font-size: 14px;"><strong>Info:</strong> Pastikan stok tersedia sebelum menyetujui transaksi di Dashboard. Jika ada alat dengan stok kurang, klik "Tolak Alat" untuk menghapusnya dari daftar ini.</p>
    </div>

    <table class="table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 2px solid #eee;">
                <th width="5%" style="padding: 10px; text-align: left;">No</th>
                <th style="padding: 10px; text-align: left;">Nama Alat</th>
                <th width="15%" style="padding: 10px; text-align: center;">Stok Gudang</th>
                <th width="15%" style="padding: 10px; text-align: center;">Jml Diminta</th>
                <?php if($status_transaksi == 'menunggu'): ?>
                <th width="15%" style="padding: 10px; text-align: center;">Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if(isset($detail_alat) && count($detail_alat) > 0):
                $no = 1;
                foreach($detail_alat as $item):
                    // Logika pengecekan stok
                    $stok_kurang = $item['jumlah'] > $item['stok'];
            ?>
            <tr style="<?= ($stok_kurang && $status_transaksi == 'menunggu') ? 'background-color: #ffe6e6;' : '' ?> border-bottom: 1px solid #eee;">
                <td style="padding: 10px;"><?= $no++; ?></td>

                <td style="padding: 10px; font-weight: 500; font-size: 1.1rem; color: var(--primary-color);">
                    <?= htmlspecialchars($item['nama_alat']); ?>
                    <?php if($stok_kurang && $status_transaksi == 'menunggu'): ?>
                        <br><small style="color: #dc3545; font-weight: bold;"><i class="fa-solid fa-triangle-exclamation"></i> Stok Kurang!</small>
                    <?php endif; ?>
                </td>

                <td style="padding: 10px; text-align: center; font-size: 1.1rem; font-weight: <?= $stok_kurang ? 'bold' : 'normal'; ?>; color: <?= $stok_kurang ? '#dc3545' : '#28a745'; ?>;">
                    <?= $item['stok']; ?> Unit
                </td>

                <td style="padding: 10px; text-align: center; font-weight: bold; font-size: 1.1rem;">
                    <?= $item['jumlah']; ?> Unit
                </td>

                <?php if($status_transaksi == 'menunggu'): ?>
                <td style="padding: 10px; text-align: center;">
                    <a href="index.php?c=petugas&a=hapusItem&id=<?= $_GET['id']; ?>&id_alat=<?= $item['id_alat']; ?>"
                       class="btn btn-sm"
                       style="background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 12px;"
                       onclick="return confirm('Apakah Anda yakin ingin menolak dan menghapus alat ini dari daftar peminjaman?');">
                       <i class="fa-solid fa-trash-can"></i> Tolak Alat
                    </a>
                </td>
                <?php endif; ?>
            </tr>
            <?php
                endforeach;
            else:
            ?>
            <tr><td colspan="5" style="text-align: center; padding: 20px;">Tidak ada detail barang pada transaksi ini.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/views/petugas/templates/footer.php'; ?>

```

## laporan.php

```php


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


```

## index.php

```php

        <?php
    // index.php
    session_start();

    // MENDEFINISIKAN JALUR ROOT SECARA ABSOLUT
    define('BASE_PATH', __DIR__);
    // Menangkap parameter dari URL, default ke AuthController (Login)
    $controller = isset($_GET['c']) ? $_GET['c'] : 'auth';
    $action = isset($_GET['a']) ? $_GET['a'] : 'login';

    // Format penamaan controller (contoh: AuthController)
    $controllerName = ucfirst($controller) . 'Controller';
    $controllerFile = 'controllers/' . $controllerName . '.php';

    // Cek apakah file controller ada
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $obj = new $controllerName();

        // Cek apakah method/action ada di dalam controller tersebut
        if (method_exists($obj, $action)) {
            $obj->$action();
        } else {
            die("Error: Method '$action' tidak ditemukan di $controllerName!");
        }
    } else {
        die("Error: Controller '$controllerName' tidak ditemukan!");
    }
    ?>

```
