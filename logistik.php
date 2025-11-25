<?php
require_once 'fungsi.php';

session_start();

// Initialize Database & Classes
$database = new Database();
$db = $database->connect();

$logistik = new Logistik($db);

// Get all logistik
$result_logistik = $logistik->getAll(999);
$logistik_list = $result_logistik['data'] ?? [];

// Get statistics
$stats = $logistik->getStats();

// Handle AJAX Requests
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = sanitizeInput($_POST['action']);
    
    if($action == 'add') {
        $nama_barang = sanitizeInput($_POST['nama_barang']);
        $kode_barang = sanitizeInput($_POST['kode_barang'] ?? '');
        // Set kode_barang ke NULL jika kosong
        $kode_barang = empty($kode_barang) ? null : $kode_barang;
        $jumlah = intval($_POST['jumlah']);
        $satuan = sanitizeInput($_POST['satuan'] ?? 'Buah');
        $kondisi = sanitizeInput($_POST['kondisi'] ?? 'Baik');
        $lokasi = sanitizeInput($_POST['lokasi'] ?? 'Gudang Logistik');
        $keterangan = sanitizeInput($_POST['keterangan'] ?? '');
        $keterangan = empty($keterangan) ? null : $keterangan;
        
        if(validateInput($nama_barang) && $jumlah > 0) {
            $result = $logistik->add($nama_barang, $kode_barang, $jumlah, $satuan, $kondisi, $lokasi, $keterangan);
            echo json_encode($result);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Nama barang dan jumlah harus diisi dengan benar']);
        }
        exit;
    }
    
    if($action == 'edit') {
        $id = intval($_POST['id']);
        $nama_barang = sanitizeInput($_POST['nama_barang']);
        $kode_barang = sanitizeInput($_POST['kode_barang'] ?? '');
        // Set kode_barang ke NULL jika kosong
        $kode_barang = empty($kode_barang) ? null : $kode_barang;
        $jumlah = intval($_POST['jumlah']);
        $satuan = sanitizeInput($_POST['satuan'] ?? 'Buah');
        $kondisi = sanitizeInput($_POST['kondisi'] ?? 'Baik');
        $lokasi = sanitizeInput($_POST['lokasi'] ?? 'Gudang Logistik');
        $keterangan = sanitizeInput($_POST['keterangan'] ?? '');
        $keterangan = empty($keterangan) ? null : $keterangan;
        
        if($id > 0 && validateInput($nama_barang) && $jumlah > 0) {
            $result = $logistik->update($id, $nama_barang, $kode_barang, $jumlah, $satuan, $kondisi, $lokasi, $keterangan);
            echo json_encode($result);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
        }
        exit;
    }
    
    if($action == 'delete') {
        $id = intval($_POST['id']);
        
        if($id > 0) {
            $result = $logistik->delete($id);
            echo json_encode($result);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
        exit;
    }
    
    if($action == 'get') {
        $id = intval($_POST['id']);
        
        if($id > 0) {
            $result = $logistik->getById($id);
            echo json_encode($result);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
        exit;
    }

    if($action == 'search') {
        $keyword = sanitizeInput($_POST['keyword']);
        $result = $logistik->search($keyword);
        echo json_encode($result);
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" href="https://fonts.googleapis.com/css2?display=swap&family=Inter%3Awght%40400%3B500%3B700%3B900&family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet" />
    <title>Data Logistik - BRIMOB Logistik & Senpi</title>
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style type="text/tailwindcss">
        :root {
            --primary-color: #0d7ff2;
            --secondary-color: #f0f8ff;
            --background-color: #f7fafc;
            --text-primary: #1a202c;
            --text-secondary: #4a5568;
            --accent-color: #e2e8f0;
        }
        body {
            font-family: 'Inter', 'Noto Sans', sans-serif;
        }
        #sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .modal-backdrop {
            animation: fadeIn 0.2s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .modal-content {
            animation: slideUp 0.3s ease-out;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .alert {
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .btn-transition {
            transition: all 0.2s ease;
        }
        .btn-transition:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-[var(--background-color)]">
    <div class="relative min-h-screen lg:flex">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 sm:p-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <button id="menu-toggle" class="p-2 rounded-md text-[var(--text-secondary)] hover:bg-[var(--secondary-color)] lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-3xl font-bold text-[var(--text-primary)]">Data Logistik</h1>
                        <p class="text-[var(--text-secondary)]">Kelola inventori barang dan logistik BRIMOB</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Logistik -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Total Item</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo $stats['status'] === 'success' ? $stats['total'] : 0; ?></p>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-blue-600">
                                <path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,160H40V56H216V200Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Item Baik -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Item Baik</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo $stats['status'] === 'success' ? $stats['baik'] : 0; ?></p>
                        </div>
                        <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-green-600">
                                <path d="M208.49,95.51l-128,128a12,12,0,0,1-17,0l-64-64a12,12,0,1,1,17-17L64,183,191.51,55.51a12,12,0,0,1,17,17Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Item Rusak -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Item Rusak</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo $stats['status'] === 'success' ? $stats['rusak'] : 0; ?></p>
                        </div>
                        <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-red-600">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm24-120h-48a8,8,0,0,0,0,16h48a8,8,0,0,0,0-16Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <!-- Main Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between mb-6 gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 text-[var(--text-secondary)]">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                            <input type="text" id="searchInput" placeholder="Cari nama barang, kode, atau lokasi..." class="w-full pl-10 pr-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]">
                        </div>
                    </div>
                    <button id="btnTambah" class="btn-transition px-4 py-2 bg-[var(--primary-color)] text-white rounded-lg text-sm font-medium hover:bg-blue-700 whitespace-nowrap">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Tambah Barang
                        </span>
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-[var(--accent-color)]">
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Nama Barang</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Kode</th>
                                <th class="text-center px-4 py-3 text-[var(--text-secondary)] font-semibold">Jumlah</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Satuan</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Kondisi</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Lokasi</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <?php if(!empty($logistik_list)): ?>
                                <?php foreach($logistik_list as $item): ?>
                                <tr class="border-b border-[var(--accent-color)] hover:bg-[var(--secondary-color)] transition-colors">
                                    <td class="px-4 py-3 text-[var(--text-primary)] font-medium"><?php echo htmlspecialchars($item['nama_barang']); ?></td>
                                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs font-mono"><?php echo htmlspecialchars($item['kode_barang'] ?? '-'); ?></td>
                                    <td class="px-4 py-3 text-[var(--text-primary)] text-center font-semibold"><?php echo $item['jumlah']; ?></td>
                                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs"><?php echo htmlspecialchars($item['satuan']); ?></td>
                                    <td class="px-4 py-3">
                                        <?php 
                                        $kondisi = $item['kondisi'];
                                        $kondisiClass = '';
                                        if($kondisi === 'Baik') $kondisiClass = 'bg-green-100 text-green-800';
                                        elseif($kondisi === 'Rusak Ringan') $kondisiClass = 'bg-yellow-100 text-yellow-800';
                                        elseif($kondisi === 'Rusak Berat') $kondisiClass = 'bg-red-100 text-red-800';
                                        else $kondisiClass = 'bg-blue-100 text-blue-800';
                                        ?>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold <?php echo $kondisiClass; ?>">
                                            <?php echo htmlspecialchars($kondisi); ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs"><?php echo htmlspecialchars($item['lokasi']); ?></td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            <button class="btnEdit btn-transition px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium hover:bg-yellow-200" data-id="<?php echo $item['id']; ?>" type="button">
                                                Edit
                                            </button>
                                            <button class="btnDelete btn-transition px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium hover:bg-red-200" data-id="<?php echo $item['id']; ?>" data-nama="<?php echo htmlspecialchars($item['nama_barang']); ?>" type="button">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-[var(--text-secondary)]">
                                        Belum ada data logistik
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info -->
                <div class="flex items-center justify-between mt-4 text-sm text-[var(--text-secondary)]">
                    <div id="infoCount"></div>
                    <div>Total Data: <span id="totalCount"><?php echo count($logistik_list); ?></span></div>
                </div>
            </div>

        </main>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="modalForm" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="modal-backdrop fixed inset-0 bg-black/60" id="formBackdrop"></div>
        <div class="modal-content bg-white rounded-lg shadow-2xl p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto relative">
            <div class="flex items-center justify-between mb-4 sticky top-0 bg-white pb-4 border-b border-[var(--accent-color)]">
                <h3 id="modalTitle" class="text-xl font-bold text-[var(--text-primary)]">Tambah Barang</h3>
                <button id="btnCloseModal" class="text-[var(--text-secondary)] hover:text-[var(--text-primary)] p-1" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="formLogistik" class="space-y-4">
                <input type="hidden" id="formId" name="id">
                
                <div>
                    <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" id="formNama" name="nama_barang" placeholder="Contoh: Kevlar" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" required>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Kode Barang <span class="text-gray-400 text-xs">(Opsional)</span></label>
                        <input type="text" id="formKode" name="kode_barang" placeholder="Contoh: 01 (Boleh kosong)" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Jumlah <span class="text-red-500">*</span></label>
                        <input type="number" id="formJumlah" name="jumlah" placeholder="0" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" min="1" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Satuan <span class="text-red-500">*</span></label>
                        <select id="formSatuan" name="satuan" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" required>
                            <option value="Buah">Buah</option>
                            <option value="Unit">Unit</option>
                            <option value="butir">Butir</option>
                            <option value="Box">Box</option>
                            <option value="Karton">Karton</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Kondisi <span class="text-red-500">*</span></label>
                        <select id="formKondisi" name="kondisi" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" required>
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                            <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" id="formLokasi" name="lokasi" placeholder="Contoh: Gudang Logistik" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Keterangan <span class="text-gray-400 text-xs">(Opsional)</span></label>
                    <textarea id="formKeterangan" name="keterangan" placeholder="Catatan tambahan..." rows="3" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]"></textarea>
                </div>

                <div class="flex gap-3 pt-4 border-t border-[var(--accent-color)]">
                    <button type="button" id="btnCancelForm" class="flex-1 px-4 py-2 border border-[var(--accent-color)] text-[var(--text-primary)] rounded-lg text-sm font-medium hover:bg-[var(--secondary-color)] transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-[var(--primary-color)] text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Confirm Delete -->
    <div id="modalDelete" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="modal-backdrop fixed inset-0 bg-black/60" id="deleteBackdrop"></div>
        <div class="modal-content bg-white rounded-lg shadow-2xl p-6 w-full max-w-md mx-4 relative">
            <div class="mb-4">
                <h3 class="text-lg font-bold text-[var(--text-primary)]">Konfirmasi Hapus</h3>
                <p class="text-[var(--text-secondary)] text-sm mt-2">Apakah Anda yakin ingin menghapus barang <span id="deleteItemName" class="font-semibold text-[var(--text-primary)]"></span>?</p>
            </div>

            <div class="flex gap-3 border-t border-[var(--accent-color)] pt-4">
                <button id="btnCancelDelete" class="flex-1 px-4 py-2 border border-[var(--accent-color)] text-[var(--text-primary)] rounded-lg text-sm font-medium hover:bg-[var(--secondary-color)] transition-colors" type="button">
                    Batal
                </button>
                <button id="btnConfirmDelete" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition-colors" type="button">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        let currentEditId = null;
        let currentDeleteId = null;
        let allLogistik = <?php echo json_encode($logistik_list); ?>;

        // Sidebar Toggle
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menu-toggle');
            const closeMenu = document.getElementById('close-menu');
            const overlay = document.getElementById('overlay');

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            };

            menuToggle.addEventListener('click', openSidebar);
            closeMenu.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            initializeButtons();
        });

        // Alert Helper
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alertClass = type === 'success' 
                ? 'bg-green-100 text-green-800 border border-green-300' 
                : 'bg-red-100 text-red-800 border border-red-300';
            
            const alert = document.createElement('div');
            alert.className = `alert rounded-lg p-4 mb-4 ${alertClass}`;
            alert.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium">${message}</span>
                    <button type="button" class="text-inherit hover:opacity-75" onclick="this.parentElement.parentElement.remove()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            `;
            alertContainer.appendChild(alert);

            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        // Modal Functions
        const modalForm = document.getElementById('modalForm');
        const modalDelete = document.getElementById('modalDelete');
        const formLogistik = document.getElementById('formLogistik');

        function openFormModal(isEdit = false, id = null) {
            currentEditId = id;
            const modalTitle = document.getElementById('modalTitle');
            
            if(isEdit && id) {
                modalTitle.textContent = 'Edit Barang';
                fetchFormData(id);
            } else {
                modalTitle.textContent = 'Tambah Barang';
                formLogistik.reset();
                document.getElementById('formId').value = '';
                document.getElementById('formNama').focus();
            }
            
            modalForm.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeFormModal() {
            modalForm.classList.add('hidden');
            document.body.style.overflow = '';
            formLogistik.reset();
            currentEditId = null;
        }

        function openDeleteModal(id, nama) {
            currentDeleteId = id;
            document.getElementById('deleteItemName').textContent = nama;
            modalDelete.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            modalDelete.classList.add('hidden');
            document.body.style.overflow = '';
            currentDeleteId = null;
        }

        // Initialize Button Events
        function initializeButtons() {
            // Tambah Button
            const btnTambah = document.getElementById('btnTambah');
            if(btnTambah) {
                btnTambah.addEventListener('click', (e) => {
                    e.preventDefault();
                    openFormModal();
                });
            }

            // Form Modal Buttons
            const btnCloseModal = document.getElementById('btnCloseModal');
            const btnCancelForm = document.getElementById('btnCancelForm');
            const formBackdrop = document.getElementById('formBackdrop');

            if(btnCloseModal) btnCloseModal.addEventListener('click', closeFormModal);
            if(btnCancelForm) btnCancelForm.addEventListener('click', closeFormModal);
            if(formBackdrop) formBackdrop.addEventListener('click', closeFormModal);

            // Delete Modal Buttons
            const btnCancelDelete = document.getElementById('btnCancelDelete');
            const deleteBackdrop = document.getElementById('deleteBackdrop');

            if(btnCancelDelete) btnCancelDelete.addEventListener('click', closeDeleteModal);
            if(deleteBackdrop) deleteBackdrop.addEventListener('click', closeDeleteModal);

            // Edit & Delete Row Buttons
            const btnEdits = document.querySelectorAll('.btnEdit');
            const btnDeletes = document.querySelectorAll('.btnDelete');

            btnEdits.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = btn.dataset.id;
                    openFormModal(true, id);
                });
            });

            btnDeletes.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = btn.dataset.id;
                    const nama = btn.dataset.nama;
                    openDeleteModal(id, nama);
                });
            });

            // Search Input
            const searchInput = document.getElementById('searchInput');
            if(searchInput) {
                searchInput.addEventListener('keyup', handleSearch);
            }
        }

        // Fetch data for edit
        function fetchFormData(id) {
            const formData = new FormData();
            formData.append('action', 'get');
            formData.append('id', id);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    document.getElementById('formId').value = data.data.id;
                    document.getElementById('formNama').value = data.data.nama_barang;
                    document.getElementById('formKode').value = data.data.kode_barang || '';
                    document.getElementById('formJumlah').value = data.data.jumlah;
                    document.getElementById('formSatuan').value = data.data.satuan;
                    document.getElementById('formKondisi').value = data.data.kondisi;
                    document.getElementById('formLokasi').value = data.data.lokasi;
                    document.getElementById('formKeterangan').value = data.data.keterangan || '';
                    document.getElementById('formNama').focus();
                } else {
                    showAlert(data.message || 'Gagal memuat data', 'error');
                    closeFormModal();
                }
            })
            .catch(error => {
                showAlert('Terjadi kesalahan: ' + error, 'error');
                closeFormModal();
            });
        }

        // Form Submit
        formLogistik.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = new FormData();
            const id = document.getElementById('formId').value;
            
            if(id) {
                formData.append('action', 'edit');
                formData.append('id', id);
            } else {
                formData.append('action', 'add');
            }
            
            formData.append('nama_barang', document.getElementById('formNama').value);
            formData.append('kode_barang', document.getElementById('formKode').value);
            formData.append('jumlah', document.getElementById('formJumlah').value);
            formData.append('satuan', document.getElementById('formSatuan').value);
            formData.append('kondisi', document.getElementById('formKondisi').value);
            formData.append('lokasi', document.getElementById('formLokasi').value);
            formData.append('keterangan', document.getElementById('formKeterangan').value);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    showAlert(data.message, 'success');
                    closeFormModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message || 'Gagal menyimpan data', 'error');
                }
            })
            .catch(error => {
                showAlert('Terjadi kesalahan: ' + error, 'error');
            });
        });

        // Delete Confirm
        const btnConfirmDelete = document.getElementById('btnConfirmDelete');
        if(btnConfirmDelete) {
            btnConfirmDelete.addEventListener('click', () => {
                if(!currentDeleteId) return;

                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', currentDeleteId);

                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success') {
                        showAlert(data.message, 'success');
                        closeDeleteModal();
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert(data.message || 'Gagal menghapus data', 'error');
                    }
                })
                .catch(error => {
                    showAlert('Terjadi kesalahan: ' + error, 'error');
                });
            });
        }

        // Search Function
        function handleSearch(e) {
            const keyword = e.target.value.toLowerCase();
            
            if(keyword.length === 0) {
                location.reload();
                return;
            }

            const formData = new FormData();
            formData.append('action', 'search');
            formData.append('keyword', keyword);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    updateTable(data.data);
                } else {
                    showAlert(data.message || 'Gagal mencari data', 'error');
                }
            })
            .catch(error => {
                showAlert('Terjadi kesalahan: ' + error, 'error');
            });
        }

        // Update Table
        function updateTable(data) {
            const tableBody = document.getElementById('tableBody');
            const totalCount = document.getElementById('totalCount');
            
            if(data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-[var(--text-secondary)]">
                            Tidak ada hasil pencarian
                        </td>
                    </tr>
                `;
                totalCount.textContent = '0';
                return;
            }

            const getKondisiClass = (kondisi) => {
                if(kondisi === 'Baik') return 'bg-green-100 text-green-800';
                if(kondisi === 'Rusak Ringan') return 'bg-yellow-100 text-yellow-800';
                if(kondisi === 'Rusak Berat') return 'bg-red-100 text-red-800';
                return 'bg-blue-100 text-blue-800';
            };

            tableBody.innerHTML = data.map((row, index) => `
                <tr class="border-b border-[var(--accent-color)] hover:bg-[var(--secondary-color)] transition-colors">
                    <td class="px-4 py-3 text-[var(--text-primary)] font-medium">${escapeHtml(row.nama_barang)}</td>
                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs font-mono">${escapeHtml(row.kode_barang || '-')}</td>
                    <td class="px-4 py-3 text-[var(--text-primary)] text-center font-semibold">${row.jumlah}</td>
                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs">${escapeHtml(row.satuan)}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold ${getKondisiClass(row.kondisi)}">
                            ${escapeHtml(row.kondisi)}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs">${escapeHtml(row.lokasi)}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <button class="btnEdit btn-transition px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium hover:bg-yellow-200" data-id="${row.id}" type="button">
                                Edit
                            </button>
                            <button class="btnDelete btn-transition px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium hover:bg-red-200" data-id="${row.id}" data-nama="${escapeHtml(row.nama_barang)}" type="button">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');

            totalCount.textContent = data.length;
            initializeButtons();
        }

        // Escape HTML
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }
    </script>
</body>
</html>