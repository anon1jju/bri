<?php
/**
 * BRIMOB Logistik & Senpi Management System
 * Class-based Functions
 * Last Updated: 2025-11-21 19:01:38 UTC
 */

// ============================================================
// DATABASE CONNECTION CLASS
// ============================================================
class Database {
    private $host = 'localhost';
    private $db_name = 'zgksnhcdze_brimoblogistik';
    private $username = 'zgksnhcdze_brimob';
    private $password = 'brimob123';
    private $charset = 'utf8mb4';
    public $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . 
                ";dbname=" . $this->db_name . 
                ";charset=" . $this->charset,
                $this->username,
                $this->password
            );
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            return $this->conn;
        } catch(PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database Connection Failed: ' . $e->getMessage()]);
            exit;
        }
    }
}

// ============================================================
// SENPI (WEAPON) MANAGEMENT CLASS
// ============================================================
class Senpi {
    private $db;
    private $table = 'data_pemegang_senpi';
    private $jenis_table = 'jenis_senpi';

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all senpi data
     */
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY no ASC";
        
        if($limit) {
            $query .= " LIMIT " . intval($limit) . " OFFSET " . intval($offset);
        }
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get senpi by ID
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data = $stmt->fetch();
            
            if($data) {
                return ['status' => 'success', 'data' => $data];
            } else {
                return ['status' => 'error', 'message' => 'Data tidak ditemukan'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Add new senpi
     */
    public function add($no, $jenis_senpi, $no_senpi, $nama_pemegang, $pangkat_nrp, $keterangan = 'GUDANG') {
        $query = "INSERT INTO " . $this->table . " 
                  (no, jenis_senpi, no_senpi, nama_pemegang, pangkat_nrp, keterangan) 
                  VALUES (:no, :jenis_senpi, :no_senpi, :nama_pemegang, :pangkat_nrp, :keterangan)";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':no', $no);
            $stmt->bindParam(':jenis_senpi', $jenis_senpi);
            $stmt->bindParam(':no_senpi', $no_senpi);
            $stmt->bindParam(':nama_pemegang', $nama_pemegang);
            $stmt->bindParam(':pangkat_nrp', $pangkat_nrp);
            $stmt->bindParam(':keterangan', $keterangan);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Senpi berhasil ditambahkan', 'id' => $this->db->lastInsertId()];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Update senpi
     */
    public function update($id, $no, $jenis_senpi, $no_senpi, $nama_pemegang, $pangkat_nrp, $keterangan = 'GUDANG') {
        $query = "UPDATE " . $this->table . " 
                  SET no = :no, 
                      jenis_senpi = :jenis_senpi, 
                      no_senpi = :no_senpi, 
                      nama_pemegang = :nama_pemegang, 
                      pangkat_nrp = :pangkat_nrp, 
                      keterangan = :keterangan, 
                      updated_at = NOW()
                  WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':no', $no);
            $stmt->bindParam(':jenis_senpi', $jenis_senpi);
            $stmt->bindParam(':no_senpi', $no_senpi);
            $stmt->bindParam(':nama_pemegang', $nama_pemegang);
            $stmt->bindParam(':pangkat_nrp', $pangkat_nrp);
            $stmt->bindParam(':keterangan', $keterangan);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Senpi berhasil diperbarui'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete senpi
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Senpi berhasil dihapus'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Search senpi
     */
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE nama_pemegang LIKE :keyword 
                  OR pangkat_nrp LIKE :keyword 
                  OR jenis_senpi LIKE :keyword
                  OR no_senpi LIKE :keyword
                  ORDER BY no ASC";
        
        try {
            $stmt = $this->db->prepare($query);
            $search_term = "%{$keyword}%";
            $stmt->bindParam(':keyword', $search_term);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get senpi by status
     */
    public function getByStatus($status) {
        $query = "SELECT * FROM " . $this->table . " WHERE keterangan = :status ORDER BY no ASC";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get jenis senpi
     */
    public function getJenisSenpi() {
        $query = "SELECT * FROM " . $this->jenis_table . " ORDER BY nama_jenis ASC";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Count senpi
     */
    public function count() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch()['total'];
        } catch(PDOException $e) {
            return 0;
        }
    }
}

// ============================================================
// LOGISTIK MANAGEMENT CLASS
// ============================================================
class Logistik {
    private $db;
    private $table = 'data_logistik';

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all logistik
     */
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        
        if($limit) {
            $query .= " LIMIT " . intval($limit) . " OFFSET " . intval($offset);
        }
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get logistik by ID
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data = $stmt->fetch();
            
            if($data) {
                return ['status' => 'success', 'data' => $data];
            } else {
                return ['status' => 'error', 'message' => 'Data tidak ditemukan'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Add new logistik
     */
    public function add($nama_barang, $kode_barang = null, $jumlah, $satuan = 'Buah', 
                       $kondisi = 'Baik', $lokasi = 'Gudang Logistik', $keterangan = null) {
        $query = "INSERT INTO " . $this->table . " 
                  (nama_barang, kode_barang, jumlah, satuan, kondisi, lokasi, keterangan) 
                  VALUES (:nama_barang, :kode_barang, :jumlah, :satuan, :kondisi, :lokasi, :keterangan)";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nama_barang', $nama_barang);
            $stmt->bindParam(':kode_barang', $kode_barang);
            $stmt->bindParam(':jumlah', $jumlah);
            $stmt->bindParam(':satuan', $satuan);
            $stmt->bindParam(':kondisi', $kondisi);
            $stmt->bindParam(':lokasi', $lokasi);
            $stmt->bindParam(':keterangan', $keterangan);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Logistik berhasil ditambahkan', 'id' => $this->db->lastInsertId()];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Update logistik
     */
    public function update($id, $nama_barang, $kode_barang = null, $jumlah, $satuan = 'Buah', 
                          $kondisi = 'Baik', $lokasi = 'Gudang Logistik', $keterangan = null) {
        $query = "UPDATE " . $this->table . " 
                  SET nama_barang = :nama_barang, 
                      kode_barang = :kode_barang, 
                      jumlah = :jumlah, 
                      satuan = :satuan, 
                      kondisi = :kondisi, 
                      lokasi = :lokasi, 
                      keterangan = :keterangan, 
                      updated_at = NOW()
                  WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama_barang', $nama_barang);
            $stmt->bindParam(':kode_barang', $kode_barang);
            $stmt->bindParam(':jumlah', $jumlah);
            $stmt->bindParam(':satuan', $satuan);
            $stmt->bindParam(':kondisi', $kondisi);
            $stmt->bindParam(':lokasi', $lokasi);
            $stmt->bindParam(':keterangan', $keterangan);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Logistik berhasil diperbarui'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete logistik
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Logistik berhasil dihapus'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Search logistik
     */
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE nama_barang LIKE :keyword 
                  OR kode_barang LIKE :keyword 
                  OR lokasi LIKE :keyword
                  ORDER BY id DESC";
        
        try {
            $stmt = $this->db->prepare($query);
            $search_term = "%{$keyword}%";
            $stmt->bindParam(':keyword', $search_term);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get logistik by kondisi
     */
    public function getByKondisi($kondisi) {
        $query = "SELECT * FROM " . $this->table . " WHERE kondisi = :kondisi ORDER BY id DESC";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':kondisi', $kondisi);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get logistik by lokasi
     */
    public function getByLokasi($lokasi) {
        $query = "SELECT * FROM " . $this->table . " WHERE lokasi = :lokasi ORDER BY id DESC";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':lokasi', $lokasi);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Update jumlah logistik
     */
    public function updateJumlah($id, $jumlah_perubahan, $tipe = 'kurang') {
        try {
            $logistik = $this->getById($id);
            if($logistik['status'] != 'success') {
                return $logistik;
            }

            $jumlah_baru = $tipe == 'kurang' 
                ? $logistik['data']['jumlah'] - $jumlah_perubahan 
                : $logistik['data']['jumlah'] + $jumlah_perubahan;

            if($jumlah_baru < 0) {
                return ['status' => 'error', 'message' => 'Jumlah tidak boleh negatif'];
            }

            $query = "UPDATE " . $this->table . " SET jumlah = :jumlah, updated_at = NOW() WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':jumlah', $jumlah_baru);
            $stmt->bindParam(':id', $id);

            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Jumlah berhasil diperbarui', 'jumlah_baru' => $jumlah_baru];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Count logistik
     */
    public function count() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch()['total'];
        } catch(PDOException $e) {
            return 0;
        }
    }

    /**
     * Get logistik statistics
     */
    public function getStats() {
        try {
            $total = $this->count();
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM " . $this->table . " WHERE kondisi = 'Baik'");
            $stmt->execute();
            $baik = $stmt->fetch()['total'];
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM " . $this->table . " WHERE kondisi IN ('Rusak Ringan', 'Rusak Berat')");
            $stmt->execute();
            $rusak = $stmt->fetch()['total'];
            
            return [
                'status' => 'success',
                'total' => $total,
                'baik' => $baik,
                'rusak' => $rusak
            ];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

// ============================================================
// PEMINJAMAN DINAS MANAGEMENT CLASS
// ============================================================
class PeminjamanDinas {
    private $db;
    private $table = 'peminjaman_dinas';
    private $items_table = 'peminjaman_dinas_items';

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all peminjaman
     */
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        
        if($limit) {
            $query .= " LIMIT " . intval($limit) . " OFFSET " . intval($offset);
        }
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get peminjaman by ID with items
     */
    public function getById($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $data = $stmt->fetch();
            
            if(!$data) {
                return ['status' => 'error', 'message' => 'Peminjaman tidak ditemukan'];
            }

            // Get items
            $query_items = "SELECT * FROM " . $this->items_table . " WHERE id_peminjaman_dinas = :id";
            $stmt_items = $this->db->prepare($query_items);
            $stmt_items->bindParam(':id', $id);
            $stmt_items->execute();
            $data['items'] = $stmt_items->fetchAll();

            return ['status' => 'success', 'data' => $data];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Create new peminjaman
     */
    public function create($nama_tugas, $penanggung_jawab_nrp, $penanggung_jawab_nama, 
                          $tanggal_mulai, $tanggal_selesai_estimasi, $tipe_peminjaman = 'Dinas', $keterangan = null) {
        $query = "INSERT INTO " . $this->table . " 
                  (nama_tugas, penanggung_jawab_nrp, penanggung_jawab_nama, tanggal_mulai, 
                   tanggal_selesai_estimasi, status, tipe_peminjaman, keterangan) 
                  VALUES (:nama_tugas, :penanggung_jawab_nrp, :penanggung_jawab_nama, :tanggal_mulai, 
                          :tanggal_selesai_estimasi, 'Berlangsung', :tipe_peminjaman, :keterangan)";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nama_tugas', $nama_tugas);
            $stmt->bindParam(':penanggung_jawab_nrp', $penanggung_jawab_nrp);
            $stmt->bindParam(':penanggung_jawab_nama', $penanggung_jawab_nama);
            $stmt->bindParam(':tanggal_mulai', $tanggal_mulai);
            $stmt->bindParam(':tanggal_selesai_estimasi', $tanggal_selesai_estimasi);
            $stmt->bindParam(':tipe_peminjaman', $tipe_peminjaman);
            $stmt->bindParam(':keterangan', $keterangan);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Peminjaman berhasil dibuat', 'id' => $this->db->lastInsertId()];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Update peminjaman
     */
    public function update($id, $nama_tugas, $penanggung_jawab_nrp, $penanggung_jawab_nama, 
                          $tanggal_mulai, $tanggal_selesai_estimasi, $status = 'Berlangsung', $keterangan = null) {
        $query = "UPDATE " . $this->table . " 
                  SET nama_tugas = :nama_tugas, 
                      penanggung_jawab_nrp = :penanggung_jawab_nrp,
                      penanggung_jawab_nama = :penanggung_jawab_nama,
                      tanggal_mulai = :tanggal_mulai,
                      tanggal_selesai_estimasi = :tanggal_selesai_estimasi,
                      status = :status,
                      keterangan = :keterangan
                  WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama_tugas', $nama_tugas);
            $stmt->bindParam(':penanggung_jawab_nrp', $penanggung_jawab_nrp);
            $stmt->bindParam(':penanggung_jawab_nama', $penanggung_jawab_nama);
            $stmt->bindParam(':tanggal_mulai', $tanggal_mulai);
            $stmt->bindParam(':tanggal_selesai_estimasi', $tanggal_selesai_estimasi);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':keterangan', $keterangan);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Peminjaman berhasil diperbarui'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Add item to peminjaman
     */
    public function addItem($id_peminjaman_dinas, $tipe_item, $id_item, $nama_item, $no_seri_item = null, $jumlah = 1) {
        $query = "INSERT INTO " . $this->items_table . " 
                  (id_peminjaman_dinas, tipe_item, id_item, nama_item, no_seri_item, jumlah, status_item) 
                  VALUES (:id_peminjaman_dinas, :tipe_item, :id_item, :nama_item, :no_seri_item, :jumlah, 'Dipinjam')";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_peminjaman_dinas', $id_peminjaman_dinas);
            $stmt->bindParam(':tipe_item', $tipe_item);
            $stmt->bindParam(':id_item', $id_item);
            $stmt->bindParam(':nama_item', $nama_item);
            $stmt->bindParam(':no_seri_item', $no_seri_item);
            $stmt->bindParam(':jumlah', $jumlah);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Item berhasil ditambahkan', 'id' => $this->db->lastInsertId()];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Return item
     */
    public function returnItem($item_id, $tanggal_kembali = null) {
        if(!$tanggal_kembali) {
            $tanggal_kembali = date('Y-m-d H:i:s');
        }

        $query = "UPDATE " . $this->items_table . " 
                  SET status_item = 'Dikembalikan', tanggal_kembali_aktual = :tanggal_kembali 
                  WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $item_id);
            $stmt->bindParam(':tanggal_kembali', $tanggal_kembali);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Item berhasil dikembalikan'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Close peminjaman
     */
    public function close($id) {
        $query = "UPDATE " . $this->table . " SET status = 'Selesai' WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Peminjaman berhasil ditutup'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete peminjaman
     */
    public function delete($id) {
        try {
            // Delete items first
            $query_items = "DELETE FROM " . $this->items_table . " WHERE id_peminjaman_dinas = :id";
            $stmt_items = $this->db->prepare($query_items);
            $stmt_items->bindParam(':id', $id);
            $stmt_items->execute();

            // Delete peminjaman
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Peminjaman berhasil dihapus'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get peminjaman by status
     */
    public function getByStatus($status) {
        $query = "SELECT * FROM " . $this->table . " WHERE status = :status ORDER BY created_at DESC";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Count peminjaman
     */
    public function count($status = null) {
        if($status) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = :status";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        } else {
            $query = "SELECT COUNT(*) as total FROM " . $this->table;
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }
        
        try {
            return $stmt->fetch()['total'];
        } catch(PDOException $e) {
            return 0;
        }
    }
}

// ============================================================
// PEMINJAMAN LOG MANAGEMENT CLASS
// ============================================================
class PeminjamanLog {
    private $db;
    private $table = 'peminjaman_log';

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Create log entry
     */
    public function log($senpi_id, $nama_pemegang, $pangkat_nrp, $jenis_senpi, $no_senpi, 
                       $jenis_peminjaman, $keterangan = null, $tanggal_pinjam = null, $tanggal_kembali = null, $status = 'dipinjam') {
        if(!$tanggal_pinjam) {
            $tanggal_pinjam = date('Y-m-d H:i:s');
        }

        $query = "INSERT INTO " . $this->table . " 
                  (senpi_id, nama_pemegang, pangkat_nrp, jenis_senpi, no_senpi, jenis_peminjaman, 
                   tanggal_pinjam, tanggal_kembali, status, keterangan) 
                  VALUES (:senpi_id, :nama_pemegang, :pangkat_nrp, :jenis_senpi, :no_senpi, :jenis_peminjaman, 
                          :tanggal_pinjam, :tanggal_kembali, :status, :keterangan)";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':senpi_id', $senpi_id);
            $stmt->bindParam(':nama_pemegang', $nama_pemegang);
            $stmt->bindParam(':pangkat_nrp', $pangkat_nrp);
            $stmt->bindParam(':jenis_senpi', $jenis_senpi);
            $stmt->bindParam(':no_senpi', $no_senpi);
            $stmt->bindParam(':jenis_peminjaman', $jenis_peminjaman);
            $stmt->bindParam(':tanggal_pinjam', $tanggal_pinjam);
            $stmt->bindParam(':tanggal_kembali', $tanggal_kembali);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':keterangan', $keterangan);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Log berhasil dibuat', 'id' => $this->db->lastInsertId()];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get log by senpi
     */
    public function getLogBySenpi($senpi_id, $limit = 10) {
        $query = "SELECT * FROM " . $this->table . " WHERE senpi_id = :senpi_id ORDER BY tanggal_pinjam DESC LIMIT :limit";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':senpi_id', $senpi_id, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get all logs
     */
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY tanggal_pinjam DESC";
        
        if($limit) {
            $query .= " LIMIT " . intval($limit) . " OFFSET " . intval($offset);
        }
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return ['status' => 'success', 'data' => $stmt->fetchAll()];
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Update return status
     */
    public function updateReturn($id, $tanggal_kembali = null) {
        if(!$tanggal_kembali) {
            $tanggal_kembali = date('Y-m-d H:i:s');
        }

        $query = "UPDATE " . $this->table . " SET status = 'dikembalikan', tanggal_kembali = :tanggal_kembali, updated_at = NOW() WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':tanggal_kembali', $tanggal_kembali);
            
            if($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Status berhasil diperbarui'];
            }
        } catch(PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

// ============================================================
// HELPER FUNCTIONS
// ============================================================

/**
 * Format date to Indonesian format
 */
function formatDateIndonesia($date) {
    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $date = new DateTime($date);
    $month = $months[$date->format('n') - 1];
    return $date->format('d') . ' ' . $month . ' ' . $date->format('Y');
}

/**
 * Format time to Indonesian format
 */
function formatTimeIndonesia($time) {
    $date = new DateTime($time);
    return $date->format('H:i:s');
}

/**
 * Validate empty input
 */
function validateInput($data) {
    return !empty($data) && $data !== null;
}

/**
 * Sanitize input
 */
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate response
 */
function generateResponse($status, $message, $data = null) {
    $response = [
        'status' => $status,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    if($data !== null) {
        $response['data'] = $data;
    }
    
    return json_encode($response, JSON_PRETTY_PRINT);
}

?>