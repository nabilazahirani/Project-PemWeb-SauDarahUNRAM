<?php
session_start();
if (!isset($_SESSION['email_pendonor'])) {
    header("Location: m_masuk.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donor_darah";

$conn = new mysqli($servername, $username, $password, $dbname);

$email = $_SESSION['email_pendonor'];
$nama = $_SESSION['nama_pendonor'];
$foto = $_SESSION['foto_pendonor'];

// Ambil ID pendonor berdasarkan email
$query_user = mysqli_query($conn, "SELECT id_pendonor FROM pendonor WHERE email_pendonor = '$email'");
$data_user = mysqli_fetch_assoc($query_user);
$id_pendonor = $data_user['id_pendonor'];

// Proses submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);

    if (!empty($judul) && !empty($isi)) {
        $insert = mysqli_query($conn, "INSERT INTO forum_topik (id_pendonor, judul_topik, isi_topik) 
                                       VALUES ('$id_pendonor', '$judul', '$isi')");
        if ($insert) {
            header("Location: m_forum.php");
            exit();
        } else {
            $error = "Gagal menyimpan topik. Coba lagi.";
        }
    } else {
        $error = "Judul dan isi topik wajib diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buat Topik Baru</title>
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

<section class="home">
    <h1 class="heading">Buat Topik Baru</h1>

    <div class="form-container">
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <form action="" method="post" class="form-buat-topik">
            <label for="judul" class="heading">Judul Topik:</label>
            <input type="text" name="judul" id="judul" class="boxT" required>

            <label for="isi" class="heading">Isi Topik:</label>
            <textarea name="isi" id="isi" rows="6" class="boxT" required></textarea>

            <input type="submit" value="Update" class="inline-btn">
            <a href="m_forum.php" class="inline-btn-cancel">Batal</a>
        </form>
    </div>
</section>

<script src="js/script.js"></script>
</body>
</html>
