-- SQL Dump: donor_darah (Final Modified)
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET NAMES utf8mb4 */;

-- Tabel: admin (penyelenggara + admin gabung)
CREATE TABLE `admin` (
  `id_admin` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_admin` VARCHAR(255) NOT NULL,
  `alamat_admin` TEXT NOT NULL,
  `kontak_admin` VARCHAR(20) NOT NULL,
  `foto_admin` VARCHAR(255) NOT NULL,
  `email_admin` VARCHAR(255) NOT NULL,
  `sandi_admin` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin` (`id_admin`, `nama_admin`, `alamat_admin`, `kontak_admin`, `foto_admin`, `email_admin`, `sandi_admin`) VALUES
(1, 'Ijaa', 'Fakultas Teknik Unram', '081', 'uploads/HMIF.png', 'ija@gmail.com', '1224'),
(2, 'Nabila', 'Jl.2', '098765', 'uploads/nabilaZahirani.jpg', 'nabila@gmail.com', '123'),
(3, 'Wiwik', 'Jl.3', '12345', 'uploads/loopy.jpg', 'wiwik@gmail.com', '123');

-- Tabel: pendonor
CREATE TABLE `pendonor` (
  `id_pendonor` INT(11) NOT NULL AUTO_INCREMENT,
  `nik_pendonor` VARCHAR(20) NOT NULL,
  `nama_pendonor` VARCHAR(255) NOT NULL,
  `alamat_pendonor` TEXT NOT NULL,
  `tanggallahir_pendonor` DATE NOT NULL,
  `jeniskelamin_pendonor` VARCHAR(10) NOT NULL,
  `golongandarah_pendonor` VARCHAR(2) NOT NULL,
  `foto_pendonor` VARCHAR(255) NOT NULL,
  `email_pendonor` VARCHAR(255) NOT NULL,
  `sandi_pendonor` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_pendonor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `pendonor` (`id_pendonor`, `nik_pendonor`, `nama_pendonor`, `alamat_pendonor`, `tanggallahir_pendonor`, `jeniskelamin_pendonor`, `golongandarah_pendonor`, `foto_pendonor`, `email_pendonor`, `sandi_pendonor`) VALUES
(1, '123456789', 'Rendi', 'Jalan 1', '1999-12-31', 'Laki-Laki', 'A', 'uploads/HMIF.png', 'rendi@gmail.com', '123');

-- Tabel: jadwal_donor (pengelolaan kegiatan donor)
CREATE TABLE `jadwal_donor` (
  `id_jadwal` INT NOT NULL AUTO_INCREMENT,
  `id_admin` INT NOT NULL,
  `lokasi_donor` VARCHAR(255) NOT NULL,
  `tanggal_donor` DATETIME NOT NULL,
  `deskripsi` TEXT,
  PRIMARY KEY (`id_jadwal`),
  FOREIGN KEY (`id_admin`) REFERENCES `admin`(`id_admin`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel: pendaftaran (pendaftar ke jadwal donor)
CREATE TABLE `pendaftaran` (
  `id_pendaftaran` INT NOT NULL AUTO_INCREMENT,
  `id_pendonor` INT NOT NULL,
  `id_jadwal` INT NOT NULL,
  `waktupendaftaran` DATETIME NOT NULL,
  PRIMARY KEY (`id_pendaftaran`),
  FOREIGN KEY (`id_pendonor`) REFERENCES `pendonor`(`id_pendonor`) ON DELETE CASCADE,
  FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_donor`(`id_jadwal`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel: riwayat_donor (riwayat pendonor yang sudah donor)
CREATE TABLE `riwayat_donor` (
  `id_riwayat` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pendonor` INT NOT NULL,
  `id_jadwal` INT DEFAULT NULL,
  `tanggal_donor` DATETIME NOT NULL,
  `lokasi_donor` VARCHAR(255) NOT NULL,
  `jumlah_ml` INT NOT NULL,
  `keterangan` TEXT,
  FOREIGN KEY (`id_pendonor`) REFERENCES `pendonor`(`id_pendonor`) ON DELETE CASCADE,
  FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_donor`(`id_jadwal`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel: forum_topik (forum komunitas)
CREATE TABLE `forum_topik` (
  `id_topik` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pendonor` INT NOT NULL,
  `judul_topik` VARCHAR(255) NOT NULL,
  `isi_topik` TEXT NOT NULL,
  `tanggal_post` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_pendonor`) REFERENCES `pendonor`(`id_pendonor`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel: forum_komentar (balasan topik)
CREATE TABLE `forum_komentar` (
  `id_komentar` INT AUTO_INCREMENT PRIMARY KEY,
  `id_topik` INT NOT NULL,
  `id_pendonor` INT NOT NULL,
  `isi_komentar` TEXT NOT NULL,
  `tanggal_komentar` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_topik`) REFERENCES `forum_topik`(`id_topik`) ON DELETE CASCADE,
  FOREIGN KEY (`id_pendonor`) REFERENCES `pendonor`(`id_pendonor`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- END SQL
COMMIT;