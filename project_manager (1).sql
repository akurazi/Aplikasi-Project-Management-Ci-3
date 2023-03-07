-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Feb 2023 pada 08.34
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_manager`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aplikasi`
--

CREATE TABLE `aplikasi` (
  `id_aplikasi` int(6) NOT NULL,
  `nama_aplikasi` varchar(255) NOT NULL,
  `id_project` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `aplikasi`
--

INSERT INTO `aplikasi` (`id_aplikasi`, `nama_aplikasi`, `id_project`) VALUES
(1, 'Aplikasi Green School', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `base_aplikasi`
--

CREATE TABLE `base_aplikasi` (
  `id_bAplikasi` int(6) NOT NULL,
  `nama_aplikasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `base_aplikasi`
--

INSERT INTO `base_aplikasi` (`id_bAplikasi`, `nama_aplikasi`) VALUES
(1, 'Aplikasi Green School'),
(2, 'Aplikasi SIP');

-- --------------------------------------------------------

--
-- Struktur dari tabel `base_kontrak`
--

CREATE TABLE `base_kontrak` (
  `id_bKontrak` int(11) NOT NULL,
  `lama` varchar(10) NOT NULL,
  `satuan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `base_kontrak`
--

INSERT INTO `base_kontrak` (`id_bKontrak`, `lama`, `satuan`) VALUES
(1, '1', 'Tahun'),
(2, '2', 'Tahun'),
(3, 'Beli Putus', ''),
(4, '3', 'Bulan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `base_status`
--

CREATE TABLE `base_status` (
  `id_status` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `base_status`
--

INSERT INTO `base_status` (`id_status`, `nama`) VALUES
(1, 'Kontrak'),
(2, 'Requirement'),
(3, 'Design'),
(4, 'Implementasi'),
(5, 'Testing & Integrasi'),
(6, 'BAST');

-- --------------------------------------------------------

--
-- Struktur dari tabel `base_submodul`
--

CREATE TABLE `base_submodul` (
  `id_bSub` int(5) NOT NULL,
  `nama_sub` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `base_submodul`
--

INSERT INTO `base_submodul` (`id_bSub`, `nama_sub`) VALUES
(1, 'Menu Input'),
(2, 'Menu Delete'),
(3, 'Menu Login'),
(4, 'Menu Logout'),
(6, 'Menu Check');

-- --------------------------------------------------------

--
-- Struktur dari tabel `durasi`
--

CREATE TABLE `durasi` (
  `id_durasi` int(6) NOT NULL,
  `durasi` varchar(10) NOT NULL,
  `id_x_aplikasi` int(6) NOT NULL,
  `mulai` date NOT NULL,
  `selesai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `durasi`
--

INSERT INTO `durasi` (`id_durasi`, `durasi`, `id_x_aplikasi`, `mulai`, `selesai`) VALUES
(1, '3', 1, '2023-02-14', '2023-02-17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `history`
--

CREATE TABLE `history` (
  `id` int(6) NOT NULL,
  `history` varchar(255) NOT NULL,
  `id_sub` int(6) NOT NULL,
  `id_user` int(6) NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_project`
--

CREATE TABLE `history_project` (
  `id` int(6) NOT NULL,
  `history` varchar(255) NOT NULL,
  `id_project` int(6) NOT NULL,
  `id_user` int(6) NOT NULL,
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `history_project`
--

INSERT INTO `history_project` (`id`, `history`, `id_project`, `id_user`, `update_at`) VALUES
(1, 'Mengubah Status', 1, 1, '2023-02-14 14:08:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontrak`
--

CREATE TABLE `kontrak` (
  `id_kontrak` int(6) NOT NULL,
  `nama_kontrak` varchar(255) NOT NULL,
  `mulai` date DEFAULT NULL,
  `selesai` date DEFAULT NULL,
  `id_project` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `level_user`
--

CREATE TABLE `level_user` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `level_user`
--

INSERT INTO `level_user` (`id_level`, `nama_level`) VALUES
(1, 'super admin'),
(2, 'penjab'),
(3, 'pic'),
(4, 'programmer'),
(5, 'sales');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(6) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `is_main` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `link`, `icon`, `is_main`) VALUES
(1, 'Dashboard', 'Dashboard', 'fa fa-tachometer-alt', 0),
(2, 'Project Management', 'Project', 'fa fa-th', 0),
(3, 'Master Data', 'Aplikasi', 'fa fa-database', 0),
(4, 'Project', 'listproject', 'far fa-circle', 2),
(5, 'Modul', 'listmodul', 'far fa-circle', 2),
(6, 'Sub Modul', 'listsubmodul', 'far fa-circle', 2),
(7, 'Pelaksana', 'Pelaksana', 'fa fa-users', 0),
(8, 'Kontrak', 'listkontrak', 'far fa-circle', 2),
(9, 'Pelaksana', 'listpelaksana', 'far fa-circle', 2),
(10, 'Pelaksana Modul', 'listpelaksanamodul', 'far fa-circle', 2),
(11, 'Durasi Pengerjaan', 'listdurasi', 'far fa-circle', 2),
(12, 'Produk', 'listproduk', 'far fa-circle', 3),
(13, 'Modul', 'listmodul', 'far fa-circle', 3),
(14, 'Sub Modul', 'listsubmodul', 'far fa-circle', 3),
(15, 'Penanggung Jawab', 'list/penjab', 'far fa-circle', 7),
(16, 'PIC', 'list/pic', 'far fa-circle', 7),
(17, 'Programmer', 'list/programmer', 'far fa-circle', 7),
(18, 'Job Desk', 'jobdesk', 'fa fa-tasks', 0),
(19, 'Setting', 'setting', 'fa fa-cog', 0),
(20, 'Menu', 'menu', 'far fa-circle', 19),
(21, 'Sub Menu', 'submenu', 'far fa-circle', 19),
(22, 'Hak Akses', 'rule', 'far fa-circle', 19),
(23, 'Laporan', 'laporan', 'fa fa-print', 0),
(24, 'Laporan Project', 'lapproject', 'far fa-circle', 23),
(25, 'Laporan Kinerja', 'lapkin', 'far fa-circle', 23),
(26, 'Laporan Bug', 'lapbug', 'far fa-circle', 23),
(27, 'Ganti Password', 'gantipassword', 'far fa-circle', 19);

-- --------------------------------------------------------

--
-- Struktur dari tabel `modul`
--

CREATE TABLE `modul` (
  `id_modul` int(6) NOT NULL,
  `nama_modul` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `modul`
--

INSERT INTO `modul` (`id_modul`, `nama_modul`) VALUES
(7, 'Personalia'),
(8, 'Purchase'),
(9, 'Warehouse'),
(10, 'Estate'),
(11, 'Mill'),
(12, 'Trading'),
(13, 'Budget'),
(14, 'Finance');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelaksana`
--

CREATE TABLE `pelaksana` (
  `id_pelaksana` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelaksana`
--

INSERT INTO `pelaksana` (`id_pelaksana`, `nama`, `jabatan`) VALUES
(1, 'Jono', 'programmer'),
(2, 'Junia', 'Pic'),
(3, 'Juni', 'penjab'),
(4, 'Juli', 'penjab'),
(5, 'kembali', 'PIC'),
(7, 'indra', 'programmer'),
(8, 'Jope', 'PIC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `project`
--

CREATE TABLE `project` (
  `id` int(6) NOT NULL,
  `nama_project` varchar(250) NOT NULL,
  `jenis_project` varchar(150) NOT NULL,
  `marketing` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `project`
--

INSERT INTO `project` (`id`, `nama_project`, `jenis_project`, `marketing`, `status`, `keterangan`, `created`) VALUES
(1, 'testing', 'perkebunan', 'Arief', 2, '', '2023-02-14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_modul`
--

CREATE TABLE `sub_modul` (
  `id_sub` int(6) NOT NULL,
  `id_bSub` int(11) NOT NULL,
  `nama_sub` varchar(255) NOT NULL,
  `id_x_aplikasi` int(6) NOT NULL,
  `status` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sub_modul`
--

INSERT INTO `sub_modul` (`id_sub`, `id_bSub`, `nama_sub`, `id_x_aplikasi`, `status`, `keterangan`, `updated_at`) VALUES
(1, 3, 'Menu Login', 1, 0, '', NULL),
(2, 2, 'Menu Delete', 2, 0, '', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(6) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nama`, `status`) VALUES
(1, 'indra@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'indra', 1),
(2, 'arief@durioindigo.co.id', '5f4dcc3b5aa765d61d8327deb882cf99', 'Arief Adi Chandra', 2),
(5, 'egi@durioindigo.co.id', 'e10adc3949ba59abbe56e057f20f883e', 'Egi Zilvananda', 4),
(6, 'tiwi@durioindigo.co.id', '5f4dcc3b5aa765d61d8327deb882cf99', 'Azhari Pratiwi', 4),
(7, 'sofyan@durioindigo.co.id', '5f4dcc3b5aa765d61d8327deb882cf99', 'Sofyan Pariyasto', 3),
(8, 'rizal@durioindigo.co.id', '5f4dcc3b5aa765d61d8327deb882cf99', 'Asvarizal Filcha', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `x_aplikasi`
--

CREATE TABLE `x_aplikasi` (
  `id_x_aplikasi` int(6) NOT NULL,
  `id_modul` int(6) NOT NULL,
  `nama_modul` varchar(255) NOT NULL,
  `id_aplikasi` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `x_aplikasi`
--

INSERT INTO `x_aplikasi` (`id_x_aplikasi`, `id_modul`, `nama_modul`, `id_aplikasi`) VALUES
(1, 2, 'Modul Check', 1),
(2, 3, 'Modul Checkout', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `x_kontrak`
--

CREATE TABLE `x_kontrak` (
  `id_x_kontrak` int(5) NOT NULL,
  `id_kontrak` int(5) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `jenis_dokumen` varchar(255) NOT NULL,
  `id_project` int(5) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `x_pelaksana`
--

CREATE TABLE `x_pelaksana` (
  `id_x_pelaksana` int(6) NOT NULL,
  `id_pelaksana` int(6) NOT NULL,
  `id_project` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `x_pelaksana`
--

INSERT INTO `x_pelaksana` (`id_x_pelaksana`, `id_pelaksana`, `id_project`) VALUES
(1, 5, 1),
(2, 0, 1),
(3, 6, 1),
(4, 7, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `x_pelmodul`
--

CREATE TABLE `x_pelmodul` (
  `id_xPel` int(6) NOT NULL,
  `id_x_aplikasi` int(6) NOT NULL,
  `id_pelaksana` int(6) NOT NULL,
  `nama_pelaksana` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `x_pelmodul`
--

INSERT INTO `x_pelmodul` (`id_xPel`, `id_x_aplikasi`, `id_pelaksana`, `nama_pelaksana`) VALUES
(1, 1, 5, 'Egi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `x_rule`
--

CREATE TABLE `x_rule` (
  `id_xrule` int(5) NOT NULL,
  `id_menu` int(5) NOT NULL,
  `id_level` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `x_rule`
--

INSERT INTO `x_rule` (`id_xrule`, `id_menu`, `id_level`) VALUES
(1, 1, 1),
(2, 4, 1),
(3, 5, 1),
(4, 6, 1),
(5, 8, 1),
(6, 9, 1),
(7, 10, 1),
(8, 11, 1),
(9, 2, 1),
(10, 12, 1),
(11, 13, 1),
(12, 14, 1),
(13, 3, 1),
(14, 15, 1),
(15, 16, 1),
(16, 17, 1),
(17, 7, 1),
(18, 20, 1),
(19, 21, 1),
(20, 22, 1),
(21, 19, 1),
(22, 24, 1),
(23, 25, 1),
(24, 26, 1),
(25, 23, 1),
(26, 1, 4),
(27, 18, 4),
(28, 1, 3),
(29, 4, 3),
(30, 5, 3),
(31, 6, 3),
(32, 8, 3),
(33, 9, 3),
(34, 10, 3),
(35, 11, 3),
(36, 2, 3),
(40, 27, 2),
(41, 19, 2),
(45, 27, 3),
(46, 19, 3),
(50, 27, 4),
(51, 19, 4),
(57, 27, 5),
(58, 19, 5);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD PRIMARY KEY (`id_aplikasi`);

--
-- Indeks untuk tabel `base_aplikasi`
--
ALTER TABLE `base_aplikasi`
  ADD PRIMARY KEY (`id_bAplikasi`);

--
-- Indeks untuk tabel `base_kontrak`
--
ALTER TABLE `base_kontrak`
  ADD PRIMARY KEY (`id_bKontrak`);

--
-- Indeks untuk tabel `base_status`
--
ALTER TABLE `base_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `base_submodul`
--
ALTER TABLE `base_submodul`
  ADD PRIMARY KEY (`id_bSub`);

--
-- Indeks untuk tabel `durasi`
--
ALTER TABLE `durasi`
  ADD PRIMARY KEY (`id_durasi`);

--
-- Indeks untuk tabel `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `history_project`
--
ALTER TABLE `history_project`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kontrak`
--
ALTER TABLE `kontrak`
  ADD PRIMARY KEY (`id_kontrak`);

--
-- Indeks untuk tabel `level_user`
--
ALTER TABLE `level_user`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id_modul`);

--
-- Indeks untuk tabel `pelaksana`
--
ALTER TABLE `pelaksana`
  ADD PRIMARY KEY (`id_pelaksana`);

--
-- Indeks untuk tabel `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sub_modul`
--
ALTER TABLE `sub_modul`
  ADD PRIMARY KEY (`id_sub`),
  ADD KEY `id_x_aplikasi` (`id_x_aplikasi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `x_aplikasi`
--
ALTER TABLE `x_aplikasi`
  ADD PRIMARY KEY (`id_x_aplikasi`);

--
-- Indeks untuk tabel `x_kontrak`
--
ALTER TABLE `x_kontrak`
  ADD PRIMARY KEY (`id_x_kontrak`);

--
-- Indeks untuk tabel `x_pelaksana`
--
ALTER TABLE `x_pelaksana`
  ADD PRIMARY KEY (`id_x_pelaksana`);

--
-- Indeks untuk tabel `x_pelmodul`
--
ALTER TABLE `x_pelmodul`
  ADD PRIMARY KEY (`id_xPel`),
  ADD KEY `id_x_aplikasi` (`id_x_aplikasi`),
  ADD KEY `id_pelaksana` (`id_pelaksana`);

--
-- Indeks untuk tabel `x_rule`
--
ALTER TABLE `x_rule`
  ADD PRIMARY KEY (`id_xrule`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aplikasi`
--
ALTER TABLE `aplikasi`
  MODIFY `id_aplikasi` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `base_aplikasi`
--
ALTER TABLE `base_aplikasi`
  MODIFY `id_bAplikasi` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `base_kontrak`
--
ALTER TABLE `base_kontrak`
  MODIFY `id_bKontrak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `base_status`
--
ALTER TABLE `base_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `base_submodul`
--
ALTER TABLE `base_submodul`
  MODIFY `id_bSub` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `durasi`
--
ALTER TABLE `durasi`
  MODIFY `id_durasi` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `history`
--
ALTER TABLE `history`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `history_project`
--
ALTER TABLE `history_project`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kontrak`
--
ALTER TABLE `kontrak`
  MODIFY `id_kontrak` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `level_user`
--
ALTER TABLE `level_user`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `modul`
--
ALTER TABLE `modul`
  MODIFY `id_modul` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `pelaksana`
--
ALTER TABLE `pelaksana`
  MODIFY `id_pelaksana` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `project`
--
ALTER TABLE `project`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `sub_modul`
--
ALTER TABLE `sub_modul`
  MODIFY `id_sub` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `x_aplikasi`
--
ALTER TABLE `x_aplikasi`
  MODIFY `id_x_aplikasi` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `x_kontrak`
--
ALTER TABLE `x_kontrak`
  MODIFY `id_x_kontrak` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `x_pelaksana`
--
ALTER TABLE `x_pelaksana`
  MODIFY `id_x_pelaksana` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `x_pelmodul`
--
ALTER TABLE `x_pelmodul`
  MODIFY `id_xPel` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `x_rule`
--
ALTER TABLE `x_rule`
  MODIFY `id_xrule` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `sub_modul`
--
ALTER TABLE `sub_modul`
  ADD CONSTRAINT `sub_modul_ibfk_1` FOREIGN KEY (`id_x_aplikasi`) REFERENCES `x_aplikasi` (`id_x_aplikasi`);

--
-- Ketidakleluasaan untuk tabel `x_pelmodul`
--
ALTER TABLE `x_pelmodul`
  ADD CONSTRAINT `x_pelmodul_ibfk_1` FOREIGN KEY (`id_x_aplikasi`) REFERENCES `x_aplikasi` (`id_x_aplikasi`),
  ADD CONSTRAINT `x_pelmodul_ibfk_2` FOREIGN KEY (`id_pelaksana`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
