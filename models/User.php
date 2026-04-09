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