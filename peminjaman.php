<?php
require_once 'fungsi.php';

session_start();

$current_user = $_SESSION['username'] ?? 'Admin';

// Initialize Database & Classes
$database = new Database();
$db = $database->connect();

$senpi = new Senpi($db);
$peminjaman_log = new PeminjamanLog($db);

// Get all senpi untuk dropdown
$result_senpi = $senpi->getAll(999);
$senpi_list = $result_senpi['data'] ?? [];

// Get all peminjaman log
$result_log = $peminjaman_log->getAll(999);
$peminjaman_list = $result_log['data'] ?? [];

// Handle AJAX Requests
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = sanitizeInput($_POST['action']);
    
    if($action == 'pinjam') {
        $senpi_id = intval($_POST['senpi_id']);
        $nama_pemegang = sanitizeInput($_POST['nama_pemegang']);
        $pangkat_nrp = sanitizeInput($_POST['pangkat_nrp']);
        $jenis_senpi = sanitizeInput($_POST['jenis_senpi']);
        $no_senpi = sanitizeInput($_POST['no_senpi']);
        $keterangan = sanitizeInput($_POST['keterangan'] ?? 'Peminjaman rutin via input manual');
        
        if($senpi_id > 0 && validateInput($nama_pemegang) && validateInput($pangkat_nrp) && 
           validateInput($jenis_senpi) && validateInput($no_senpi)) {
            
            $result = $peminjaman_log->log(
                $senpi_id,
                $nama_pemegang,
                $pangkat_nrp,
                $jenis_senpi,
                $no_senpi,
                'rutin',
                $keterangan,
                date('Y-m-d H:i:s'),
                null,
                'dipinjam'
            );
            
            echo json_encode($result);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
        }
        exit;
    }
    
    if($action == 'kembalikan') {
        $log_id = intval($_POST['log_id']);
        
        if($log_id > 0) {
            $result = $peminjaman_log->updateReturn($log_id, date('Y-m-d H:i:s'));
            echo json_encode($result);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
        exit;
    }
    
    if($action == 'search') {
        $keyword = sanitizeInput($_POST['keyword']);
        $filtered = array_filter($peminjaman_list, function($item) use ($keyword) {
            $search_lower = strtolower($keyword);
            return stripos($item['nama_pemegang'], $search_lower) !== false ||
                   stripos($item['pangkat_nrp'], $search_lower) !== false ||
                   stripos($item['jenis_senpi'], $search_lower) !== false ||
                   stripos($item['no_senpi'], $search_lower) !== false;
        });
        
        echo json_encode(['status' => 'success', 'data' => array_values($filtered)]);
        exit;
    }

    if($action == 'get_senpi_details') {
        $senpi_id = intval($_POST['senpi_id']);
        
        if($senpi_id > 0) {
            $result = $senpi->getById($senpi_id);
            echo json_encode($result);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
        exit;
    }
}

// Get stats
$total_dipinjam = count(array_filter($peminjaman_list, function($item) { return $item['status'] === 'dipinjam'; }));
$total_dikembalikan = count(array_filter($peminjaman_list, function($item) { return $item['status'] === 'dikembalikan'; }));

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" href="https://fonts.googleapis.com/css2?display=swap&family=Inter%3Awght%40400%3B500%3B700%3B900&family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet" />
    <title>Peminjaman - BRIMOB Logistik & Senpi</title>
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
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-dipinjam {
            background-color: #fef08a;
            color: #854d0e;
        }
        .status-dikembalikan {
            background-color: #dcfce7;
            color: #166534;
        }
    </style>
</head>
<body class="bg-[var(--background-color)]">
    <div class="relative min-h-screen lg:flex">
        <!-- Include Sidebar -->
        <?php include 'sidebar.php'; ?>

        <div id="overlay" class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden"></div>

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
                        <h1 class="text-3xl font-bold text-[var(--text-primary)]">Peminjaman Senpi</h1>
                        <p class="text-[var(--text-secondary)] text-sm">Kelola peminjaman rutin senpi anggota</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Peminjaman -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Total Transaksi</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo count($peminjaman_list); ?></p>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-blue-600">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm52,100H76a8,8,0,0,1,0-16h104a8,8,0,0,1,0,16Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sedang Dipinjam -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Sedang Dipinjam</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo $total_dipinjam; ?></p>
                        </div>
                        <div class="w-14 h-14 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-yellow-600">
                                <path d="M200,32H56A24,24,0,0,0,32,56V200a24,24,0,0,0,24,24H200a24,24,0,0,0,24-24V56A24,24,0,0,0,200,32Zm0,168H56V56H200V200Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sudah Dikembalikan -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Sudah Dikembalikan</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo $total_dikembalikan; ?></p>
                        </div>
                        <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-green-600">
                                <path d="M208.49,95.51l-128,128a12,12,0,0,1-17,0l-64-64a12,12,0,1,1,17-17L64,183,191.51,55.51a12,12,0,0,1,17,17Z"></path>
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
                            <input type="text" id="searchInput" placeholder="Cari nama anggota, NRP, atau jenis senpi..." class="w-full pl-10 pr-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]">
                        </div>
                    </div>
                    <button id="btnPinjam" class="btn-transition px-4 py-2 bg-[var(--primary-color)] text-white rounded-lg text-sm font-medium hover:bg-blue-700 whitespace-nowrap">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Pinjam Senpi
                        </span>
                    </button>
                </div>

                <!-- Tabs -->
                <div class="flex gap-4 mb-6 border-b border-[var(--accent-color)]">
                    <button id="tabSemua" class="tab-btn px-4 py-3 text-sm font-medium text-[var(--primary-color)] border-b-2 border-[var(--primary-color)] cursor-pointer" data-filter="semua">
                        Semua
                    </button>
                    <button id="tabDipinjam" class="tab-btn px-4 py-3 text-sm font-medium text-[var(--text-secondary)] border-b-2 border-transparent hover:text-[var(--text-primary)] cursor-pointer" data-filter="dipinjam">
                        Dipinjam
                    </button>
                    <button id="tabDikembalikan" class="tab-btn px-4 py-3 text-sm font-medium text-[var(--text-secondary)] border-b-2 border-transparent hover:text-[var(--text-primary)] cursor-pointer" data-filter="dikembalikan">
                        Dikembalikan
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-[var(--accent-color)]">
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">No</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Nama Anggota</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Pangkat/NRP</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Jenis Senpi</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">No Senpi</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Tgl Pinjam</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Status</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <?php if(!empty($peminjaman_list)): ?>
                                <?php $no = 1; ?>
                                <?php foreach(array_reverse($peminjaman_list) as $item): ?>
                                <tr class="border-b border-[var(--accent-color)] hover:bg-[var(--secondary-color)] transition-colors" data-status="<?php echo $item['status']; ?>">
                                    <td class="px-4 py-3 text-[var(--text-primary)] font-medium"><?php echo $no++; ?></td>
                                    <td class="px-4 py-3 text-[var(--text-primary)]"><?php echo htmlspecialchars($item['nama_pemegang']); ?></td>
                                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs"><?php echo htmlspecialchars($item['pangkat_nrp']); ?></td>
                                    <td class="px-4 py-3 text-[var(--text-primary)] text-xs"><?php echo htmlspecialchars($item['jenis_senpi']); ?></td>
                                    <td class="px-4 py-3 text-[var(--text-primary)] font-mono text-xs"><?php echo htmlspecialchars($item['no_senpi']); ?></td>
                                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs"><?php echo date('d M Y H:i', strtotime($item['tanggal_pinjam'])); ?></td>
                                    <td class="px-4 py-3">
                                        <span class="status-badge <?php echo ($item['status'] === 'dipinjam') ? 'status-dipinjam' : 'status-dikembalikan'; ?>">
                                            <?php echo ucfirst($item['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <?php if($item['status'] === 'dipinjam'): ?>
                                            <button class="btnKembalikan btn-transition px-3 py-1 bg-green-100 text-green-700 rounded text-xs font-medium hover:bg-green-200" data-id="<?php echo $item['id']; ?>" type="button">
                                                Kembalikan
                                            </button>
                                        <?php else: ?>
                                            <span class="text-[var(--text-secondary)] text-xs">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-[var(--text-secondary)]">
                                        Belum ada data peminjaman
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info -->
                <div class="flex items-center justify-between mt-4 text-sm text-[var(--text-secondary)]">
                    <div id="infoCount"></div>
                    <div>Total Transaksi: <span id="totalCount"><?php echo count($peminjaman_list); ?></span></div>
                </div>
            </div>

        </main>
    </div>

    <!-- Modal Pinjam -->
    <div id="modalPinjam" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="modal-backdrop fixed inset-0 bg-black/60" id="pinjamBackdrop"></div>
        <div class="modal-content bg-white rounded-lg shadow-2xl p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto relative">
            <div class="flex items-center justify-between mb-4 sticky top-0 bg-white pb-4 border-b border-[var(--accent-color)]">
                <h3 class="text-xl font-bold text-[var(--text-primary)]">Peminjaman Senpi</h3>
                <button id="btnCloseModal" class="text-[var(--text-secondary)] hover:text-[var(--text-primary)] p-1" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="formPinjam" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Pilih Senpi <span class="text-red-500">*</span></label>
                    <select id="formSenpi" name="senpi_id" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" required>
                        <option value="">-- Pilih Senpi --</option>
                        <?php foreach($senpi_list as $s): ?>
                            <option value="<?php echo $s['id']; ?>" data-jenis="<?php echo htmlspecialchars($s['jenis_senpi']); ?>" data-no="<?php echo htmlspecialchars($s['no_senpi']); ?>">
                                <?php echo htmlspecialchars($s['nama_pemegang']); ?> - <?php echo htmlspecialchars($s['jenis_senpi']); ?> (<?php echo htmlspecialchars($s['no_senpi']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Jenis Senpi <span class="text-red-500">*</span></label>
                        <input type="text" id="formJenis" name="jenis_senpi" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">No Senpi <span class="text-red-500">*</span></label>
                        <input type="text" id="formNoSenpi" name="no_senpi" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Nama Anggota <span class="text-red-500">*</span></label>
                        <input type="text" id="formNama" name="nama_pemegang" placeholder="Ketik nama anggota" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Pangkat/NRP <span class="text-red-500">*</span></label>
                        <input type="text" id="formPangkat" name="pangkat_nrp" placeholder="Contoh: BRIPKA/79051335" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Keterangan <span class="text-gray-400 text-xs">(Opsional)</span></label>
                    <textarea id="formKeterangan" name="keterangan" placeholder="Catatan peminjaman..." rows="2" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]"></textarea>
                </div>

                <div class="flex gap-3 pt-4 border-t border-[var(--accent-color)]">
                    <button type="button" id="btnCancelForm" class="flex-1 px-4 py-2 border border-[var(--accent-color)] text-[var(--text-primary)] rounded-lg text-sm font-medium hover:bg-[var(--secondary-color)] transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-[var(--primary-color)] text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        Simpan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        let currentFilter = 'semua';
        let allPeminjaman = <?php echo json_encode($peminjaman_list); ?>;

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
        const modalPinjam = document.getElementById('modalPinjam');
        const formPinjam = document.getElementById('formPinjam');

        function openPinjamModal() {
            formPinjam.reset();
            modalPinjam.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.getElementById('formNama').focus();
        }

        function closePinjamModal() {
            modalPinjam.classList.add('hidden');
            document.body.style.overflow = '';
            formPinjam.reset();
        }

        // Initialize Button Events
        function initializeButtons() {
            // Pinjam Button
            const btnPinjam = document.getElementById('btnPinjam');
            if(btnPinjam) {
                btnPinjam.addEventListener('click', (e) => {
                    e.preventDefault();
                    openPinjamModal();
                });
            }

            // Modal Buttons
            const btnCloseModal = document.getElementById('btnCloseModal');
            const btnCancelForm = document.getElementById('btnCancelForm');
            const pinjamBackdrop = document.getElementById('pinjamBackdrop');

            if(btnCloseModal) btnCloseModal.addEventListener('click', closePinjamModal);
            if(btnCancelForm) btnCancelForm.addEventListener('click', closePinjamModal);
            if(pinjamBackdrop) pinjamBackdrop.addEventListener('click', closePinjamModal);

            // Kembalikan Buttons
            const btnKembalis = document.querySelectorAll('.btnKembalikan');
            btnKembalis.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const logId = btn.dataset.id;
                    kembaliSenpi(logId);
                });
            });

            // Tab Buttons
            const tabBtns = document.querySelectorAll('.tab-btn');
            tabBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const filter = btn.dataset.filter;
                    filterTable(filter);
                    
                    tabBtns.forEach(b => {
                        b.classList.remove('text-[var(--primary-color)]', 'border-[var(--primary-color)]');
                        b.classList.add('text-[var(--text-secondary)]', 'border-transparent');
                    });
                    btn.classList.add('text-[var(--primary-color)]', 'border-[var(--primary-color)]');
                    btn.classList.remove('text-[var(--text-secondary)]', 'border-transparent');
                });
            });

            // Search Input
            const searchInput = document.getElementById('searchInput');
            if(searchInput) {
                searchInput.addEventListener('keyup', handleSearch);
            }

            // Senpi Select Change
            const formSenpi = document.getElementById('formSenpi');
            if(formSenpi) {
                formSenpi.addEventListener('change', (e) => {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    document.getElementById('formJenis').value = selectedOption.dataset.jenis || '';
                    document.getElementById('formNoSenpi').value = selectedOption.dataset.no || '';
                });
            }
        }

        // Form Submit
        formPinjam.addEventListener('submit', (e) => {
            e.preventDefault();

            const senpiId = document.getElementById('formSenpi').value;
            if(!senpiId) {
                showAlert('Pilih senpi terlebih dahulu', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'pinjam');
            formData.append('senpi_id', senpiId);
            formData.append('nama_pemegang', document.getElementById('formNama').value);
            formData.append('pangkat_nrp', document.getElementById('formPangkat').value);
            formData.append('jenis_senpi', document.getElementById('formJenis').value);
            formData.append('no_senpi', document.getElementById('formNoSenpi').value);
            formData.append('keterangan', document.getElementById('formKeterangan').value);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    showAlert(data.message, 'success');
                    closePinjamModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message || 'Gagal menyimpan peminjaman', 'error');
                }
            })
            .catch(error => {
                showAlert('Terjadi kesalahan: ' + error, 'error');
            });
        });

        // Kembalikan Senpi
        function kembaliSenpi(logId) {
            if(!confirm('Yakin ingin mengembalikan senpi ini?')) return;

            const formData = new FormData();
            formData.append('action', 'kembalikan');
            formData.append('log_id', logId);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    showAlert(data.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message || 'Gagal mengembalikan senpi', 'error');
                }
            })
            .catch(error => {
                showAlert('Terjadi kesalahan: ' + error, 'error');
            });
        }

        // Filter Table
        function filterTable(filter) {
            currentFilter = filter;
            const rows = document.querySelectorAll('#tableBody tr[data-status]');
            
            rows.forEach(row => {
                if(filter === 'semua') {
                    row.style.display = '';
                } else if(filter === 'dipinjam') {
                    row.style.display = row.dataset.status === 'dipinjam' ? '' : 'none';
                } else if(filter === 'dikembalikan') {
                    row.style.display = row.dataset.status === 'dikembalikan' ? '' : 'none';
                }
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
                        <td colspan="8" class="px-4 py-8 text-center text-[var(--text-secondary)]">
                            Tidak ada hasil pencarian
                        </td>
                    </tr>
                `;
                totalCount.textContent = '0';
                return;
            }

            tableBody.innerHTML = data.map((row, index) => `
                <tr class="border-b border-[var(--accent-color)] hover:bg-[var(--secondary-color)] transition-colors" data-status="${row.status}">
                    <td class="px-4 py-3 text-[var(--text-primary)] font-medium">${index + 1}</td>
                    <td class="px-4 py-3 text-[var(--text-primary)]">${escapeHtml(row.nama_pemegang)}</td>
                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs">${escapeHtml(row.pangkat_nrp)}</td>
                    <td class="px-4 py-3 text-[var(--text-primary)] text-xs">${escapeHtml(row.jenis_senpi)}</td>
                    <td class="px-4 py-3 text-[var(--text-primary)] font-mono text-xs">${escapeHtml(row.no_senpi)}</td>
                    <td class="px-4 py-3 text-[var(--text-secondary)] text-xs">${new Date(row.tanggal_pinjam).toLocaleDateString('id-ID', {year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit'})}</td>
                    <td class="px-4 py-3">
                        <span class="status-badge ${row.status === 'dipinjam' ? 'status-dipinjam' : 'status-dikembalikan'}">
                            ${row.status === 'dipinjam' ? 'Dipinjam' : 'Dikembalikan'}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        ${row.status === 'dipinjam' ? `<button class="btnKembalikan btn-transition px-3 py-1 bg-green-100 text-green-700 rounded text-xs font-medium hover:bg-green-200" data-id="${row.id}" type="button">Kembalikan</button>` : '<span class="text-[var(--text-secondary)] text-xs">-</span>'}
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