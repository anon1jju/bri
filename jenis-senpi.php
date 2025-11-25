<?php
require_once 'fungsi.php';

session_start();

// Initialize Database & Classes
$database = new Database();
$db = $database->connect();

$senpi = new Senpi($db);

// Get all jenis senpi
$result_jenis = $senpi->getJenisSenpi();
$jenis_senpi_list = $result_jenis['data'] ?? [];

// Handle AJAX Requests
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = sanitizeInput($_POST['action']);
    
    if($action == 'add') {
        $nama_jenis = sanitizeInput($_POST['nama_jenis']);
        
        if(validateInput($nama_jenis)) {
            $query = "INSERT INTO jenis_senpi (nama_jenis) VALUES (:nama_jenis)";
            try {
                $stmt = $db->prepare($query);
                $stmt->bindParam(':nama_jenis', $nama_jenis);
                
                if($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Jenis Senpi berhasil ditambahkan']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan data']);
                }
            } catch(PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
        }
        exit;
    }
    
    if($action == 'edit') {
        $id = intval($_POST['id']);
        $nama_jenis = sanitizeInput($_POST['nama_jenis']);
        
        if(validateInput($nama_jenis) && $id > 0) {
            $query = "UPDATE jenis_senpi SET nama_jenis = :nama_jenis WHERE id = :id";
            try {
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nama_jenis', $nama_jenis);
                
                if($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Jenis Senpi berhasil diperbarui']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data']);
                }
            } catch(PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak valid']);
        }
        exit;
    }
    
    if($action == 'delete') {
        $id = intval($_POST['id']);
        
        if($id > 0) {
            $query = "DELETE FROM jenis_senpi WHERE id = :id";
            try {
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $id);
                
                if($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Jenis Senpi berhasil dihapus']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
                }
            } catch(PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
        exit;
    }
    
    if($action == 'get') {
        $id = intval($_POST['id']);
        
        if($id > 0) {
            $query = "SELECT * FROM jenis_senpi WHERE id = :id";
            try {
                $stmt = $db->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $data = $stmt->fetch();
                
                if($data) {
                    echo json_encode(['status' => 'success', 'data' => $data]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
                }
            } catch(PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        }
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
    <title>Jenis Senpi - BRIMOB Logistik & Senpi</title>
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
                        <h1 class="text-3xl font-bold text-[var(--text-primary)]">Jenis Senpi</h1>
                        <p class="text-[var(--text-secondary)]">Kelola daftar jenis senjata api BRIMOB</p>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <!-- Main Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-[var(--text-primary)]">Daftar Jenis Senpi</h2>
                    <button id="btnTambah" class="btn-transition px-4 py-2 bg-[var(--primary-color)] text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Tambah Jenis
                        </span>
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[var(--accent-color)]">
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] text-sm font-semibold">No</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] text-sm font-semibold">Nama Jenis Senpi</th>
                                <th class="text-left px-4 py-3 text-[var(--text-secondary)] text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <?php if(!empty($jenis_senpi_list)): ?>
                                <?php $no = 1; ?>
                                <?php foreach($jenis_senpi_list as $jenis): ?>
                                <tr class="border-b border-[var(--accent-color)] hover:bg-[var(--secondary-color)] transition-colors">
                                    <td class="px-4 py-3 text-[var(--text-primary)] text-sm font-medium"><?php echo $no++; ?></td>
                                    <td class="px-4 py-3 text-[var(--text-primary)] text-sm"><?php echo htmlspecialchars($jenis['nama_jenis']); ?></td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex gap-2">
                                            <button class="btnEdit btn-transition px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-medium hover:bg-yellow-200" data-id="<?php echo $jenis['id']; ?>" type="button">
                                                Edit
                                            </button>
                                            <button class="btnDelete btn-transition px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium hover:bg-red-200" data-id="<?php echo $jenis['id']; ?>" data-nama="<?php echo htmlspecialchars($jenis['nama_jenis']); ?>" type="button">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-[var(--text-secondary)]">
                                        Belum ada data jenis senpi
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="modalForm" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="modal-backdrop fixed inset-0 bg-black/60" id="formBackdrop"></div>
        <div class="modal-content bg-white rounded-lg shadow-2xl p-6 w-full max-w-md mx-4 relative">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-xl font-bold text-[var(--text-primary)]">Tambah Jenis Senpi</h3>
                <button id="btnCloseModal" class="text-[var(--text-secondary)] hover:text-[var(--text-primary)] p-1" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="formJenis" class="space-y-4">
                <input type="hidden" id="formId" name="id">
                
                <div>
                    <label class="block text-sm font-medium text-[var(--text-primary)] mb-2">Nama Jenis Senpi <span class="text-red-500">*</span></label>
                    <input type="text" id="formNama" name="nama_jenis" placeholder="Contoh: AK 101 KAL 5,56 mm" class="w-full px-4 py-2 border border-[var(--accent-color)] rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)]" required>
                    <small id="errorNama" class="text-red-500 hidden block mt-1"></small>
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
                <p class="text-[var(--text-secondary)] text-sm mt-2">Apakah Anda yakin ingin menghapus <span id="deleteItemName" class="font-semibold text-[var(--text-primary)]"></span>?</p>
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

            // Initialize button events
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
        const formJenis = document.getElementById('formJenis');

        function openFormModal(isEdit = false, id = null) {
            currentEditId = id;
            const modalTitle = document.getElementById('modalTitle');
            
            if(isEdit && id) {
                modalTitle.textContent = 'Edit Jenis Senpi';
                fetchFormData(id);
            } else {
                modalTitle.textContent = 'Tambah Jenis Senpi';
                formJenis.reset();
                document.getElementById('formId').value = '';
                document.getElementById('formNama').focus();
            }
            
            modalForm.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeFormModal() {
            modalForm.classList.add('hidden');
            document.body.style.overflow = '';
            formJenis.reset();
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
                    document.getElementById('formNama').value = data.data.nama_jenis;
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
        formJenis.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = new FormData();
            const id = document.getElementById('formId').value;
            
            if(id) {
                formData.append('action', 'edit');
                formData.append('id', id);
            } else {
                formData.append('action', 'add');
            }
            
            formData.append('nama_jenis', document.getElementById('formNama').value);

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
    </script>
</body>
</html>