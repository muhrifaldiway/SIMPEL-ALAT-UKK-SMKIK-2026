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