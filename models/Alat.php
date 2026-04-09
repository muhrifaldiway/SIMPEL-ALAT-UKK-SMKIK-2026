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