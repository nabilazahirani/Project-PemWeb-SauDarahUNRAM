<?php
// Memulai session untuk mengelola data pengguna selama kunjungan aktif
session_start();

// Mengecek apakah pengguna sudah login
if (isset($_SESSION['email_pendonor'])) {
    $email = $_SESSION['email_pendonor'];
    $nama  = $_SESSION['nama_pendonor'];
    $foto  = $_SESSION['foto_pendonor'];
} else {
    // Jika belum login, arahkan ke halaman login
    header("Location: m_masuk.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
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
    <div class="row" style="margin-top: 0px;">
        <div class="image">
            <img src="img/pmi.png" alt="PMI">
        </div>

        <div class="content">
            <h3><br><br>Apa Itu Donor Darah?</h3>
            <p><br>
                Donor darah adalah proses sukarela di mana seseorang memberikan sebagian dari darahnya
                untuk disimpan dan digunakan bagi orang lain yang membutuhkan, seperti pasien yang
                mengalami kehilangan darah akibat kecelakaan, operasi, atau penyakit tertentu.
                Kegiatan ini tidak hanya memberikan harapan hidup bagi penerima, tetapi juga memberikan
                manfaat kesehatan bagi pendonor, seperti meningkatkan produksi sel darah baru dan
                menjaga kesehatan jantung. Melalui donor darah, setiap individu dapat turut
                berkontribusi dalam misi kemanusiaan — membantu sesama dan menyelamatkan nyawa
                hanya dalam waktu beberapa menit.<br><br><br><br><br>
            </p>
        </div>
    </div>
</section>

<!-- Gradasi transisi dari putih ke pink -->
<div class="fade-transition"></div>

<section class="pink-section">
    <div class="row">
        <div class="content-pink">
            <h3>Apa Itu SauDarah UNRAM?</h3>
            <p>
                <br>SauDarah UNRAM adalah platform digital yang dikembangkan oleh Universitas Mataram
                untuk memfasilitasi kegiatan donor darah secara lebih mudah, terorganisir, dan tepat sasaran.
                Nama SauDarah merupakan singkatan dari Sahabat Untuk Donor Darah,
                yang mencerminkan semangat gotong royong, solidaritas, dan kemanusiaan dalam membantu sesama.
            </p>
            <p>
                Platform ini bertujuan untuk menghubungkan pasien yang membutuhkan transfusi darah dengan para
                pendonor sukarela di lingkungan Rumah Sakit Universitas Mataram dan sekitarnya. Dengan fitur-fitur
                yang disediakan, pengguna dapat melihat jadwal donor darah, mendaftar sebagai pendonor,
                mengakses informasi penting seputar donor darah, serta memantau riwayat donor mereka. 
            </p>
        </div>
        <div class="image">
            <img src="img/unram.png" alt="Logo UNRAM">
        </div>
    </div>
    <div class="center-button">
        <a href="m_daftar_donor.php" class="inline-btn">Lihat Jadwal Donor Darah</a>
    </div>
</section>
</body>
</html>
