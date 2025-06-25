<?php
session_start();
if (!isset($_SESSION['email_pendonor'])) {
    header("Location: m_masuk.php");
    exit();
}

$email = $_SESSION['email_pendonor'];
$nama = $_SESSION['nama_pendonor'];
$foto = $_SESSION['foto_pendonor'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donor_darah";
$conn = new mysqli($servername, $username, $password, $dbname);

// Ambil ID pendonor
$queryId = "SELECT id_pendonor FROM pendonor WHERE email_pendonor = '$email'";
$resId = mysqli_query($conn, $queryId);
$data = mysqli_fetch_assoc($resId);
$id_pendonor = $data['id_pendonor'];

// Tangani aksi daftar
if (isset($_POST['daftar'])) {
    $id_jadwal = $_POST['id_jadwal'];

    // Cek apakah sudah pernah daftar
    $cek = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE id_pendonor = $id_pendonor AND id_jadwal = $id_jadwal");
    if (mysqli_num_rows($cek) == 0) {
        $now = date('Y-m-d H:i:s');
        mysqli_query($conn, "INSERT INTO pendaftaran (id_pendonor, id_jadwal, waktupendaftaran) VALUES ($id_pendonor, $id_jadwal, '$now')");
        echo "<script>alert('Berhasil mendaftar donor!');</script>";
    } else {
        echo "<script>alert('Anda sudah mendaftar untuk jadwal ini!');</script>";
    }
}

// Ambil semua jadwal donor
$query = "SELECT * FROM jadwal_donor ORDER BY tanggal_donor DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Donor</title>
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
            document.querySelector('#user-btn').onclick = () => profile.classList.toggle('active');
            document.querySelector('#profile-img').onclick = () => profile.classList.toggle('active');
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
    <h1 class="heading" style="margin-bottom: 20px;"><br>Daftar Jadwal Donor</h1>
    <div class="box-container" style="overflow-x: auto;">
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background-color: #eee;">
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['lokasi_donor']); ?></td>
                            <td><?php echo date('d M Y H:i', strtotime($row['tanggal_donor'])); ?></td>
                            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id_jadwal" value="<?php echo $row['id_jadwal']; ?>">
                                    <button type="submit" name="daftar" class="inline-btn">Daftar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align: center;">Belum ada jadwal donor tersedia.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<script src="js/script.js"></script>
</body>
</html>
