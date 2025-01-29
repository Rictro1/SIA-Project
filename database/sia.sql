-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2025 at 01:30 PM
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
-- Database: `sia`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `absensi_id` int(11) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `matkul_name` varchar(100) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `dosen_name` varchar(100) NOT NULL,
  `pertemuan` int(11) NOT NULL,
  `status` enum('Hadir','Alpha','Izin','Sakit') NOT NULL,
  `total_absen` int(11) DEFAULT 0,
  `nilai` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`absensi_id`, `mhs_id`, `mhs_name`, `matkul_id`, `matkul_name`, `dosen_id`, `dosen_name`, `pertemuan`, `status`, `total_absen`, `nilai`) VALUES
(4, 23451024, 'Eric Yedija Sinaga', 3256601, 'Jarkom', 1102001, 'Husnul Khair. M.Kom', 1, 'Hadir', 1, 70.00),
(5, 23451024, 'Eric Yedija Sinaga', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 2, 'Hadir', 2, 70.00),
(6, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 2, 'Hadir', 1, 0.00),
(7, 23451024, 'Eric Yedija Sinaga', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 3, 'Hadir', 3, 70.00),
(8, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 3, 'Hadir', 2, 0.00),
(9, 23451024, 'Eric Yedija Sinaga', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 4, 'Hadir', 4, 70.00),
(10, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 4, 'Hadir', 3, 0.00),
(11, 23451024, 'Eric Yedija Sinaga', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 5, 'Hadir', 5, 70.00),
(12, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 5, 'Hadir', 4, 0.00),
(13, 23451024, 'Eric Yedija Sinaga', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 6, 'Alpha', 5, 70.00),
(14, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 6, 'Hadir', 5, 0.00),
(15, 23451024, 'Eric Yedija Sinaga', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 7, 'Izin', 5, 70.00),
(16, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 7, 'Hadir', 6, 0.00),
(17, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 8, 'Hadir', 6, 70.00),
(18, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 8, 'Hadir', 7, 0.00),
(19, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 9, 'Hadir', 7, 70.00),
(20, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 9, 'Hadir', 8, 0.00),
(21, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 10, 'Hadir', 8, 70.00),
(22, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 10, 'Hadir', 9, 0.00),
(23, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 11, 'Hadir', 9, 70.00),
(24, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 11, 'Hadir', 10, 0.00),
(25, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 12, 'Hadir', 10, 70.00),
(26, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 12, 'Hadir', 11, 0.00),
(27, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 13, 'Hadir', 11, 70.00),
(28, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 13, 'Hadir', 12, 80.00),
(29, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 14, 'Hadir', 12, 70.00),
(30, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 14, 'Hadir', 13, 80.00),
(31, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 15, 'Hadir', 13, 70.00),
(32, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 15, 'Hadir', 14, 90.00),
(35, 23451028, 'Diki Simbolon', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 16, 'Hadir', 1, 0.00),
(36, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 16, 'Hadir', 14, 90.00),
(37, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 16, 'Hadir', 15, 90.00);

-- --------------------------------------------------------

--
-- Table structure for table `angket_dosen`
--

