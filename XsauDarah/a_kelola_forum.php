<?php
session_start();
if (isset($_SESSION['email_admin'])) {
    $email = $_SESSION['email_admin'];
    $nama = $_SESSION['nama_admin'];
    $foto = $_SESSION['foto_admin'];
} else {
    header("Location: a_masuk.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donor_darah";

$conn = new mysqli($servername, $username, $password, $dbname);

// Hapus topik jika ada request hapus
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    
    $row_owner = mysqli_fetch_assoc($result_owner);
    $owner_id = $row_owner['id_pendonor'];
    
    // hapus topik
    $stmt = $conn->prepare("DELETE FROM forum_topik WHERE id_topik = ?");
    $stmt->bind_param("i", $id_hapus);
    $stmt->execute();
    $stmt->close();

    header("Location: a_kelola_forum.php");
    exit();
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Forum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <section class="flex">
    <span class="logo">SauDarah Universitas Mataram</span>

        <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
            <a href="a_masuk.php">
                <div class="fas fa-right-from-bracket"></div>
            </a>
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
        <h3 class="name"><?php echo $nama . ' (Admin)'; ?></h3>
        <p class="role"><?php echo $email; ?></p>
    </div>

    <nav class="navbar">
        <a href="a_index.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
        <a href="a_lihat_jadwal.php"><i class="fas fa-calendar-alt"></i><span>Jadwal Donor</span></a>
        <a href="a_lihat_pendaftaran_jadwal.php"><i class="fas fa-clipboard-list"></i><span>Pendaftaran</span></a>
        <a href="a_lihat_pendonor.php"><i class="fas fa-user-friends"></i><span>Pendonor</span></a>
        <a href="a_menu_input_donor.php"><i class="fas fa-notes-medical"></i><span>Data Donor</span></a>
        <a href="a_kelola_forum.php"><i class="fas fa-comments"></i><span>Kelola Forum</span></a>
        <a href="a_kelola_riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
    </nav>
</div>

<section class="events">
    <h1 class="heading">Kelola Forum</h1>
    <table border="1" cellpadding="10" cellspacing="0" >
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
                <td><a href="a_kelola_topik.php?id_topik=<?php echo $row['id_topik']; ?>" style="color: blue;"><?php echo htmlspecialchars($row['judul_topik']); ?></a></td>
                <td><?php echo htmlspecialchars($row['nama_pendonor']); ?></td>
                <td><?php echo $row['jumlah_komentar']; ?></td>
                <td>
                    <a href="a_kelola_forum.php?hapus=<?php echo $row['id_topik']; ?>" 
                    onclick="return confirm('Yakin ingin menghapus topik ini?');" 
                    style="color: red;">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>

        </tbody>
    </table>
</section>

<script src="js/script.js"></script>
</body>
</html>
