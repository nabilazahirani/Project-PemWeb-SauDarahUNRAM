<?php
session_start();
if (!isset($_SESSION['email_pendonor'])) {
    header("Location: m_masuk.php");
    exit();
}

$email = $_SESSION['email_pendonor'];
$nama = $_SESSION['nama_pendonor'];
$foto = $_SESSION['foto_pendonor'];
$id_pendonor = $_SESSION['id_pendonor'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donor_darah";

$conn = new mysqli($servername, $username, $password, $dbname);

// Hapus satu riwayat
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    $conn->query("DELETE FROM riwayat_donor WHERE id_riwayat = $id_hapus AND id_pendonor = $id_pendonor");
    header("Location: m_riwayat.php");
    exit();
}

// Hapus semua riwayat
if (isset($_GET['hapus_semua'])) {
    $conn->query("DELETE FROM riwayat_donor WHERE id_pendonor = $id_pendonor");
    header("Location: m_riwayat.php");
    exit();
}

// Ambil data riwayat donor milik pendonor ini
$query = "SELECT * FROM riwayat_donor WHERE id_pendonor = $id_pendonor ORDER BY tanggal_donor DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Donor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <section class="flex">
        <a href="m_beranda.php" class="logo">SauDarah Universitas Mataram</a>
        <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
            <a href="m_masuk.php"><div class="fas fa-right-from-bracket"></div></a>
        </div>
        <div class="profile" id="profile">
            <img src="<?php echo $foto; ?>" class="image" id="profile-img" alt="">
            <h3 class="name"><?php echo $nama; ?></h3>
            <p class="role"><?php echo $email; ?></p>
            <div class="flex-btn">
                <a href="m_profil.php" class="option-btn">Ubah Profil</a>
            </div>
        </div>
        <script>
            let profile = document.querySelector('.header .profile');
            document.querySelector('#user-btn').onclick = () => {
                profile.classList.toggle('active');
            };
            document.querySelector('#profile-img').onclick = () => {
                profile.classList.toggle('active');
            };
        </script>
    </section>
</header>

<div class="side-bar">
    <div class="profile">
        <img src="<?php echo $foto; ?>" class="image" alt="">
        <h3 class="name"><?php echo $nama; ?></h3>
        <p class="role"><?php echo $email; ?></p>
    </div>

    <nav class="navbar">
        <a href="m_beranda.php"><i class="fas fa-home"></i><span>Beranda</span></a>
        <a href="m_informasi.php"><i class="fas fa-bullhorn"></i><span>Informasi</span></a>
        <a href="m_daftar_donor.php"><i class="fas fa-hand-holding-medical"></i><span>Donor</span></a>
        <a href="m_forum.php"><i class="fas fa-comments"></i><span>Forum</span></a>
        <a href="m_riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
        <a href="m_tentang_kami.php"><i class="fas fa-users"></i><span>Tentang Kami</span></a>
    </nav>
</div>

<section class="about">
    <h1 class="heading" style="margin-bottom: 20px;"><br>Riwayat Donor Saya</h1>

    <div class="box-container-proses" style="overflow-x: auto;">
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background-color: #eee;">
                    <th>Tanggal Donor</th>
                    <th>Lokasi</th>
                    <th>Jumlah (ml)</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo date("d-m-Y H:i", strtotime($row['tanggal_donor'])); ?></td>
                            <td><?php echo htmlspecialchars($row['lokasi_donor']); ?></td>
                            <td><?php echo $row['jumlah_ml']; ?></td>
                            <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                            <td>
                                <a href="m_riwayat.php?hapus=<?php echo $row['id_riwayat']; ?>" onclick="return confirm('Yakin ingin menghapus riwayat ini?')" style="color: #950000;">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;">Belum ada riwayat donor.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
    <div style="margin-top: 20px;">
        <a href="m_riwayat.php?hapus_semua=1" class="inline-btn" style="background-color: #950000;" onclick="return confirm('Hapus semua riwayat donor?')">Hapus Semua</a>
    </div>
    <?php endif; ?>
</section>

<script src="js/script.js"></script>
</body>
</html>