CREATE TABLE `angket_dosen` (
  `angket_id` int(11) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `dosen_name` varchar(100) NOT NULL,
  `aspek1` varchar(5) NOT NULL,
  `aspek2` varchar(5) NOT NULL,
  `aspek3` varchar(5) NOT NULL,
  `aspek4` varchar(5) NOT NULL,
  `aspek5` varchar(5) NOT NULL,
  `aspek6` varchar(5) NOT NULL,
  `aspek7` varchar(5) NOT NULL,
  `aspek8` varchar(5) NOT NULL,
  `aspek9` varchar(5) NOT NULL,
  `aspek10` varchar(5) NOT NULL,
  `aspek11` varchar(5) NOT NULL,
  `aspek12` varchar(5) NOT NULL,
  `saran` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `angket_dosen`
--

INSERT INTO `angket_dosen` (`angket_id`, `mhs_id`, `mhs_name`, `dosen_id`, `dosen_name`, `aspek1`, `aspek2`, `aspek3`, `aspek4`, `aspek5`, `aspek6`, `aspek7`, `aspek8`, `aspek9`, `aspek10`, `aspek11`, `aspek12`, `saran`) VALUES
(25, 23451024, 'Eric', 1102001, 'Husnul Khair. M.Kom', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'etw');

-- --------------------------------------------------------

--
-- Table structure for table `angket_institusi`
--

CREATE TABLE `angket_institusi` (
  `angket_id` int(11) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `aspek1` enum('SK','K','C','B','SB') NOT NULL,
  `aspek2` enum('SK','K','C','B','SB') NOT NULL,
  `aspek3` enum('SK','K','C','B','SB') NOT NULL,
  `aspek4` enum('SK','K','C','B','SB') NOT NULL,
  `aspek5` enum('SK','K','C','B','SB') NOT NULL,
  `aspek6` enum('SK','K','C','B','SB') NOT NULL,
  `aspek7` enum('SK','K','C','B','SB') NOT NULL,
  `aspek8` enum('SK','K','C','B','SB') NOT NULL,
  `aspek9` enum('SK','K','C','B','SB') NOT NULL,
  `aspek10` enum('SK','K','C','B','SB') NOT NULL,
  `aspek11` enum('SK','K','C','B','SB') NOT NULL,
  `aspek12` enum('SK','K','C','B','SB') NOT NULL,
  `aspek13` enum('SK','K','C','B','SB') NOT NULL,
  `aspek14` enum('SK','K','C','B','SB') NOT NULL,
  `aspek15` enum('SK','K','C','B','SB') NOT NULL,
  `aspek16` enum('SK','K','C','B','SB') NOT NULL,
  `aspek17` enum('SK','K','C','B','SB') NOT NULL,
  `saran` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `angket_institusi`
--

INSERT INTO `angket_institusi` (`angket_id`, `mhs_id`, `mhs_name`, `aspek1`, `aspek2`, `aspek3`, `aspek4`, `aspek5`, `aspek6`, `aspek7`, `aspek8`, `aspek9`, `aspek10`, `aspek11`, `aspek12`, `aspek13`, `aspek14`, `aspek15`, `aspek16`, `aspek17`, `saran`) VALUES
(1, 23451024, 'Eric', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'SK', 'dagsf');

-- --------------------------------------------------------

--
-- Table structure for table `data_admin`
--

CREATE TABLE `data_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_tgl_lahir` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_admin`
--

INSERT INTO `data_admin` (`admin_id`, `admin_name`, `jenis_kelamin`, `tempat_tgl_lahir`, `alamat`, `no_hp`, `email`, `password`) VALUES
(92701, 'Jack Reaper', 'Laki-laki', 'Medan/1999-02-19', 'Binjai', '0689568', 'jack@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `data_dosen`
--

CREATE TABLE `data_dosen` (
  `dosen_id` int(11) NOT NULL,
  `dosen_name` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `tempat_tgl_lahir` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_dosen`
--

INSERT INTO `data_dosen` (`dosen_id`, `dosen_name`, `jenis_kelamin`, `tempat_tgl_lahir`, `alamat`, `no_hp`, `email`, `password`) VALUES
(1102001, 'Husnul Khair. M.Kom', 'Laki-Laki', 'test', 'Binjai', '08124124', 'test@gmail.com', 'dosen'),
(1102002, 'Bendra Wardana, M.Kom', 'Laki-Laki', 'Binjai/1995-02-12', 'Binjai', '081242146', 'dosen@gmail.com', 'dosen321'),
(1102003, 'Marto Sihombing, M.Kom', 'Laki-Laki', 'Stabat/1993-11-29', 'Medan', '06786847', 'test2@gmail.com', 'dsn123'),
(1102004, 'Magdalena Simanjuntak, S.Kom, M.Kom', 'Perempuan', 'Stabat/1993-04-19', 'Medan', '063251', 'test3@gmail.com', 'dosen13'),
(1102005, 'Anton Sihombing, SE, MM', 'Laki-Laki', 'Jakarta/1987-12-24', 'Binjai', '085634624', 'test4@gmail.com', 'dosen64'),
(1102006, 'Ratih Puspadini, S.T, M.Kom', 'Perempuan', 'Medan/1989-01-19', 'Medan', '08235325', 'test9@gmail.com', 'dosen99');

-- --------------------------------------------------------

--
-- Table structure for table `data_mhs`
--

CREATE TABLE `data_mhs` (
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_tgl_lahir` varchar(150) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `program_studi` enum('Teknik Informatika','Sistem Informasi','Manajemen Informatika','Bisnis Digital','Komputerisasi Akuntansi') NOT NULL,
  `semester` int(11) NOT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_mhs`
--

INSERT INTO `data_mhs` (`mhs_id`, `mhs_name`, `jenis_kelamin`, `tempat_tgl_lahir`, `alamat`, `nama_ayah`, `nama_ibu`, `no_hp`, `email`, `program_studi`, `semester`, `kelas`, `password`) VALUES
(23451024, 'Eric', 'Laki-laki', 'test', 'binjai', 'efendi', 'Berliana', '08124124', 'ericanjay@gmail.com', 'Teknik Informatika', 3, 'TI A', 'eric321'),
(23451026, 'Fakhri Khuzaini', 'Laki-laki', 'Binjai/2005-04-05', 'Binjai', 'Example', 'Example', '082142512', 'fakhri@gmail.com', 'Sistem Informasi', 3, 'TI A', 'fakhri123'),
(23451028, 'Diki Simbolon', 'Laki-laki', 'Medan/2003-03-12', 'Binjai', 'test', 'test', '085334724', 'diki@gmail.com', 'Teknik Informatika', 3, 'TI A', 'diki123');

-- --------------------------------------------------------

--
-- Table structure for table `khs`
--

CREATE TABLE `khs` (
  `khs_id` int(11) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `matkul_name` varchar(100) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `dosen_name` varchar(100) NOT NULL,
  `total_absen` int(11) DEFAULT 0,
  `tugas_quiz` decimal(5,2) NOT NULL,
  `uts` decimal(5,2) NOT NULL,
  `uas` decimal(5,2) NOT NULL,
  `simbol` char(1) NOT NULL,
  `total` decimal(5,2) GENERATED ALWAYS AS (`total_absen` * 10 / 100 + `tugas_quiz` * 20 / 100 + `uts` * 30 / 100 + `uas` * 40 / 100) STORED,
  `indeks` char(1) GENERATED ALWAYS AS (case when `total` >= 85 then 'A' when `total` >= 70 then 'B' when `total` >= 55 then 'C' when `total` >= 40 then 'D' else 'E' end) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khs`
--

INSERT INTO `khs` (`khs_id`, `mhs_id`, `mhs_name`, `matkul_id`, `matkul_name`, `dosen_id`, `dosen_name`, `total_absen`, `tugas_quiz`, `uts`, `uas`, `simbol`) VALUES
(12, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 90, 90.00, 85.00, 85.00, ''),
(13, 23451026, 'Fakhri Khuzaini', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 0, 90.00, 80.00, 85.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `kritik_saran`
--

CREATE TABLE `kritik_saran` (
  `kritik_saran_id` int(11) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `kritik_saran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kritik_saran`
--

INSERT INTO `kritik_saran` (`kritik_saran_id`, `mhs_id`, `mhs_name`, `kritik_saran`) VALUES
(1, 23451024, 'Eric', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `matkul_list`
--

CREATE TABLE `matkul_list` (
  `matkul_id` int(11) NOT NULL,
  `matkul_name` varchar(100) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `dosen_name` varchar(100) NOT NULL,
  `sks` int(11) NOT NULL CHECK (`sks` > 0),
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat') NOT NULL,
  `pukul` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matkul_list`
--

INSERT INTO `matkul_list` (`matkul_id`, `matkul_name`, `dosen_id`, `dosen_name`, `sks`, `hari`, `pukul`) VALUES
(3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 3, 'Senin', '08:00:00'),
(3256602, 'Pemrograman Web', 1102002, 'Bendra Wardana, M.Kom', 3, 'Jumat', '08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mhs_matkul`
--

CREATE TABLE `mhs_matkul` (
  `id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `matkul_name` varchar(100) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `dosen_name` varchar(100) NOT NULL,
  `sks` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `pukul` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mhs_matkul`
--

INSERT INTO `mhs_matkul` (`id`, `matkul_id`, `matkul_name`, `mhs_id`, `mhs_name`, `dosen_id`, `dosen_name`, `sks`, `hari`, `pukul`) VALUES
(1, 3256601, 'Jaringan Komputer', 23451024, 'Eric Yedija Sinaga', 1102001, 'Husnul Khair. M.Kom', 3, 'Senin', '08:00:00'),
(2, 3256601, 'Jaringan Komputer', 23451026, 'Fakhri Khuzaini', 1102001, 'Husnul Khair. M.Kom', 3, 'Senin', '08:00:00'),
(3, 3256602, 'Pemrograman Web', 23451024, 'Eric Yedija Sinaga', 1102002, 'Bendra Wardana, M.Kom', 3, 'Jumat', '08:00:00'),
(6, 3256601, 'Jaringan Komputer', 23451028, 'Diki Simbolon', 1102001, 'Husnul Khair. M.Kom', 3, 'Senin', '08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `projek_akhir`
--

CREATE TABLE `projek_akhir` (
  `projek_id` int(11) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projek_akhir`
--

INSERT INTO `projek_akhir` (`projek_id`, `mhs_id`, `mhs_name`, `judul`, `tanggal`) VALUES
(6, 23451024, 'Eric', 'test', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `ujian_perbaiki`
--

CREATE TABLE `ujian_perbaiki` (
  `ujian_id` int(11) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `matkul_name` varchar(100) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `dosen_name` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `ruang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ujian_perbaiki`
--

INSERT INTO `ujian_perbaiki` (`ujian_id`, `mhs_id`, `mhs_name`, `matkul_id`, `matkul_name`, `dosen_id`, `dosen_name`, `tanggal`, `jam`, `ruang`) VALUES
(17, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', '2025-01-03', '00:15:00', '201');

-- --------------------------------------------------------

--
-- Table structure for table `ujian_susulan`
--

CREATE TABLE `ujian_susulan` (
  `ujian_id` int(11) NOT NULL,
  `mhs_id` int(11) NOT NULL,
  `mhs_name` varchar(100) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `matkul_name` varchar(100) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `dosen_name` varchar(100) NOT NULL,
  `jenis_ujian` enum('UTS','UAS') NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `ruang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ujian_susulan`
--

INSERT INTO `ujian_susulan` (`ujian_id`, `mhs_id`, `mhs_name`, `matkul_id`, `matkul_name`, `dosen_id`, `dosen_name`, `jenis_ujian`, `tanggal`, `jam`, `ruang`) VALUES
(1, 23451024, 'Eric', 3256601, 'Jaringan Komputer', 1102001, 'Husnul Khair. M.Kom', 'UTS', '2025-01-17', '01:52:00', '201');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`absensi_id`),
  ADD KEY `mhs_id` (`mhs_id`),
  ADD KEY `dosen_id` (`dosen_id`);

--
-- Indexes for table `angket_dosen`
--
ALTER TABLE `angket_dosen`
  ADD PRIMARY KEY (`angket_id`),
  ADD KEY `angket_dosen_ibfk_1` (`mhs_id`),
  ADD KEY `angket_dosen_ibfk_3` (`dosen_id`);

--
-- Indexes for table `angket_institusi`
--
ALTER TABLE `angket_institusi`
  ADD PRIMARY KEY (`angket_id`),
  ADD KEY `mhs_id` (`mhs_id`);

--
-- Indexes for table `data_admin`
--
ALTER TABLE `data_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `data_dosen`
--
ALTER TABLE `data_dosen`
  ADD PRIMARY KEY (`dosen_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `data_mhs`
--
ALTER TABLE `data_mhs`
  ADD PRIMARY KEY (`mhs_id`),
  ADD UNIQUE KEY `no_hp` (`no_hp`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `khs`
--
ALTER TABLE `khs`
  ADD PRIMARY KEY (`khs_id`),
  ADD KEY `khs_ibfk_3` (`dosen_id`),
  ADD KEY `khs_ibfk_1` (`mhs_id`),
  ADD KEY `khs_ibfk_2` (`matkul_id`);

--
-- Indexes for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  ADD PRIMARY KEY (`kritik_saran_id`),
  ADD KEY `mhs_id` (`mhs_id`);

--
-- Indexes for table `matkul_list`
--
ALTER TABLE `matkul_list`
  ADD PRIMARY KEY (`matkul_id`),
  ADD KEY `matkul_list_ibfk_1` (`dosen_id`);

--
-- Indexes for table `mhs_matkul`
--
ALTER TABLE `mhs_matkul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mhs_id` (`mhs_id`),
  ADD KEY `mhs_matkul_ibfk_3` (`matkul_id`),
  ADD KEY `mhs_matkul_ibfk_2` (`dosen_id`);

--
-- Indexes for table `projek_akhir`
--
ALTER TABLE `projek_akhir`
  ADD PRIMARY KEY (`projek_id`),
  ADD KEY `mhs_id` (`mhs_id`);

--
-- Indexes for table `ujian_perbaiki`
--
ALTER TABLE `ujian_perbaiki`
  ADD PRIMARY KEY (`ujian_id`),
  ADD KEY `mhs_id` (`mhs_id`),
  ADD KEY `dosen_id` (`dosen_id`),
  ADD KEY `ujian_perbaiki_ibfk_2` (`matkul_id`);

--
-- Indexes for table `ujian_susulan`
--
ALTER TABLE `ujian_susulan`
  ADD PRIMARY KEY (`ujian_id`),
  ADD KEY `mhs_id` (`mhs_id`),
  ADD KEY `dosen_id` (`dosen_id`),
  ADD KEY `ujian_susulan_ibfk_2` (`matkul_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `absensi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `angket_dosen`
--
ALTER TABLE `angket_dosen`
  MODIFY `angket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `angket_institusi`
--
ALTER TABLE `angket_institusi`
  MODIFY `angket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `khs`
--
ALTER TABLE `khs`
  MODIFY `khs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  MODIFY `kritik_saran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `matkul_list`
--
ALTER TABLE `matkul_list`
  MODIFY `matkul_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3256611;

--
-- AUTO_INCREMENT for table `mhs_matkul`
--
ALTER TABLE `mhs_matkul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `projek_akhir`
--
ALTER TABLE `projek_akhir`
  MODIFY `projek_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ujian_perbaiki`
--
ALTER TABLE `ujian_perbaiki`
  MODIFY `ujian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ujian_susulan`
--
ALTER TABLE `ujian_susulan`
  MODIFY `ujian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `data_mhs` (`mhs_id`),
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`dosen_id`) REFERENCES `data_dosen` (`dosen_id`);

--
-- Constraints for table `angket_dosen`
--
ALTER TABLE `angket_dosen`
  ADD CONSTRAINT `angket_dosen_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `data_mhs` (`mhs_id`),
  ADD CONSTRAINT `angket_dosen_ibfk_3` FOREIGN KEY (`dosen_id`) REFERENCES `data_dosen` (`dosen_id`);

--
-- Constraints for table `angket_institusi`
--
ALTER TABLE `angket_institusi`
  ADD CONSTRAINT `angket_institusi_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `data_mhs` (`mhs_id`);

--
-- Constraints for table `khs`
--
ALTER TABLE `khs`
  ADD CONSTRAINT `khs_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `data_mhs` (`mhs_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `khs_ibfk_2` FOREIGN KEY (`matkul_id`) REFERENCES `mhs_matkul` (`matkul_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `khs_ibfk_3` FOREIGN KEY (`dosen_id`) REFERENCES `data_dosen` (`dosen_id`);

--
-- Constraints for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  ADD CONSTRAINT `kritik_saran_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `data_mhs` (`mhs_id`);

--
-- Constraints for table `matkul_list`
--
ALTER TABLE `matkul_list`
  ADD CONSTRAINT `matkul_list_ibfk_1` FOREIGN KEY (`dosen_id`) REFERENCES `data_dosen` (`dosen_id`) ON UPDATE CASCADE;

--
-- Constraints for table `mhs_matkul`
--
ALTER TABLE `mhs_matkul`
  ADD CONSTRAINT `mhs_matkul_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `data_mhs` (`mhs_id`),
  ADD CONSTRAINT `mhs_matkul_ibfk_2` FOREIGN KEY (`dosen_id`) REFERENCES `data_dosen` (`dosen_id`),
  ADD CONSTRAINT `mhs_matkul_ibfk_3` FOREIGN KEY (`matkul_id`) REFERENCES `matkul_list` (`matkul_id`) ON UPDATE CASCADE;

--
-- Constraints for table `projek_akhir`
--
ALTER TABLE `projek_akhir`
  ADD CONSTRAINT `projek_akhir_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `data_mhs` (`mhs_id`);

--
-- Constraints for table `ujian_perbaiki`
--
ALTER TABLE `ujian_perbaiki`
  ADD CONSTRAINT `ujian_perbaiki_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `data_mhs` (`mhs_id`),
  ADD CONSTRAINT `ujian_perbaiki_ibfk_2` FOREIGN KEY (`matkul_id`) REFERENCES `mhs_matkul` (`matkul_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ujian_perbaiki_ibfk_3` FOREIGN KEY (`dosen_id`) REFERENCES `data_dosen` (`dosen_id`);

--
-- Constraints for table `ujian_susulan`
--
ALTER TABLE `ujian_susulan`
  ADD CONSTRAINT `ujian_susulan_ibfk_1` FOREIGN KEY (`mhs_id`) REFERENCES `data_mhs` (`mhs_id`),
  ADD CONSTRAINT `ujian_susulan_ibfk_2` FOREIGN KEY (`matkul_id`) REFERENCES `mhs_matkul` (`matkul_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ujian_susulan_ibfk_3` FOREIGN KEY (`dosen_id`) REFERENCES `data_dosen` (`dosen_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
