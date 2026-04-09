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