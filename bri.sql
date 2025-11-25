-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2025 at 05:09 AM
-- Server version: 11.4.8-MariaDB-cll-lve
-- PHP Version: 8.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zgksnhcdze_brimoblogistik`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_logistik`
--

CREATE TABLE `data_logistik` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `kode_barang` varchar(100) DEFAULT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `satuan` varchar(50) NOT NULL DEFAULT 'Buah',
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat','Perlu Perbaikan') NOT NULL DEFAULT 'Baik',
  `lokasi` varchar(100) DEFAULT 'Gudang Logistik',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `data_logistik`
--

INSERT INTO `data_logistik` (`id`, `nama_barang`, `kode_barang`, `jumlah`, `satuan`, `kondisi`, `lokasi`, `keterangan`, `created_at`, `updated_at`) VALUES
(4, 'Alat bidik', '', 3, 'Unit', 'Baik', 'Gudang Logistik', '', '2025-11-11 04:06:08', '2025-11-21 14:45:30'),
(9, 'Teropong', '88', 4, 'Unit', 'Baik', 'Gudang B1', '', '2025-11-11 04:07:45', '2025-11-11 10:42:48'),
(11, 'Alat Optik', '-', 4, 'Unit', 'Baik', 'Gudang Logistik', '', '2025-11-11 04:08:23', '2025-11-11 08:09:48'),
(19, 'Kevlar', NULL, 60, 'Unit', 'Baik', 'Gudang Logistik', '', '2025-11-11 04:28:05', '2025-11-21 17:08:10'),
(20, 'FIELD BED', '000', 77, 'Buah', 'Baik', 'Gudang Logistik', '', '2025-11-19 01:26:52', '2025-11-22 01:25:23'),
(24, 'TAS SENPI MOLAY', '01', 43, 'Buah', 'Baik', 'Gudang Logistik', '', '2025-11-19 01:39:41', '2025-11-21 10:23:55'),
(25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 2522, 'butir', 'Baik', 'Gudang Logistik', '', '2025-11-19 02:06:18', '2025-11-22 01:25:23'),
(26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 1381, 'butir', 'Baik', 'Gudang Logistik', '', '2025-11-19 02:07:08', '2025-11-22 01:25:23'),
(30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3009, 'butir', 'Baik', 'Gudang Logistik', '', '2025-11-19 02:08:25', '2025-11-22 01:25:23'),
(31, 'MAG AK 101/102', '03', 218, 'Buah', 'Baik', 'Gudang Logistik', '', '2025-11-19 02:10:28', '2025-11-22 01:25:23'),
(32, 'MAG STEYR AUG', '11', 6, 'Unit', 'Baik', 'Gudang Logistik', '', '2025-11-21 10:19:25', '2025-11-21 19:25:45');

-- --------------------------------------------------------

--
-- Table structure for table `data_pemegang_senpi`
--

