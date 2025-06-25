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

// Hapus topik jika ada request hapus
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    $id_pendonor = $_SESSION['id_pendonor']; // Pastikan ini sudah disimpan di session saat login

    $query = "SELECT id_pendonor FROM forum_topik WHERE id_topik = '$id_hapus'";
    $result_owner = mysqli_query($conn, $query);

    if ($result_owner && mysqli_num_rows($result_owner) > 0) {
        $row_owner = mysqli_fetch_assoc($result_owner);
        $owner_id = $row_owner['id_pendonor'];

        if ($owner_id == $id_pendonor) {
            // hapus topik
            $stmt = $conn->prepare("DELETE FROM forum_topik WHERE id_topik = ?");
            $stmt->bind_param("i", $id_hapus);
            $stmt->execute();
            $stmt->close();

            header("Location: m_forum.php");
            exit();
        } else {
            echo "<script>alert('Anda tidak berhak menghapus topik ini.');</script>";
        }
    } else {
        echo "<script>alert('Topik tidak ditemukan.');</script>";
    }
}

// Ambil semua topik beserta nama pendonor dan jumlah komentar
$query = "SELECT ft.id_topik, ft.judul_topik, ft.id_pendonor, p.nama_pendonor, 
                 (SELECT COUNT(*) FROM forum_komentar fk WHERE fk.id_topik = ft.id_topik) AS jumlah_komentar
          FROM forum_topik ft
          JOIN pendonor p ON ft.id_pendonor = p.id_pendonor
          ORDER BY ft.tanggal_post DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forum</title>
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
    <h1 class="heading" style="margin-bottom: 20px;"><br>Forum Komunitas</h1>

    <div class="box-container-proses" style="overflow-x: auto;">
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background-color: #eee;">
                    <th>Judul Topik</th>
                    <th>Oleh</th>
                    <th>Komentar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><a href="m_topik.php?id_topik=<?php echo $row['id_topik']; ?>" style="color: blue;"><?php echo htmlspecialchars($row['judul_topik']); ?></a></td>
                    <td><?php echo htmlspecialchars($row['nama_pendonor']); ?></td>
                    <td><?php echo $row['jumlah_komentar']; ?></td>
                    <td>
                    <?php if ($row['id_pendonor'] == $_SESSION['id_pendonor']): ?>
                        <a href="m_forum.php?hapus=<?php echo $row['id_topik']; ?>" 
                        onclick="return confirm('Yakin ingin menghapus topik ini?');" 
                        style="color: #950000;">Hapus</a>
                    <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>

            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        <a href="m_buat_topik.php" class="inline-btn">+ Buat Topik Baru</a>
    </div>
</section>

<script src="js/script.js"></script>
</body>
</html>
