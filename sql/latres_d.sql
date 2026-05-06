-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2026 at 06:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `latres_d`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id_asset` int(11) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `url_gambar` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id_asset`, `serial_number`, `nama_alat`, `merk`, `status`, `jumlah`, `url_gambar`, `created_at`) VALUES
(1, 'CAM-SONY-A73-01', 'Sony Alpha a7 III Mirrorless', 'Sony', 'Tersedia', 3, 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=1000&auto=format&fit=crop', '2026-04-04 13:47:31'),
(3, 'DRN-DJI-MAV-05', 'DJI Mavic 3 Classic', 'DJI', 'Maintenance', 1, 'https://images.unsplash.com/photo-1473968512647-3e447244af8f?q=80&w=1000&auto=format&fit=crop', '2026-04-04 13:47:31'),
(9, 'DRN-DJI-MINI3-01', 'DJI Mini 3 Pro', 'DJI', 'Tersedia', 13, 'https://images.unsplash.com/photo-1507582020474-9a35b7d455d9?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8ZHJvbmV8ZW58MHx8MHx8fDA%3D', '2026-05-06 10:59:41'),
(10, 'DRN-DJI-AIR2S-02', 'DJI Air 2S', 'DJI', 'Dipinjam', 1, 'https://images.unsplash.com/photo-1508444845599-5c89863b1c44?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8ZHJvbmV8ZW58MHx8MHx8fDA%3D', '2026-05-06 11:00:19'),
(11, 'LNS-SIG-35MM-02', 'Sigma 35mm f/1.4 Art', 'Sigma', 'Maintenance', 1, 'https://images.unsplash.com/photo-1617122951581-4889ad33fcfc?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8bGVufGVufDB8fDB8fHww', '2026-05-06 11:00:45'),
(12, 'LNS-TAM-70-200-04', 'Tamron 70-200mm f/2.8', 'Tamron', 'Dipinjam', 1, 'https://images.unsplash.com/photo-1453728013993-6d66e9c9123a?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8Y2FtZXJhJTIwbGVuc3xlbnwwfHwwfHx8MA%3D%3D', '2026-05-06 11:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `created_at`) VALUES
(3, 'candra', '$2y$10$CmzznLp91UaKx9N77EQqpewnSPZWp9hRCUrpxMpm3XUo.rTpX6m.S', '2026-05-06 10:54:01'),
(4, 'eitty', '$2y$10$m1l/iN54lrTRjSBUhtHhz.7dHCUQ2fdp4/UT4yMJR/Dul4SoGd31q', '2026-05-06 11:22:10'),
(5, 'agustine', '$2y$10$KwXaidxxct5RDtp8rX4SguMk6H5Hp8ue7bWFA802Jm0Aydz8adPMe', '2026-05-06 11:38:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id_asset`),
  ADD UNIQUE KEY `serial_number` (`serial_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id_asset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
