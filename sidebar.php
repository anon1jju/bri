<?php
/**
 * Sidebar Component for BRIMOB Logistik & Senpi System
 * Include this file in your main pages
 */

// Determine current page
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 flex-shrink-0 bg-white p-6 border-r border-[var(--accent-color)] flex flex-col justify-between transform -translate-x-full lg:relative lg:translate-x-0">
    <div>
        <!-- Logo Section -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-[var(--primary-color)] rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-sm">B</span>
                </div>
                <h1 class="text-xl font-bold text-[var(--text-primary)]">BRIMOB</h1>
            </div>
            <button id="close-menu" class="lg:hidden text-[var(--text-secondary)] hover:text-[var(--text-primary)]">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex flex-col gap-2 mt-8">
            <!-- Dashboard -->
            <a href="dashboard.php" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors <?php echo ($current_page === 'dashboard.php') ? 'bg-[var(--secondary-color)] text-[var(--primary-color)] font-medium' : 'text-[var(--text-secondary)] hover:bg-[var(--secondary-color)] hover:text-[var(--primary-color)]'; ?>">
                <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                    <path d="M224,115.55V208a16,16,0,0,1-16,16H168a16,16,0,0,1-16-16V168a8,8,0,0,0-8-8H112a8,8,0,0,0-8,8v40a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V115.55a16,16,0,0,1,5.17-11.78l80-75.48.11-.11a16,16,0,0,1,21.53,0,1.14,1.14,0,0,0,.11.11l80,75.48A16,16,0,0,1,224,115.55Z"></path>
                </svg>
                <span class="text-sm">Dashboard</span>
            </a>

            <!-- Data Anggota -->
            <a href="anggota.php" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors <?php echo ($current_page === 'anggota.php') ? 'bg-[var(--secondary-color)] text-[var(--primary-color)] font-medium' : 'text-[var(--text-secondary)] hover:bg-[var(--secondary-color)] hover:text-[var(--primary-color)]'; ?>">
                <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                    <path d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Z"></path>
                </svg>
                <span class="text-sm font-medium">Data Anggota</span>
            </a>

            <!-- Jenis Senpi -->
            <a href="jenis-senpi.php" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors <?php echo ($current_page === 'jenis-senpi.php') ? 'bg-[var(--secondary-color)] text-[var(--primary-color)] font-medium' : 'text-[var(--text-secondary)] hover:bg-[var(--secondary-color)] hover:text-[var(--primary-color)]'; ?>">
                <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                    <path d="M224,48H32a8,8,0,0,0-8,8V72a28,28,0,0,0,28,28h4.46l11.19,80.46A16,16,0,0,0,83,184h90a16,16,0,0,0,15.36-11.54L199.54,100H204a28,28,0,0,0,28-28V56A8,8,0,0,0,224,48ZM80,144a8,8,0,1,1,8-8A8,8,0,0,1,80,144Zm96,0a8,8,0,1,1,8-8A8,8,0,0,1,176,144Z"></path>
                </svg>
                <span class="text-sm font-medium">Jenis Senpi</span>
            </a>

            <!-- Data Logistik -->
            <a href="logistik.php" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors <?php echo ($current_page === 'logistik.php') ? 'bg-[var(--secondary-color)] text-[var(--primary-color)] font-medium' : 'text-[var(--text-secondary)] hover:bg-[var(--secondary-color)] hover:text-[var(--primary-color)]'; ?>">
                <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                    <path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,160H40V56H216V200ZM176,88a48,48,0,0,1-96,0,8,8,0,0,1,16,0,32,32,0,0,0,64,0,8,8,0,0,1,16,0Z"></path>
                </svg>
                <span class="text-sm font-medium">Data Logistik</span>
            </a>

            <!-- Peminjaman -->
            <a href="peminjaman.php" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors <?php echo ($current_page === 'peminjaman.php') ? 'bg-[var(--secondary-color)] text-[var(--primary-color)] font-medium' : 'text-[var(--text-secondary)] hover:bg-[var(--secondary-color)] hover:text-[var(--primary-color)]'; ?>">
                <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm64-88a8,8,0,0,1-8,8H136v48a8,8,0,0,1-16,0V136H72a8,8,0,0,1,0-16h48V72a8,8,0,0,1,16,0v48h48A8,8,0,0,1,192,128Z"></path>
                </svg>
                <span class="text-sm font-medium">Peminjaman</span>
            </a>

            <!-- Laporan (Optional) -->
            <a href="laporan.php" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors <?php echo ($current_page === 'laporan.php') ? 'bg-[var(--secondary-color)] text-[var(--primary-color)] font-medium' : 'text-[var(--text-secondary)] hover:bg-[var(--secondary-color)] hover:text-[var(--primary-color)]'; ?>">
                <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                    <path d="M224,48a8,8,0,0,0-8-8H40a8,8,0,0,0-8,8V216a8,8,0,0,0,16,0V160H216a8,8,0,0,0,8-8V48Zm-16,96H48V56H208Z"></path>
                </svg>
                <span class="text-sm font-medium">Laporan</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Section -->
    <div class="flex flex-col gap-2 border-t border-[var(--accent-color)] pt-4">
        <!-- User Info (Optional) -->
        <div class="px-3 py-2 text-xs text-[var(--text-secondary)]">
            <p class="font-medium text-[var(--text-primary)]">
                <?php echo htmlspecialchars($current_user ?? 'Admin'); ?>
            </p>
            <p class="text-[var(--text-secondary)]">Administrator</p>
        </div>

        <!-- Settings -->
        <a href="settings.php" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors <?php echo ($current_page === 'settings.php') ? 'bg-[var(--secondary-color)] text-[var(--primary-color)] font-medium' : 'text-[var(--text-secondary)] hover:bg-[var(--secondary-color)] hover:text-[var(--primary-color)]'; ?>">
            <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                <path d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Zm88-29.84q.06-2.16,0-4.32l14.92-18.64a8,8,0,0,0,1.48-7.06,107.21,107.21,0,0,0-10.88-26.25,8,8,0,0,0-6-3.93l-23.72-2.64q-1.48-1.56-3-3L186,40.54a8,8,0,0,0-3.94-6,107.71,107.71,0,0,0-26.25-10.87,8,8,0,0,0-7.06,1.49L130.16,40Q128,40,125.84,40L107.2,25.11a8,8,0,0,0-7.06-1.48A107.6,107.6,0,0,0,73.89,34.51a8,8,0,0,0-3.93,6L67.32,64.27q-1.56,1.49-3,3L40.54,70a8,8,0,0,0-6,3.94,107.71,107.71,0,0,0-10.87,26.25,8,8,0,0,0,1.49,7.06L40,125.84Q40,128,40,130.16L25.11,148.8a8,8,0,0,0-1.48,7.06,107.21,107.21,0,0,0,10.88,26.25,8,8,0,0,0,6,3.93l23.72,2.64q1.49,1.56,3,3L70,215.46a8,8,0,0,0,3.94,6,107.71,107.71,0,0,0,26.25,10.87,8,8,0,0,0,7.06-1.49L125.84,216q2.16.06,4.32,0l18.64,14.92a8,8,0,0,0,7.06,1.48,107.21,107.21,0,0,0,26.25-10.88,8,8,0,0,0,3.93-6l2.64-23.72q1.56-1.48,3-3L215.46,186a8,8,0,0,0,6-3.94,107.71,107.71,0,0,0,10.87-26.25,8,8,0,0,0-1.49-7.06Zm-16.1-6.5a73.93,73.93,0,0,1,0,8.68,8,8,0,0,0,1.74,5.48l14.19,17.73a91.57,91.57,0,0,1-6.23,15L187,173.11a8,8,0,0,0-5.1,2.64,74.11,74.11,0,0,1-6.14,6.14,8,8,0,0,0-2.64,5.1l-2.51,22.58a91.32,91.32,0,0,1-15,6.23l-17.74-14.19a8,8,0,0,0-5-1.75h-.48a73.93,73.93,0,0,1-8.68,0,8,8,0,0,0-5.48,1.74L100.45,215.8a91.57,91.57,0,0,1-15-6.23L82.89,187a8,8,0,0,0-2.64-5.1,74.11,74.11,0,0,1-6.14-6.14,8,8,0,0,0-5.1-2.64L46.43,170.6a91.32,91.32,0,0,1-6.23-15l14.19-17.74a8,8,0,0,0,1.74-5.48,73.93,73.93,0,0,1,0-8.68,8,8,0,0,0-1.74-5.48L40.2,100.45a91.57,91.57,0,0,1,6.23-15L69,82.89a8,8,0,0,0,5.1-2.64,74.11,74.11,0,0,1,6.14-6.14A8,8,0,0,0,82.89,69L85.4,46.43a91.32,91.32,0,0,1,15-6.23l17.74,14.19a8,8,0,0,0,5.48,1.74,73.93,73.93,0,0,1,8.68,0,8,8,0,0,0,5.48-1.74L155.55,40.2a91.57,91.57,0,0,1,15,6.23L173.11,69a8,8,0,0,0,2.64,5.1,74.11,74.11,0,0,1,6.14,6.14,8,8,0,0,0,5.1,2.64l22.58,2.51a91.32,91.32,0,0,1,6.23,15l-14.19,17.74A8,8,0,0,0,199.87,123.66Z"></path>
            </svg>
            <span class="text-sm font-medium">Pengaturan</span>
        </a>

        <!-- Logout (Optional) -->
        <a href="logout.php" class="flex items-center gap-3 px-3 py-2 rounded-md text-[var(--text-secondary)] hover:bg-red-50 hover:text-red-600 transition-colors">
            <svg fill="currentColor" height="24px" viewBox="0 0 256 256" width="24px" xmlns="http://www.w3.org/2000/svg">
                <path d="M112,216a8,8,0,0,1-8-8V40a8,8,0,0,1,16,0V208A8,8,0,0,1,112,216Zm96-96a8,8,0,0,1-2.34,5.66l-32,32a8,8,0,0,1-11.32-11.32L188.68,128l-26.34-26.34a8,8,0,0,1,11.32-11.32l32,32A8,8,0,0,1,208,120Z"></path>
            </svg>
            <span class="text-sm font-medium">Logout</span>
        </a>
    </div>
</aside>

<!-- Sidebar Overlay for Mobile -->
<div id="overlay" class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden"></div>

<!-- Sidebar JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menu-toggle');
        const closeMenu = document.getElementById('close-menu');
        const overlay = document.getElementById('overlay');

        if(!sidebar || !menuToggle || !closeMenu || !overlay) return;

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
    });
</script>