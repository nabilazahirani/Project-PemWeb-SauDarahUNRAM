<?php
session_start();
if (!isset($_SESSION['email_admin'])) {
    header("Location: a_masuk.php");
    exit();
}
$email = $_SESSION['email_admin'];
$nama = $_SESSION['nama_admin'];
$foto = $_SESSION['foto_admin'];

$conn = mysqli_connect('localhost', 'root', '', 'donor_darah');
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function sanitize($data){
    return htmlspecialchars(stripslashes(trim($data)));
}

$id_jadwal = isset($_GET['id_jadwal']) ? intval($_GET['id_jadwal']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['jumlah_ml'] as $id_pendonor => $jumlah_ml) {
        $jumlah_ml = intval($jumlah_ml);
        $keterangan = sanitize($_POST['keterangan'][$id_pendonor]);

        // ambil lokasi dari jadwal
        $jadwal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT lokasi_donor FROM jadwal_donor WHERE id_jadwal = '$id_jadwal'"));
        $lokasi = $jadwal ? $jadwal['lokasi_donor'] : '';
        $tanggal_donor = date('Y-m-d H:i:s');

        mysqli_query($conn, "INSERT INTO riwayat_donor (id_pendonor, id_jadwal, tanggal_donor, lokasi_donor, jumlah_ml, keterangan)
                             VALUES ('$id_pendonor', '$id_jadwal', '$tanggal_donor', '$lokasi', '$jumlah_ml', '$keterangan')");
    }

    echo "<script>alert('Data riwayat berhasil disimpan'); window.location.href='a_menu_input_donor.php';</script>";
    exit();
}

// ambil data pendaftaran berdasarkan id_jadwal
$sql = "SELECT p.id_pendonor, d.nama_pendonor, d.golongandarah_pendonor 
        FROM pendaftaran p
        JOIN pendonor d ON p.id_pendonor = d.id_pendonor
        WHERE p.id_jadwal = '$id_jadwal'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Input Riwayat Donor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #f2f2f2; }
        input[type='number'], textarea { width: 100%; }
        .save-btn { margin-top: 20px; padding: 10px 20px; background-color: #2ecc71; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<header class="header">
    <section class="flex">
        <a href="a_beranda.php" class="logo">SauDarah Universitas Mataram</a>
        <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
            <a href="a_masuk.php"><div class="fas fa-right-from-bracket"></div></a>
        </div>
        <div class="profile" id="profile">
            <img src="<?php echo $foto; ?>" class="image" id="profile-img" alt="">
            <h3 class="name"><?php echo $nama . ' (Admin)'; ?></h3>
            <p class="role"><?php echo $email; ?></p>
            <div class="flex-btn">
                <a href="a_profil.php" class="option-btn">Ubah Profil</a>
            </div>
        </div>
        <script>
            let profile = document.querySelector('.header .profile');
            document.querySelector('#user-btn').onclick = () => { profile.classList.toggle('active'); };
            document.querySelector('#profile-img').onclick = () => { profile.classList.toggle('active'); };
        </script>
    </section>
</header>

<div class="side-bar">
    <div class="profile">
        <img src="<?php echo $foto; ?>" class="image" alt="">
        <h3 class="name"><?php echo $nama . ' (Admin)'; ?></h3>
        <p class="role"><?php echo $email; ?></p>
    </div>
    <nav class="navbar">
            <a href="a_lihat_jadwal.php"><i class="fas fa-calendar-alt"></i><span>Jadwal Donor</span></a>
            <a href="a_lihat_pendaftaran_jadwal.php"><i class="fas fa-clipboard-list"></i><span>Pendaftaran</span></a>
            <a href="a_lihat_pendonor.php"><i class="fas fa-user-friends"></i><span>Pendonor</span></a>
            <a href="a_menu_input_donor.php"><i class="fas fa-notes-medical"></i><span>Data Donor</span></a>
            <a href="a_kelola_forum.php"><i class="fas fa-comments"></i><span>Kelola Forum</span></a>
            <a href="a_kelola_riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
    </nav>
</div>

<section class="events">
    <h1 class="heading">Input Riwayat Donor</h1>
    <form method="POST">
        <table>
            <tr>
                <th>ID Pendonor</th>
                <th>Nama</th>
                <th>Golongan Darah</th>
                <th>Jumlah (ml)</th>
                <th>Keterangan</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id_pendonor']}</td>";
                    echo "<td>{$row['nama_pendonor']}</td>";
                    echo "<td>{$row['golongandarah_pendonor']}</td>";
                    echo "<td><input type='number' name='jumlah_ml[{$row['id_pendonor']}]' required></td>";
                    echo "<td><textarea name='keterangan[{$row['id_pendonor']}]'></textarea></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada pendaftar untuk jadwal ini.</td></tr>";
            }
            ?>
        </table>
        <button type="submit" class="inline-btn">Simpan Riwayat</button>
    </form>
</section>

<script src="js/script.js"></script>
</body>
</html>