CREATE TABLE `data_pemegang_senpi` (
  `id` int(11) NOT NULL,
  `no` int(11) NOT NULL,
  `jenis_senpi` varchar(100) NOT NULL,
  `no_senpi` varchar(50) NOT NULL,
  `nama_pemegang` varchar(100) NOT NULL,
  `pangkat_nrp` varchar(100) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `data_pemegang_senpi`
--

INSERT INTO `data_pemegang_senpi` (`id`, `no`, `jenis_senpi`, `no_senpi`, `nama_pemegang`, `pangkat_nrp`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 'AK 101 KAL 5,56 mm', '1612.08296', 'SURIADI', 'BRIPKA /79051335', 'GUDANG', '2025-08-31 16:11:29', '2025-11-21 19:20:25'),
(2, 2, 'AK 101 KAL 5,56 mm', '1612.05433', 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'GUDANG', '2025-08-31 16:11:29', '2025-11-21 09:22:46'),
(3, 3, 'AK 101 KAL 5,56 mm', '1612.04487', 'AGUSNIADI, Amk', 'BRIPKA/84081923', 'GUDANG', '2025-08-31 16:11:29', '2025-11-18 05:34:16'),
(4, 4, 'AK 101 KAL 5,56 mm', '1612.05156', 'ZULFIKAR, Amd Kep', 'BRIPKA/84011292', 'GUDANG', '2025-08-31 16:11:29', '2025-11-09 09:45:15'),
(5, 5, 'AK 101 KAL 5,56 mm', '1612.05707', 'ANDI SURAHMI', 'BRIPKA/85011500', 'GUDANG', '2025-08-31 16:11:29', '2025-11-09 09:45:00'),
(6, 6, 'AK 101 KAL 5,56 mm', '1612.01123', 'DANI RAMADHAN', 'BRIPKA /85021099', 'GUDANG', '2025-08-31 16:11:29', '2025-11-11 06:02:33'),
(7, 7, 'AK 101 KAL 5,56 mm', '1612.05753', 'MULIADI, S.E', 'BRIPKA/85031484', 'GUDANG', '2025-08-31 16:11:29', '2025-11-11 06:05:28'),
(8, 8, 'AK 101 KAL 5,56 mm', '1612.10353', 'ARDIANSYAH', 'BRIPKA/85071421', 'DINAS', '2025-08-31 16:11:29', '2025-11-21 17:11:13'),
(9, 9, 'AK 101 KAL 5,56 mm', '1612.08694', 'AGUS EDWAR', 'BRIPKA/85081496', 'GUDANG', '2025-08-31 16:11:29', '2025-11-11 06:06:32'),
(10, 10, 'AK 101 KAL 5,56 mm', '1612.05325', 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'GUDANG', '2025-08-31 16:11:29', '2025-11-15 08:00:42'),
(11, 11, 'AK 101 KAL 5,56 mm', '1612.06888', 'FAUZI', 'BRIPKA /86051183', 'DINAS', '2025-08-31 16:11:29', '2025-11-21 17:17:49'),
(12, 12, 'AK 101 KAL 5,56 mm', '1612.04223', 'YUSWARDI YUSUF', 'BRIPKA/86070947', 'DINAS', '2025-08-31 16:11:29', '2025-11-22 01:25:23'),
(13, 13, 'AK 101 KAL 5,56 mm', '1612.06795', 'ASRIADI', 'BRIPKA /86120639', 'GUDANG', '2025-08-31 16:11:29', '2025-11-11 10:41:47'),
(14, 14, 'AK 101 KAL 5,56 mm', '1612.08322', 'ADI SAPUTRA', 'BRIPKA/84091744', 'GUDANG', '2025-08-31 16:11:29', '2025-11-11 10:42:28'),
(19, 15, 'AK 101 KAL 5,56 mm', '1612.08767', 'SYAHRUDDIN', 'BRIPKA/86061209', 'GUDANG', '2025-11-18 01:15:28', '2025-11-18 01:15:45'),
(20, 16, 'AK 101 KAL 5,56 mm', '1612.07328', 'KHAIRIANSYAH', 'BRIPKA/87031341', 'GUDANG', '2025-11-18 01:17:02', '2025-11-18 01:17:02'),
(21, 17, 'AK 101 KAL 5,56 mm', '1612.08814', 'YASSIR', 'BRIGADIR/85080320', 'GUDANG', '2025-11-18 01:17:41', '2025-11-18 01:17:41'),
(22, 18, 'AK 101 KAL 5,56 mm', '1612.09321', 'ALFIYANDA HARIADI FAJAR, S.Sos.', 'BRIGADIR/92120326', 'GUDANG', '2025-11-18 01:18:32', '2025-11-18 01:18:32'),
(23, 19, 'AK 101 KAL 5,56 mm', '1612.08487', 'HERMAN DERMAWAN', 'BRIGADIR/94020455', 'GUDANG', '2025-11-18 01:19:10', '2025-11-18 01:19:10'),
(24, 20, 'AK 101 KAL 5,56 mm', '1612.07788', 'MUHAMMAD FADHIL', 'BRIPDA/00090577', 'GUDANG', '2025-11-18 01:21:01', '2025-11-18 01:21:01'),
(25, 21, 'AK 101 KAL 5,56 mm', '1612.08464', 'EVA JUANDA', 'BRIPDA/01030269', 'GUDANG', '2025-11-18 01:26:46', '2025-11-18 01:26:46'),
(26, 22, 'AK 101 KAL 5,56 mm', '1612.07148', 'MUHAMMAD RINALDI', 'BRIPDA/02020183', 'GUDANG', '2025-11-18 01:28:22', '2025-11-18 01:28:22'),
(27, 23, 'AK 101 KAL 5,56 mm', '1612.04178', 'AKMAL', 'BRIPDA/01040721', 'GUDANG', '2025-11-18 01:29:15', '2025-11-18 01:29:15'),
(28, 24, 'AK 101 KAL 5,56 mm', '1612.08504', 'SUHADA ARDI ANDA', 'BRIPDA/93050438', 'GUDANG', '2025-11-18 01:30:03', '2025-11-18 01:30:03'),
(29, 25, 'AK 101 KAL 5,56 mm', '1612.06179', 'REZI FERNANDA RIZKY KARO KARO', 'BRIPDA/03021175', 'GUDANG', '2025-11-18 01:31:02', '2025-11-18 01:31:02'),
(30, 26, 'AK 101 KAL 5,56 mm', '1612.11432', 'RAHMAD FAZIL', 'BRIPDA/03041321', 'GUDANG', '2025-11-18 01:32:32', '2025-11-18 01:32:32'),
(31, 27, 'AK 101 KAL 5,56 mm', '1612.06622', 'BUGE YEKARIZKI', 'BRIPDA/03061438', 'GUDANG', '2025-11-18 01:33:20', '2025-11-18 01:33:20'),
(32, 28, 'AK 101 KAL 5,56 mm', '1612.00054', 'SYIBRAL MALAYSI', 'BRIPDA/03081255', 'GUDANG', '2025-11-18 01:34:18', '2025-11-18 01:34:18'),
(33, 29, 'AK 101 KAL 5,56 mm', '1612.10642', 'HILMI ANDREAN', 'BRIPDA/03091019', 'GUDANG', '2025-11-18 01:35:10', '2025-11-18 01:35:10'),
(34, 30, 'AK 101 KAL 5,56 mm', '1612.11089', 'FITRA ADRIANSYAH', 'BRIPDA/03111156', 'GUDANG', '2025-11-18 01:35:57', '2025-11-18 01:35:57'),
(35, 31, 'AK 101 KAL 5,56 mm', '1612.06146', 'ARDHIE FAZHAR T LUBIS', 'BRIPDA/04010980', 'GUDANG', '2025-11-18 01:36:50', '2025-11-18 01:36:50'),
(36, 32, 'AK 101 KAL 5,56 mm', '1612.11642', 'MUHAMMAD IKRAM', 'BRIPDA/04030859', 'GUDANG', '2025-11-18 01:37:49', '2025-11-18 01:37:49'),
(37, 33, 'AK 101 KAL 5,56 mm', '1612.09043', 'RAGIEL SIRAJD', 'BRIPDA/04040616', 'GUDANG', '2025-11-18 01:38:23', '2025-11-21 10:20:07'),
(38, 34, 'AK 101 KAL 5,56 mm', '1612.06359', 'MUHAMMAD FIRJATULLAH', 'BRIPDA/04060682', 'GUDANG', '2025-11-18 01:39:06', '2025-11-18 01:39:06'),
(39, 35, 'AK 101 KAL 5,56 mm', '1612.11514', 'IRZA FAMUNGKAS', 'BRIPDA/04060556', 'GUDANG', '2025-11-18 01:39:59', '2025-11-18 01:39:59'),
(40, 36, 'AK 101 KAL 5,56 mm', '1612.09381', 'JOHAN SEBASTIAN', 'BRIPDA/04090483', 'GUDANG', '2025-11-18 01:40:54', '2025-11-18 01:40:54'),
(41, 37, 'AK 101 KAL 5,56 mm', '1612.10242', 'ZULFAHRI', 'BAHARAKA/92010480', 'GUDANG', '2025-11-18 04:36:33', '2025-11-18 04:36:33'),
(42, 38, 'AK 101 KAL 5,56 mm', '1612.10258', 'SUHAIDI', 'BAHARAKA/92010480', 'GUDANG', '2025-11-18 04:37:20', '2025-11-18 04:37:20'),
(43, 39, 'AK 101 KAL 5,56 mm', '1612.09772', 'IPANDI', 'BHARAKA/92090437', 'GUDANG', '2025-11-18 04:38:27', '2025-11-18 04:38:27'),
(44, 40, 'AK 101 KAL 5,56 mm', '1612.02471', 'MUHAMMAD NASIR', 'BHARAKA/93120326', 'GUDANG', '2025-11-18 04:39:31', '2025-11-18 04:39:31'),
(45, 41, 'AK 101 KAL 5,56 mm', '1612.09590', 'BARMAURI', 'BHARAKA/94110160', 'DINAS', '2025-11-18 04:40:31', '2025-11-21 17:21:23'),
(46, 42, 'AK 101 KAL 5,56 mm', '1612.05820', 'RENDI FIRMANSYAH', 'BHARAKA/94110160', 'GUDANG', '2025-11-18 04:41:59', '2025-11-18 04:41:59'),
(47, 43, 'AK 101 KAL 5,56 mm', '1612.08004', 'IKHWAN MAULANA', 'BHARAKA/97040005', 'GUDANG', '2025-11-18 04:43:33', '2025-11-18 04:43:33'),
(48, 44, 'AK 101 KAL 5,56 mm', '1612.03353', 'PURNAMA SANI', 'BAHARAKA/93101129', 'GUDANG', '2025-11-18 04:44:25', '2025-11-18 04:44:25'),
(49, 45, 'AK 101 KAL 5,56 mm', '1612.12121', 'MUHAMMAD FAUZAN', 'BRIPDA/02091763', 'DINAS', '2025-11-18 04:45:41', '2025-11-22 00:53:26'),
(50, 46, 'AK 101 KAL 5,56 mm', '1612.10473', 'RUTHAN ALI RAMADHAN', 'BRIPDA/02111764', 'DINAS', '2025-11-18 05:21:25', '2025-11-22 00:52:07'),
(51, 47, 'AK 101 KAL 5,56 mm', '1612.09391', 'JUEN AKSHA', 'BRIPDA/04090741', 'DINAS', '2025-11-18 05:22:27', '2025-11-22 00:50:51'),
(52, 48, 'AK 101 KAL 5,56 mm', '1612.10152', 'M. BUCHARI', 'BHARADA/02071749', 'GUDANG', '2025-11-18 05:23:03', '2025-11-21 04:22:46'),
(53, 49, 'AK 101 KAL 5,56 mm', '1612.09724', 'DONI SETIAWAN', 'BHARADA/03051939', 'GUDANG', '2025-11-18 05:24:03', '2025-11-21 04:22:49'),
(54, 50, 'AK 101 KAL 5,56 mm', '1612.10318', 'M. RIZKY HIDAYAT', 'BHARADA/03061879', 'DINAS', '2025-11-18 05:24:40', '2025-11-22 00:49:33'),
(55, 51, 'AK 102 KAL 5.56 mm', '1710.66796', 'EDY SUWANTA GINTING', 'AIPDA/77071000', 'GUDANG', '2025-11-18 05:25:38', '2025-11-18 05:25:38'),
(56, 52, 'AK 102 KAL 5.56 mm', '1710.60451', 'JOKO DWI SANTOSO, S.H.', 'AIPDA/86020965', 'GUDANG', '2025-11-18 05:26:16', '2025-11-18 05:26:16'),
(57, 53, 'AK 102 KAL 5.56 mm', '1710.60889', 'FIRDAUS SOFYAN', 'AIPTU/82080358', 'GUDANG', '2025-11-18 05:26:59', '2025-11-18 05:26:59'),
(58, 54, 'AK 102 KAL 5.56 mm', '1710.61805', 'MUSMULYADI', 'AIPDA/77070921', 'DINAS', '2025-11-18 05:29:03', '2025-11-21 17:09:53'),
(59, 55, 'AK 102 KAL 5.56 mm', '1712.80151', 'GUNAWAN, S.H.', 'AIPDA/85051656', 'GUDANG', '2025-11-18 05:29:45', '2025-11-18 05:29:45'),
(60, 56, 'AK 102 KAL 5.56 mm', '1710.65131', 'SUKRI', 'BRIPKA/83081578', 'GUDANG', '2025-11-18 05:30:21', '2025-11-18 05:30:21'),
(61, 57, 'AK 102 KAL 5.56 mm', '1710.61632', 'ARI IRAWAN', 'BRIPKA/84101843', 'DINAS', '2025-11-18 05:30:57', '2025-11-21 17:20:05'),
(62, 58, 'AK 102 KAL 5.56 mm', '1710.61956', 'BAGUS OKTAFRIZAL, S.H.', 'BRIGADIR/92100587', 'GUDANG', '2025-11-18 05:31:29', '2025-11-21 17:13:56'),
(63, 59, 'AK 102 KAL 5.56 mm', '1710.64416', 'ZULKARNAINI', 'AIPDA/77070589', 'GUDANG', '2025-11-18 05:32:16', '2025-11-18 05:32:16'),
(64, 60, 'AK 102 KAL 5.56 mm', '1710.61845', 'ANDERSON LUBIS', 'AIPDA/77070609', 'GUDANG', '2025-11-18 05:33:12', '2025-11-21 04:23:00'),
(65, 61, 'AK 102 KAL 5.56 mm', '1710.61709', 'MULYANA', 'BRIPKA/87040232', 'GUDANG', '2025-11-18 05:33:47', '2025-11-21 04:23:04'),
(67, 63, 'STEYR AUG KAL 5.56 mm', '312583', 'SYAIFULLAH SIPAHUTAR, S.H.', 'AKP/76070342', 'GUDANG', '2025-11-18 05:38:41', '2025-11-21 13:48:23'),
(68, 62, 'STEYR AUG KAL 5.56 mm', '3082013', 'MARSUDI, A.Md., S.T.', 'IPDA/83011186', 'DINAS', '2025-11-21 04:22:37', '2025-11-21 17:16:43');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_senpi`
--

CREATE TABLE `jenis_senpi` (
  `id` int(11) NOT NULL,
  `nama_jenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_senpi`
--

INSERT INTO `jenis_senpi` (`id`, `nama_jenis`) VALUES
(1, 'AK 101 KAL 5,56 mm'),
(2, 'AK 102 KAL 5.56 mm'),
(4, 'GLOCK 17 C Kal 9x19 mm'),
(6, 'HS-9 Kal 9x19 mm'),
(7, 'MINIMI FN Kal 5.56x45 mm 5Tj link'),
(8, 'OOW M 249 Kal 5.56x45 mm 5Tj link'),
(5, 'SIG SAUE P 320 KAL 9 mm'),
(11, 'SPR A1 PINDAD 7.62 mm'),
(3, 'STEYR AUG KAL 5.56 mm'),
(10, 'STEYR SSG 08 SNIPER Kal 7.62 mm'),
(9, 'ULTIMAX 100 Kal 5.56x45 mm 5 Tj');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_dinas`
--

CREATE TABLE `peminjaman_dinas` (
  `id` int(11) NOT NULL,
  `nama_tugas` varchar(255) NOT NULL,
  `penanggung_jawab_nrp` varchar(100) NOT NULL,
  `penanggung_jawab_nama` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai_estimasi` date NOT NULL,
  `status` enum('Berlangsung','Selesai') NOT NULL DEFAULT 'Berlangsung',
  `tipe_peminjaman` enum('Dinas','Tetap') NOT NULL DEFAULT 'Dinas',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `peminjaman_dinas`
--

INSERT INTO `peminjaman_dinas` (`id`, `nama_tugas`, `penanggung_jawab_nrp`, `penanggung_jawab_nama`, `tanggal_mulai`, `tanggal_selesai_estimasi`, `status`, `tipe_peminjaman`, `keterangan`, `created_at`) VALUES
(17, 'PENGAMANAN BKO PTPN COT GIREK', 'BRIPDA/04040616', 'RAGIEL SIRAJD', '2025-11-26', '2025-11-25', 'Berlangsung', 'Dinas', '', '2025-11-21 10:23:55'),
(18, 'Peminjaman Tetap', 'BRIGADIR/92100587', 'BAGUS OKTAFRIZAL, S.H.', '2025-11-26', '2025-11-27', 'Berlangsung', 'Tetap', 'PAM PTPN COT GIREK', '2025-11-21 10:25:07'),
(19, 'PENGAMANAN BKO PTPN COT GIREK', 'BRIPDA/03061438', 'BUGE YEKARIZKI', '2025-11-25', '2025-11-19', 'Berlangsung', 'Dinas', 'PAM PTPN COT GIREK', '2025-11-21 10:26:42'),
(27, 'PENGAMANAN BKO PTPN COT GIREK', 'AIPDA/77070921', 'MUSMULYADI', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-21 17:09:53'),
(28, 'PENGAMANAN BKO PTPN COT GIREK', 'BRIPKA/85071421', 'ARDIANSYAH', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-21 17:11:13'),
(29, 'PENGAMANAN BKO PTPN COT GIREK', 'IPDA/83011186', 'MARSUDI, A.Md., S.T.', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-21 17:16:43'),
(30, 'PENGAMANAN BKO PTPN COT GIREK', 'BRIPKA /86051183', 'FAUZI', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-21 17:17:49'),
(31, 'PENGAMANAN BKO PTPN COT GIREK', 'BRIPKA/84101843', 'ARI IRAWAN', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-21 17:20:05'),
(32, 'PENGAMANAN BKO PTPN COT GIREK', 'BHARAKA/94110160', 'BARMAURI', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-21 17:21:23'),
(33, 'PENGAMANAN BKO PTPN COT GIREK', 'BHARADA/03061879', 'M. RIZKY HIDAYAT', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-22 00:49:33'),
(34, 'PENGAMANAN BKO PTPN COT GIREK', 'BRIPDA/04090741', 'JUEN AKSHA', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-22 00:50:51'),
(35, 'PENGAMANAN BKO PTPN COT GIREK', 'BRIPDA/02111764', 'RUTHAN ALI RAMADHAN', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-22 00:52:07'),
(36, 'PENGAMANAN BKO PTPN COT GIREK', 'BRIPDA/02091763', 'MUHAMMAD FAUZAN', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-22 00:53:26'),
(37, 'PENGAMANAN BKO PTPN COT GIREK', 'BRIPKA/86070947', 'YUSWARDI YUSUF', '2025-11-10', '2025-11-30', 'Berlangsung', '', 'PAM PTPN COT GIREK', '2025-11-22 01:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_dinas_items`
--

CREATE TABLE `peminjaman_dinas_items` (
  `id` int(11) NOT NULL,
  `id_peminjaman_dinas` int(11) NOT NULL,
  `tipe_item` enum('Senpi','Logistik') NOT NULL,
  `id_item` int(11) NOT NULL,
  `nama_item` varchar(255) NOT NULL,
  `no_seri_item` varchar(100) DEFAULT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `status_item` enum('Dipinjam','Dikembalikan') NOT NULL DEFAULT 'Dipinjam',
  `tanggal_kembali_aktual` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `peminjaman_dinas_items`
--

INSERT INTO `peminjaman_dinas_items` (`id`, `id_peminjaman_dinas`, `tipe_item`, `id_item`, `nama_item`, `no_seri_item`, `jumlah`, `status_item`, `tanggal_kembali_aktual`) VALUES
(34, 17, 'Logistik', 24, 'TAS SENPI MOLAY', '01', 1, 'Dipinjam', NULL),
(35, 18, 'Logistik', 31, 'MAG AK 101/102', '03', 1, 'Dipinjam', NULL),
(36, 19, 'Logistik', 31, 'MAG AK 101/102', '03', 1, 'Dipinjam', NULL),
(44, 27, 'Senpi', 58, '1710.61805', '1710.61805', 1, 'Dipinjam', NULL),
(45, 27, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(46, 27, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 38, 'Dipinjam', NULL),
(47, 27, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(48, 27, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(49, 27, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(50, 28, 'Senpi', 8, '1612.10353', '1612.10353', 1, 'Dipinjam', NULL),
(51, 28, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(52, 28, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 37, 'Dipinjam', NULL),
(53, 28, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(54, 28, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(55, 28, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(56, 29, 'Senpi', 68, '3082013', '3082013', 1, 'Dipinjam', NULL),
(57, 29, 'Logistik', 32, 'MAG STEYR AUG', '11', 3, 'Dipinjam', NULL),
(58, 29, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(59, 29, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 37, 'Dipinjam', NULL),
(60, 29, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(61, 29, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(62, 30, 'Senpi', 11, '1612.06888', '1612.06888', 1, 'Dipinjam', NULL),
(63, 30, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(64, 30, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(65, 30, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 38, 'Dipinjam', NULL),
(66, 30, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(67, 30, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(68, 31, 'Senpi', 61, '1710.61632', '1710.61632', 1, 'Dipinjam', NULL),
(69, 31, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(70, 31, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(71, 31, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 37, 'Dipinjam', NULL),
(72, 31, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(73, 31, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(74, 32, 'Senpi', 45, '1612.09590', '1612.09590', 1, 'Dipinjam', NULL),
(75, 32, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(76, 32, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(77, 32, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 37, 'Dipinjam', NULL),
(78, 32, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(79, 32, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(80, 33, 'Senpi', 54, '1612.10318', '1612.10318', 1, 'Dipinjam', NULL),
(81, 33, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(82, 33, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(83, 33, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 37, 'Dipinjam', NULL),
(84, 33, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(85, 33, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(86, 34, 'Senpi', 51, '1612.09391', '1612.09391', 1, 'Dipinjam', NULL),
(87, 34, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(88, 34, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(89, 34, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 37, 'Dipinjam', NULL),
(90, 34, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(91, 34, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(92, 35, 'Senpi', 50, '1612.10473', '1612.10473', 1, 'Dipinjam', NULL),
(93, 35, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(94, 35, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(95, 35, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 37, 'Dipinjam', NULL),
(96, 35, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(97, 35, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(98, 36, 'Senpi', 49, '1612.12121', '1612.12121', 1, 'Dipinjam', NULL),
(99, 36, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(100, 36, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(101, 36, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 37, 'Dipinjam', NULL),
(102, 36, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 1, 'Dipinjam', NULL),
(103, 36, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL),
(104, 37, 'Senpi', 12, '1612.04223', '1612.04223', 1, 'Dipinjam', NULL),
(105, 37, 'Logistik', 31, 'MAG AK 101/102', '03', 3, 'Dipinjam', NULL),
(106, 37, 'Logistik', 25, 'TAJAM Ammunisi Kal 5.56x45 mm 4 TJ', '02', 20, 'Dipinjam', NULL),
(107, 37, 'Logistik', 26, 'KARET Ammunisi Kal 5.56x45 mm ', '0000', 37, 'Dipinjam', NULL),
(108, 37, 'Logistik', 30, 'HAMPA Ammunisi Kal 5.56x45 mm ', '00000', 3, 'Dipinjam', NULL),
(109, 37, 'Logistik', 20, 'FIELD BED', '000', 1, 'Dipinjam', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_log`
--

CREATE TABLE `peminjaman_log` (
  `id` int(11) NOT NULL,
  `senpi_id` int(11) NOT NULL,
  `nama_pemegang` varchar(100) NOT NULL,
  `pangkat_nrp` varchar(100) NOT NULL,
  `jenis_senpi` varchar(100) NOT NULL,
  `no_senpi` varchar(50) NOT NULL,
  `jenis_peminjaman` enum('rutin','tetap','dinas','pelatihan','bko') NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') DEFAULT 'dipinjam',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `peminjaman_log`
--

INSERT INTO `peminjaman_log` (`id`, `senpi_id`, `nama_pemegang`, `pangkat_nrp`, `jenis_senpi`, `no_senpi`, `jenis_peminjaman`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-09-29 09:46:52', '2025-09-29 17:19:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-09-29 09:46:52', '2025-09-29 10:19:26'),
(2, 2, 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'AK 101 KAL 5,56 mm', '1612.05433', 'rutin', '2025-09-29 10:20:33', '2025-09-29 17:20:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-09-29 10:20:33', '2025-09-29 10:20:42'),
(3, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-09-29 10:21:39', '2025-09-29 17:21:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-09-29 10:21:39', '2025-09-29 10:21:45'),
(4, 2, 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'AK 101 KAL 5,56 mm', '1612.05433', 'rutin', '2025-11-09 08:26:06', '2025-11-09 15:27:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 08:26:06', '2025-11-09 08:26:14'),
(5, 1, 'SURIADI', 'BRIPKA /79051335', 'AK 101 KAL 5,56 mm', '1612.08296', 'rutin', '2025-11-09 09:23:04', '2025-11-09 16:45:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:23:04', '2025-11-09 09:45:10'),
(6, 2, 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'AK 101 KAL 5,56 mm', '1612.05433', 'rutin', '2025-11-09 09:23:14', '2025-11-09 16:46:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:23:14', '2025-11-09 09:45:25'),
(7, 3, 'AGUS NIADI, Amk', 'BRIPKA/84081923', 'AK 101 KAL 5,56 mm', '1612.04487', 'rutin', '2025-11-09 09:23:21', '2025-11-09 16:46:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:23:21', '2025-11-09 09:45:20'),
(8, 4, 'ZULFIKAR, Amd Kep', 'BRIPKA/84011292', 'AK 101 KAL 5,56 mm', '1612.05156', 'rutin', '2025-11-09 09:23:27', '2025-11-09 16:46:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:23:27', '2025-11-09 09:45:15'),
(9, 5, 'ANDI SURAHMI', 'BRIPKA/85011500', 'AK 101 KAL 5,56 mm', '1612.05707', 'rutin', '2025-11-09 09:23:34', '2025-11-09 16:45:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:23:34', '2025-11-09 09:45:00'),
(10, 6, 'DANI RAMADHAN', 'BRIPKA /85021099', 'AK 101 KAL 5,56 mm', '1612.01123', 'rutin', '2025-11-09 09:23:44', '2025-11-09 16:45:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:23:44', '2025-11-09 09:45:05'),
(11, 7, 'MULIADI, S.E', 'BRIPKA/85031484', 'AK 101 KAL 5,56 mm', '1612.05753', 'rutin', '2025-11-09 09:23:49', '2025-11-09 16:45:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:23:49', '2025-11-09 09:44:56'),
(12, 8, 'ARDIANSYAH', 'BRIPKA/85071421', 'AK 101 KAL 5,56 mm', '1612.10353', 'rutin', '2025-11-09 09:23:53', '2025-11-09 16:45:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:23:53', '2025-11-09 09:44:50'),
(13, 9, 'AGUS EDWAR', 'BRIPKA/85081496', 'AK 101 KAL 5,56 mm', '1612.08694', 'rutin', '2025-11-09 09:24:00', '2025-11-09 16:26:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:24:00', '2025-11-09 09:25:44'),
(14, 9, 'AGUS EDWAR', 'BRIPKA/85081496', 'AK 101 KAL 5,56 mm', '1612.08694', 'rutin', '2025-11-09 09:24:08', '2025-11-09 16:28:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:24:08', '2025-11-09 09:27:34'),
(15, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-09 09:24:27', '2025-11-09 16:28:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:24:27', '2025-11-09 09:27:14'),
(16, 11, 'FAUZI', 'BRIPKA /86051183', 'AK 101 KAL 5,56 mm', '1612.06888', 'rutin', '2025-11-09 09:45:31', '2025-11-09 16:46:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:45:31', '2025-11-09 09:45:49'),
(17, 11, 'FAUZI', 'BRIPKA /86051183', 'AK 101 KAL 5,56 mm', '1612.06888', 'rutin', '2025-11-09 09:45:42', '2025-11-09 16:46:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 09:45:42', '2025-11-09 09:45:47'),
(18, 13, 'ASRIADI', 'BRIPKA /86120639', 'AK 101 KAL 5,56 mm', '1612.06795', 'rutin', '2025-11-09 09:51:11', '2025-11-09 04:51:20', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:51:11', '2025-11-09 09:51:20'),
(19, 14, 'ADI SAPUTRA', 'BRIPKA/84091744', 'AK 101 KAL 5,56 mm', '1612.08322', 'rutin', '2025-11-09 09:51:48', '2025-11-09 04:51:54', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:51:48', '2025-11-09 09:51:54'),
(20, 14, 'ADI SAPUTRA', 'BRIPKA/84091744', 'AK 101 KAL 5,56 mm', '1612.08322', 'rutin', '2025-11-09 09:55:58', '2025-11-09 04:58:23', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:55:58', '2025-11-09 09:58:23'),
(21, 13, 'ASRIADI', 'BRIPKA /86120639', 'AK 101 KAL 5,56 mm', '1612.06795', 'rutin', '2025-11-09 09:56:01', '2025-11-09 04:58:22', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:56:01', '2025-11-09 09:58:22'),
(22, 12, 'YUSWARDI YUSUF', 'BRIPKA/86070947', 'AK 101 KAL 5,56 mm', '1612.04223', 'rutin', '2025-11-09 09:56:05', '2025-11-09 04:58:20', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:56:05', '2025-11-09 09:58:20'),
(23, 11, 'FAUZI', 'BRIPKA /86051183', 'AK 101 KAL 5,56 mm', '1612.06888', 'rutin', '2025-11-09 09:56:07', '2025-11-09 04:58:17', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:56:07', '2025-11-09 09:58:17'),
(24, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-09 09:56:09', '2025-11-09 04:58:15', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:56:09', '2025-11-09 09:58:15'),
(25, 9, 'AGUS EDWAR', 'BRIPKA/85081496', 'AK 101 KAL 5,56 mm', '1612.08694', 'rutin', '2025-11-09 09:56:11', '2025-11-09 04:56:13', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:56:11', '2025-11-09 09:56:13'),
(26, 7, 'MULIADI, S.E', 'BRIPKA/85031484', 'AK 101 KAL 5,56 mm', '1612.05753', 'rutin', '2025-11-09 09:56:18', '2025-11-09 04:58:10', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:56:18', '2025-11-09 09:58:10'),
(27, 8, 'ARDIANSYAH', 'BRIPKA/85071421', 'AK 101 KAL 5,56 mm', '1612.10353', 'rutin', '2025-11-09 09:56:20', '2025-11-09 04:58:08', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:56:20', '2025-11-09 09:58:08'),
(28, 6, 'DANI RAMADHAN', 'BRIPKA /85021099', 'AK 101 KAL 5,56 mm', '1612.01123', 'rutin', '2025-11-09 09:56:24', '2025-11-09 04:56:26', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:56:24', '2025-11-09 09:56:26'),
(29, 6, 'DANI RAMADHAN', 'BRIPKA /85021099', 'AK 101 KAL 5,56 mm', '1612.01123', 'rutin', '2025-11-09 09:56:50', '2025-11-09 04:56:58', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:56:50', '2025-11-09 09:56:58'),
(30, 6, 'DANI RAMADHAN', 'BRIPKA /85021099', 'AK 101 KAL 5,56 mm', '1612.01123', 'rutin', '2025-11-09 09:57:57', '2025-11-09 04:58:05', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:57:57', '2025-11-09 09:58:05'),
(31, 9, 'AGUS EDWAR', 'BRIPKA/85081496', 'AK 101 KAL 5,56 mm', '1612.08694', 'rutin', '2025-11-09 09:58:11', '2025-11-09 04:58:13', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:58:11', '2025-11-09 09:58:13'),
(32, 8, 'ARDIANSYAH', 'BRIPKA/85071421', 'AK 101 KAL 5,56 mm', '1612.10353', 'rutin', '2025-11-09 09:59:03', '2025-11-09 04:59:13', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 09:59:03', '2025-11-09 09:59:13'),
(33, 8, 'ARDIANSYAH', 'BRIPKA/85071421', 'AK 101 KAL 5,56 mm', '1612.10353', 'rutin', '2025-11-09 10:06:50', '2025-11-09 05:07:07', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 10:06:50', '2025-11-09 10:07:07'),
(34, 9, 'AGUS EDWAR', 'BRIPKA/85081496', 'AK 101 KAL 5,56 mm', '1612.08694', 'rutin', '2025-11-09 10:07:02', '2025-11-09 05:07:05', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 10:07:02', '2025-11-09 10:07:05'),
(35, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-09 10:08:11', '2025-11-09 05:08:55', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 10:08:11', '2025-11-09 10:08:55'),
(36, 8, 'ARDIANSYAH', 'BRIPKA/85071421', 'AK 101 KAL 5,56 mm', '1612.10353', 'rutin', '2025-11-09 10:08:18', '2025-11-09 05:08:51', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 10:08:18', '2025-11-09 10:08:51'),
(37, 11, 'FAUZI', 'BRIPKA /86051183', 'AK 101 KAL 5,56 mm', '1612.06888', 'rutin', '2025-11-09 10:09:07', '2025-11-09 05:12:07', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 10:09:07', '2025-11-09 10:12:07'),
(38, 11, 'FAUZI', 'BRIPKA /86051183', 'AK 101 KAL 5,56 mm', '1612.06888', 'rutin', '2025-11-09 10:12:11', '2025-11-09 05:12:17', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 10:12:11', '2025-11-09 10:12:17'),
(39, 11, 'FAUZI', 'BRIPKA /86051183', 'AK 101 KAL 5,56 mm', '1612.06888', 'rutin', '2025-11-09 10:18:28', '2025-11-09 05:18:35', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 10:18:28', '2025-11-09 10:18:35'),
(40, 11, 'FAUZI', 'BRIPKA /86051183', 'AK 101 KAL 5,56 mm', '1612.06888', 'rutin', '2025-11-09 10:18:38', '2025-11-09 05:18:40', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 10:18:38', '2025-11-09 10:18:40'),
(41, 11, 'FAUZI', 'BRIPKA /86051183', 'AK 101 KAL 5,56 mm', '1612.06888', 'rutin', '2025-11-09 17:11:23', '2025-11-10 00:12:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan: ', '2025-11-09 17:11:23', '2025-11-09 17:11:28'),
(42, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-09 17:11:37', '2025-11-10 02:05:04', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-09 17:11:37', '2025-11-10 07:05:04'),
(43, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-10 07:05:12', '2025-11-10 02:05:16', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:05:12', '2025-11-10 07:05:16'),
(44, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-10 07:05:32', '2025-11-10 02:05:40', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:05:32', '2025-11-10 07:05:40'),
(45, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-10 07:28:08', '2025-11-10 02:28:11', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:28:08', '2025-11-10 07:28:11'),
(46, 11, 'FAUZI', 'BRIPKA /86051183', 'AK 101 KAL 5,56 mm', '1612.06888', 'rutin', '2025-11-10 07:28:17', '2025-11-10 02:28:33', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:28:17', '2025-11-10 07:28:33'),
(47, 14, 'ADI SAPUTRA', 'BRIPKA/84091744', 'AK 101 KAL 5,56 mm', '1612.08322', 'rutin', '2025-11-10 07:28:25', '2025-11-10 02:28:38', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:28:25', '2025-11-10 07:28:38'),
(48, 13, 'ASRIADI', 'BRIPKA /86120639', 'AK 101 KAL 5,56 mm', '1612.06795', 'rutin', '2025-11-10 07:28:26', '2025-11-10 02:28:37', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:28:26', '2025-11-10 07:28:37'),
(49, 12, 'YUSWARDI YUSUF', 'BRIPKA/86070947', 'AK 101 KAL 5,56 mm', '1612.04223', 'rutin', '2025-11-10 07:28:27', '2025-11-10 02:28:36', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:28:27', '2025-11-10 07:28:36'),
(50, 14, 'ADI SAPUTRA', 'BRIPKA/84091744', 'AK 101 KAL 5,56 mm', '1612.08322', 'rutin', '2025-11-10 07:30:26', '2025-11-10 02:32:18', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:30:26', '2025-11-10 07:32:18'),
(51, 14, 'ADI SAPUTRA', 'BRIPKA/84091744', 'AK 101 KAL 5,56 mm', '1612.08322', 'rutin', '2025-11-10 14:32:32', '2025-11-10 02:32:39', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:32:32', '2025-11-10 07:32:39'),
(52, 14, 'ADI SAPUTRA', 'BRIPKA/84091744', 'AK 101 KAL 5,56 mm', '1612.08322', 'rutin', '2025-11-10 14:33:54', '2025-11-10 02:36:13', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:33:54', '2025-11-10 07:36:13'),
(53, 13, 'ASRIADI', 'BRIPKA /86120639', 'AK 101 KAL 5,56 mm', '1612.06795', 'rutin', '2025-11-10 14:37:48', '2025-11-10 02:38:27', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-10 07:37:48', '2025-11-10 07:38:27'),
(54, 6, 'DANI RAMADHAN', 'BRIPKA /85021099', 'AK 101 KAL 5,56 mm', '1612.01123', 'rutin', '2025-11-11 12:16:08', '2025-11-11 00:16:14', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 05:16:08', '2025-11-11 05:16:14'),
(55, 6, 'DANI RAMADHAN', 'BRIPKA /85021099', 'AK 101 KAL 5,56 mm', '1612.01123', 'rutin', '2025-11-11 12:49:17', '2025-11-11 00:49:19', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 05:49:17', '2025-11-11 05:49:19'),
(56, 6, 'DANI RAMADHAN', 'BRIPKA /85021099', 'AK 101 KAL 5,56 mm', '1612.01123', 'rutin', '2025-11-11 13:02:25', '2025-11-11 01:02:33', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 06:02:25', '2025-11-11 06:02:33'),
(57, 7, 'MULIADI, S.E', 'BRIPKA/85031484', 'AK 101 KAL 5,56 mm', '1612.05753', 'rutin', '2025-11-11 13:05:24', '2025-11-11 01:05:28', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 06:05:24', '2025-11-11 06:05:28'),
(58, 8, 'ARDIANSYAH', 'BRIPKA/85071421', 'AK 101 KAL 5,56 mm', '1612.10353', 'rutin', '2025-11-11 13:05:50', '2025-11-11 01:05:55', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 06:05:50', '2025-11-11 06:05:55'),
(59, 9, 'AGUS EDWAR', 'BRIPKA/85081496', 'AK 101 KAL 5,56 mm', '1612.08694', 'rutin', '2025-11-11 13:06:29', '2025-11-11 01:06:32', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 06:06:29', '2025-11-11 06:06:32'),
(60, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-11 16:54:26', '2025-11-11 04:54:31', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 09:54:26', '2025-11-11 09:54:31'),
(61, 13, 'ASRIADI', 'BRIPKA /86120639', 'AK 101 KAL 5,56 mm', '1612.06795', 'rutin', '2025-11-11 17:41:25', '2025-11-11 05:41:47', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 10:41:25', '2025-11-11 10:41:47'),
(62, 14, 'ADI SAPUTRA', 'BRIPKA/84091744', 'AK 101 KAL 5,56 mm', '1612.08322', 'rutin', '2025-11-11 17:42:01', '2025-11-11 05:42:28', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 10:42:01', '2025-11-11 10:42:28'),
(63, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-11 17:42:14', '2025-11-11 05:42:24', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-11 10:42:14', '2025-11-11 10:42:24'),
(64, 3, 'AGUS NIADI, Amk', 'BRIPKA/84081923', 'AK 101 KAL 5,56 mm', '1612.04487', 'rutin', '2025-11-15 12:50:20', '2025-11-15 00:50:25', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-15 05:50:20', '2025-11-15 05:50:25'),
(65, 3, 'AGUS NIADI, Amk', 'BRIPKA/84081923', 'AK 101 KAL 5,56 mm', '1612.04487', 'rutin', '2025-11-15 12:51:24', '2025-11-15 00:51:31', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-15 05:51:24', '2025-11-15 05:51:31'),
(66, 10, 'MUHAMMAD NASIR', 'BRIPKA/85111084', 'AK 101 KAL 5,56 mm', '1612.05325', 'rutin', '2025-11-15 15:00:27', '2025-11-15 15:00:00', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan:  | Dikembalikan:  | Dikembalikan: ', '2025-11-15 08:00:27', '2025-11-15 08:00:51'),
(67, 2, 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'AK 101 KAL 5,56 mm', '1612.05433', 'rutin', '2025-11-21 15:34:15', '2025-11-21 03:34:19', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-21 08:34:15', '2025-11-21 08:34:19'),
(68, 2, 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'AK 101 KAL 5,56 mm', '1612.05433', 'rutin', '2025-11-21 15:34:29', '2025-11-21 03:35:20', 'dikembalikan', 'Dicatat otomatis via scan/input | Dikembalikan otomatis via scan', '2025-11-21 08:34:29', '2025-11-21 08:35:20'),
(69, 2, 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'AK 101 KAL 5,56 mm', '1612.05433', 'rutin', '2025-11-21 15:51:51', '2025-11-21 03:51:56', 'dikembalikan', 'Peminjaman rutin via scan | Dikembalikan otomatis via scan', '2025-11-21 08:51:51', '2025-11-21 08:51:56'),
(70, 2, 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'AK 101 KAL 5,56 mm', '1612.05433', 'rutin', '2025-11-21 15:59:57', '2025-11-21 03:59:59', 'dikembalikan', 'Peminjaman rutin via scan | Dikembalikan otomatis via scan', '2025-11-21 08:59:57', '2025-11-21 08:59:59'),
(71, 2, 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'AK 101 KAL 5,56 mm', '1612.05433', 'rutin', '2025-11-21 16:21:40', '2025-11-21 04:21:43', 'dikembalikan', 'Peminjaman rutin via scan | Dikembalikan otomatis via scan', '2025-11-21 09:21:40', '2025-11-21 09:21:43'),
(72, 2, 'MUHAMMAD ZAINI', 'BRIPKA/83071369', 'AK 101 KAL 5,56 mm', '1612.05433', 'rutin', '2025-11-21 16:22:24', '2025-11-21 04:22:46', 'dikembalikan', 'Peminjaman rutin via scan | Dikembalikan otomatis via scan', '2025-11-21 09:22:24', '2025-11-21 09:22:46'),
(73, 62, 'BAGUS OKTAFRIZAL, S.H.', 'BRIGADIR/92100587', 'AK 102 KAL 5.56 mm', '1710.61956', 'rutin', '2025-11-21 17:26:04', '2025-11-22 00:13:00', 'dikembalikan', 'Peminjaman rutin via scan | Dikembalikan: ', '2025-11-21 10:26:04', '2025-11-21 17:13:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_logistik`
--
ALTER TABLE `data_logistik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `data_pemegang_senpi`
--
ALTER TABLE `data_pemegang_senpi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_senpi`
--
ALTER TABLE `jenis_senpi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_jenis` (`nama_jenis`);

--
-- Indexes for table `peminjaman_dinas`
--
ALTER TABLE `peminjaman_dinas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman_dinas_items`
--
ALTER TABLE `peminjaman_dinas_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_peminjaman_dinas` (`id_peminjaman_dinas`);

--
-- Indexes for table `peminjaman_log`
--
ALTER TABLE `peminjaman_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_logistik`
--
ALTER TABLE `data_logistik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `data_pemegang_senpi`
--
ALTER TABLE `data_pemegang_senpi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `jenis_senpi`
--
ALTER TABLE `jenis_senpi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `peminjaman_dinas`
--
ALTER TABLE `peminjaman_dinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `peminjaman_dinas_items`
--
ALTER TABLE `peminjaman_dinas_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `peminjaman_log`
--
ALTER TABLE `peminjaman_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman_dinas_items`
--
ALTER TABLE `peminjaman_dinas_items`
  ADD CONSTRAINT `fk_peminjaman_dinas` FOREIGN KEY (`id_peminjaman_dinas`) REFERENCES `peminjaman_dinas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
