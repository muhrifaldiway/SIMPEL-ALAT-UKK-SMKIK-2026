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