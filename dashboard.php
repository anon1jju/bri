<?php
require_once 'fungsi.php';

session_start();

// Initialize Database & Classes
$database = new Database();
$db = $database->connect();

$senpi = new Senpi($db);
$logistik = new Logistik($db);
$peminjaman = new PeminjamanDinas($db);
$peminjaman_log = new PeminjamanLog($db);

// Get Statistics
$total_senpi = $senpi->count();
$total_logistik = $logistik->count();
$total_peminjaman_aktif = $peminjaman->count('Berlangsung');
$total_item_rusak = count($logistik->getByKondisi('Rusak Ringan')['data'] ?? []) + count($logistik->getByKondisi('Rusak Berat')['data'] ?? []);

// Get Recent Data
$recent_peminjaman_result = $peminjaman->getAll(5);
$recent_peminjaman = $recent_peminjaman_result['data'] ?? [];

// Get Senpi Distribution
$all_senpi = $senpi->getAll(999)['data'] ?? [];
$senpi_distribution = [];
foreach($all_senpi as $s) {
    $jenis = $s['jenis_senpi'];
    $senpi_distribution[$jenis] = ($senpi_distribution[$jenis] ?? 0) + 1;
}

// Get Logistik Status
$all_logistik = $logistik->getAll(999)['data'] ?? [];
$logistik_kondisi = [];
foreach($all_logistik as $l) {
    $kondisi = $l['kondisi'];
    $logistik_kondisi[$kondisi] = ($logistik_kondisi[$kondisi] ?? 0) + 1;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style" href="https://fonts.googleapis.com/css2?display=swap&family=Inter%3Awght%40400%3B500%3B700%3B900&family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet" />
    <title>Dashboard - BRIMOB Logistik & Senpi</title>
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
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
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        .chart-container {
            position: relative;
            height: 300px;
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
                        <h1 class="text-3xl font-bold text-[var(--text-primary)]">Dashboard</h1>
                        <p class="text-[var(--text-secondary)]">Selamat datang, Admin BRIMOB</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-[var(--primary-color)] rounded-full flex items-center justify-center text-white font-bold">A</div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Senpi Card -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Total Senpi</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo $total_senpi; ?></p>
                            <p class="text-xs text-[var(--text-secondary)] mt-2">Unit</p>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-blue-600">
                                <path d="M224,48H32a8,8,0,0,0-8,8V72a28,28,0,0,0,28,28h4.46l11.19,80.46A16,16,0,0,0,83,184h90a16,16,0,0,0,15.36-11.54L199.54,100H204a28,28,0,0,0,28-28V56A8,8,0,0,0,224,48ZM80,144a8,8,0,1,1,8-8A8,8,0,0,1,80,144Zm96,0a8,8,0,1,1,8-8A8,8,0,0,1,176,144Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Logistik Card -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Total Logistik</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo $total_logistik; ?></p>
                            <p class="text-xs text-[var(--text-secondary)] mt-2">Item</p>
                        </div>
                        <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-green-600">
                                <path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,160H40V56H216V200ZM176,88a48,48,0,0,1-96,0,8,8,0,0,1,16,0,32,32,0,0,0,64,0,8,8,0,0,1,16,0Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Peminjaman Aktif Card -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Peminjaman Aktif</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo $total_peminjaman_aktif; ?></p>
                            <p class="text-xs text-[var(--text-secondary)] mt-2">Berlangsung</p>
                        </div>
                        <div class="w-14 h-14 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-yellow-600">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm24-120h-24V72a8,8,0,0,0-16,0v48H64a8,8,0,0,0,0,16h24v48a8,8,0,0,0,16,0V136h24a8,8,0,0,0,0-16Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Item Rusak Card -->
                <div class="stat-card bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[var(--text-secondary)] text-sm font-medium">Item Rusak</p>
                            <p class="text-3xl font-bold text-[var(--text-primary)] mt-2"><?php echo $total_item_rusak; ?></p>
                            <p class="text-xs text-[var(--text-secondary)] mt-2">Perlu Perbaikan</p>
                        </div>
                        <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg fill="currentColor" height="28px" viewBox="0 0 256 256" width="28px" xmlns="http://www.w3.org/2000/svg" class="text-red-600">
                                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm24-120h-48a8,8,0,0,0,0,16h48a8,8,0,0,0,0-16Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Senpi Distribution Chart -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-bold text-[var(--text-primary)] mb-4">Distribusi Jenis Senpi</h2>
                    <div class="chart-container">
                        <canvas id="senpiChart"></canvas>
                    </div>
                </div>

                <!-- Logistik Condition Chart -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-bold text-[var(--text-primary)] mb-4">Status Kondisi Logistik</h2>
                    <div class="chart-container">
                        <canvas id="kondisiChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Peminjaman Table -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-[var(--text-primary)]">Peminjaman Terbaru</h2>
                    <a href="peminjaman.php" class="text-[var(--primary-color)] hover:text-blue-700 text-sm font-medium transition-colors">Lihat Semua →</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[var(--accent-color)]">
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] text-sm font-semibold">Nama Tugas</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] text-sm font-semibold">Penanggung Jawab</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] text-sm font-semibold">Tanggal Mulai</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] text-sm font-semibold">Status</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($recent_peminjaman)): ?>
                                <?php foreach($recent_peminjaman as $peminjam): ?>
                                <tr class="border-b border-[var(--accent-color)] hover:bg-[var(--secondary-color)] transition-colors">
                                    <td class="px-4 py-3 text-[var(--text-primary)] text-sm font-medium"><?php echo htmlspecialchars($peminjam['nama_tugas']); ?></td>
                                    <td class="px-4 py-3 text-[var(--text-primary)] text-sm"><?php echo htmlspecialchars($peminjam['penanggung_jawab_nama']); ?></td>
                                    <td class="px-4 py-3 text-[var(--text-secondary)] text-sm"><?php echo date('d M Y', strtotime($peminjam['tanggal_mulai'])); ?></td>
                                    <td class="px-4 py-3">
                                        <?php if($peminjam['status'] == 'Berlangsung'): ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Berlangsung</span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="peminjaman.php?id=<?php echo $peminjam['id']; ?>" class="text-[var(--primary-color)] hover:underline text-xs font-medium">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-[var(--text-secondary)]">
                                        Belum ada data peminjaman
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Toggle
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

            // Senpi Distribution Chart
            const senpiData = <?php echo json_encode($senpi_distribution); ?>;
            const senpiLabels = Object.keys(senpiData);
            const senpiValues = Object.values(senpiData);

            const senpiCtx = document.getElementById('senpiChart').getContext('2d');
            new Chart(senpiCtx, {
                type: 'doughnut',
                data: {
                    labels: senpiLabels,
                    datasets: [{
                        data: senpiValues,
                        backgroundColor: [
                            '#0d7ff2',
                            '#3b82f6',
                            '#60a5fa',
                            '#93c5fd',
                            '#dbeafe',
                            '#10b981',
                            '#34d399',
                            '#6ee7b7',
                            '#a7f3d0',
                            '#dcfce7',
                            '#ef4444',
                            '#f87171'
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 11
                                },
                                padding: 12,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Logistik Kondisi Chart
            const kondisiData = <?php echo json_encode($logistik_kondisi); ?>;
            const kondisiLabels = Object.keys(kondisiData);
            const kondisiValues = Object.values(kondisiData);

            const kondisiCtx = document.getElementById('kondisiChart').getContext('2d');
            new Chart(kondisiCtx, {
                type: 'bar',
                data: {
                    labels: kondisiLabels,
                    datasets: [{
                        label: 'Jumlah Item',
                        data: kondisiValues,
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#6366f1'],
                        borderColor: ['#059669', '#d97706', '#dc2626', '#4f46e5'],
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: '#e2e8f0'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>