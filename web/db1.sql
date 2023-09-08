-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2021 at 01:18 PM
-- Server version: 5.7.19
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `husni`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_devices` int(11) NOT NULL,
  `id_face_table` int(11) NOT NULL,
  `absensi_masuk` int(11) NOT NULL,
  `suhu_masuk` varchar(50) NOT NULL,
  `keterangan_masuk` varchar(100) NOT NULL,
  `flag_masuk` varchar(100) NOT NULL,
  `absensi_keluar` int(11) NOT NULL,
  `suhu_keluar` varchar(50) NOT NULL,
  `keterangan_keluar` varchar(100) NOT NULL,
  `flag_keluar` varchar(100) NOT NULL,
  `keterlambatan` varchar(100) NOT NULL,
  `pulang_awal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_devices`, `id_face_table`, `absensi_masuk`, `suhu_masuk`, `keterangan_masuk`, `flag_masuk`, `absensi_keluar`, `suhu_keluar`, `keterangan_keluar`, `flag_keluar`, `keterlambatan`, `pulang_awal`) VALUES
(1, 1, 2, 1609418416, '36.15', 'Masuk Terlambat', 'Absensi Face', 1609418551, '36.15', 'Keluar Lebih Awal', 'Absensi Face', '40', '-77'),
(3, 1, 2, 1609757778, '', 'Tidak Masuk', '', 0, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id_devices` int(11) NOT NULL,
  `nama_devices` varchar(100) NOT NULL,
  `mode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id_devices`, `nama_devices`, `mode`) VALUES
(1, 'Raspi 3B', 'SCAN');

-- --------------------------------------------------------

--
-- Table structure for table `face`
--

CREATE TABLE `face` (
  `id_face_table` int(11) NOT NULL,
  `id_devices` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `telp` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `kelas` varchar(200) NOT NULL,
  `face_id` int(11) NOT NULL,
  `del_face_id` tinyint(1) NOT NULL DEFAULT '0',
  `add_face_id` tinyint(1) NOT NULL DEFAULT '0',
  `image_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `face`
--

INSERT INTO `face` (`id_face_table`, `id_devices`, `nama`, `nim`, `gender`, `telp`, `semester`, `kelas`, `face_id`, `del_face_id`, `add_face_id`, `image_name`) VALUES
(2, 1, 'Tyto Mulyono', '', '', '', '', '', 50, 0, 0, 'Tyto Mulyono');

-- --------------------------------------------------------

--
-- Table structure for table `histori`
--

CREATE TABLE `histori` (
  `id_histori` int(11) NOT NULL,
  `id_face_table` int(11) NOT NULL,
  `id_devices` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `waktu` int(11) NOT NULL,
  `flag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `secret_key`
--

CREATE TABLE `secret_key` (
  `id_key` int(11) NOT NULL,
  `key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secret_key`
--

INSERT INTO `secret_key` (`id_key`, `key`) VALUES
(1, 'FaceRec888');

-- --------------------------------------------------------

--
-- Table structure for table `telegram`
--

CREATE TABLE `telegram` (
  `id_telegram` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `chat_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `telegram`
--

INSERT INTO `telegram` (`id_telegram`, `token`, `chat_id`) VALUES
(1, '1474933151:AAF8uN4tAyVWt2NhmpaM7J0EFfNIk7Czbq8', '900448515');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `username`, `password`, `avatar`) VALUES
(3, 'tyto mulyono', 'tytomulyono@gmail.com', 'tyto', '$2a$08$3WyRJUHBqEG.sQ4yYTLxqOAXyqApz5/4AMZ73kauVsah1QfyKe7yC', '19652990215f4dfa6ea372b.png');

-- --------------------------------------------------------

--
-- Table structure for table `waktu_operasional`
--

CREATE TABLE `waktu_operasional` (
  `id_waktu_operasional` int(11) NOT NULL,
  `waktu_operasional` varchar(20) NOT NULL,
  `keterangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waktu_operasional`
--

INSERT INTO `waktu_operasional` (`id_waktu_operasional`, `waktu_operasional`, `keterangan`) VALUES
(1, '08:00-09:00', 'masuk'),
(2, '10:00-10:30', 'keluar'),
(3, '08:30', 'jam masuk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id_devices`);

--
-- Indexes for table `face`
--
ALTER TABLE `face`
  ADD PRIMARY KEY (`id_face_table`);

--
-- Indexes for table `histori`
--
ALTER TABLE `histori`
  ADD PRIMARY KEY (`id_histori`);

--
-- Indexes for table `secret_key`
--
ALTER TABLE `secret_key`
  ADD PRIMARY KEY (`id_key`);

--
-- Indexes for table `telegram`
--
ALTER TABLE `telegram`
  ADD PRIMARY KEY (`id_telegram`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `waktu_operasional`
--
ALTER TABLE `waktu_operasional`
  ADD PRIMARY KEY (`id_waktu_operasional`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id_devices` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `face`
--
ALTER TABLE `face`
  MODIFY `id_face_table` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `histori`
--
ALTER TABLE `histori`
  MODIFY `id_histori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `secret_key`
--
ALTER TABLE `secret_key`
  MODIFY `id_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `telegram`
--
ALTER TABLE `telegram`
  MODIFY `id_telegram` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `waktu_operasional`
--
ALTER TABLE `waktu_operasional`
  MODIFY `id_waktu_operasional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
