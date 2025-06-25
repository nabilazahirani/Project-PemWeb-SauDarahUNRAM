<?php
session_start();
if (isset($_SESSION['email_admin'])) {
    $email = $_SESSION['email_admin'];
    $nama = $_SESSION['nama_admin'];
    $foto = $_SESSION['foto_admin']; 
    $id_admin = $_SESSION['id_admin'];
} else {
    header("Location: a_masuk.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal Donor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
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

<section class="edit">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        $conn = mysqli_connect('localhost', 'root', '', 'donor_darah');

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        function sanitize($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

        $lokasi = sanitize($_POST['lokasi_donor']);
        $tanggal = sanitize($_POST['tanggal_donor']);
        $deskripsi = sanitize($_POST['deskripsi']);

        $sql = "INSERT INTO jadwal_donor (id_admin, lokasi_donor, tanggal_donor, deskripsi)
                VALUES ('$id_admin', '$lokasi', '$tanggal', '$deskripsi')";

        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location: a_lihat_jadwal.php");
            exit();
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>

    <div class="row">
        <form class="editan" method="POST" action="">
            <h3>Tambah Jadwal Donor</h3>
            <input type="text" name="lokasi_donor" placeholder="Lokasi Donor" required><br>
            <input type="datetime-local" name="tanggal_donor" placeholder="Tanggal Donor" required><br>
            <input type="text" name="deskripsi" placeholder="Deskripsi (Opsional)"><br>
            <input type="submit" name="add" value="Tambah">
            <a href="a_lihat_jadwal.php" class="cancel-btn">Batal</a>
        </form>
    </div>
</section>

<script src="js/script.js"></script>
</body>
</html>
