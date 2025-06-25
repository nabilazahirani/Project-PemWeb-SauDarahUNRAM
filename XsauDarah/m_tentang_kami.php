<?php
session_start();
if (!isset($_SESSION['email_pendonor'])) {
    header("Location: m_masuk.php");
    exit();
}
$email = $_SESSION['email_pendonor'];
$nama  = $_SESSION['nama_pendonor'];
$foto  = $_SESSION['foto_pendonor'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami | SauDarah UNRAM</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <style>
        .indented {
            text-indent: 50px;
            line-height: 1.7;
        }
        .box p {
            font-size: 1rem;
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="header">
    <section class="flex">
        <a href="m_beranda.php" class="logo">SauDarah Universitas Mataram</a>
        <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
            <a href="m_masuk.php"><div class="fas fa-right-from-bracket"></div></a>
        </div>
        <div class="profile" id="profile">
            <img src="<?= $foto ?>" class="image" id="profile-img" alt="Foto Profil">
            <h3 class="name"><?= $nama ?></h3>
            <p class="role"><?= $email ?></p>
            <div class="flex-btn">
                <a href="m_profil.php" class="option-btn">Ubah Profil</a>
            </div>
        </div>
    </section>
</header>

<!-- Sidebar -->
<div class="side-bar">
    <div class="profile">
        <img src="<?= $foto ?>" class="image" alt="Foto Profil">
        <h3 class="name"><?= $nama ?></h3>
        <p class="role"><?= $email ?></p>
    </div>
    <nav class="navbar">
        <a href="m_beranda.php"><i class="fas fa-home"></i><span>Beranda</span></a>
        <a href="m_informasi.php"><i class="fas fa-bullhorn"></i><span>Informasi</span></a>
        <a href="m_daftar_donor.php"><i class="fas fa-hand-holding-medical"></i><span>Donor</span></a>
        <a href="m_forum.php"><i class="fas fa-comments"></i><span>Forum</span></a>
        <a href="m_riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
        <a href="m_tentang_kami.php" class="active"><i class="fas fa-users"></i><span>Tentang Kami</span></a>
    </nav>
</div>

<!-- Tentang Kami -->
<main>
    <section class="about">
        <h1 class="heading-proses">Tentang Kami</h1>
        <div class="box-container-proses">
            <div class="box-proses">
                <p class="indented">
                    SauDarah Universitas Mataram adalah platform digital yang bertujuan mendukung kegiatan donor darah di lingkungan kampus. Kami hadir sebagai bentuk kepedulian sosial, memfasilitasi mahasiswa, dosen, dan masyarakat sekitar untuk berpartisipasi dalam kegiatan donor darah yang terjadwal dengan baik.
                </p>
                <p class="indented">
                    Melalui sistem yang terintegrasi, SauDarah menyediakan informasi jadwal, pendaftaran donor, dan dokumentasi kegiatan yang mudah diakses. Tujuan utama kami adalah meningkatkan kesadaran akan pentingnya donor darah dan mendorong semangat kemanusiaan di kalangan civitas akademika.
                </p>
                <p class="indented">
                    Kami berkomitmen menjadi penggerak budaya donor darah di UNRAM dan menjalin jaringan kemanusiaan yang lebih luas di masa depan.
                </p>
            </div>
        </div>

                <br><br>

        <h1 class="heading-2">Visi & Misi</h1>
        <div class="box-container-proses">
            <div class="box-proses">
                <h3>Visi</h3>
                <p class="indented">
                    Menjadi platform digital terdepan dalam mendukung kegiatan donor darah yang terorganisir, partisipatif, dan berkelanjutan di lingkungan Universitas Mataram.
                </p>

                <h3><br>Misi</h3>
                <ul style="padding-left: 50px; line-height: 1.7;">
                    <li>Meningkatkan kesadaran dan partisipasi civitas akademika dalam kegiatan donor darah secara rutin.</li>
                    <li>Menyediakan sistem informasi donor darah yang transparan, mudah diakses, dan terpercaya.</li>
                    <li>Menjalin kolaborasi dengan rumah sakit dan lembaga kemanusiaan untuk memperluas jaringan donor.</li>
                    <li>Mendukung budaya gotong royong dan kepedulian sosial melalui aksi kemanusiaan di bidang kesehatan.</li>
                </ul>
            </div>
        </div>

        <br><br>

        <h1 class="heading">Kontak Kami</h1>
        <div class="box-container-proses">
            <div class="box" style="text-align: center;">
                <p><strong>Nabila Zahirani</strong><br>nabilazahirani@gmail.com</p>
            </div>
            <div class="box" style="text-align: center;">
                <p><strong>Robiatul Izzati</strong><br>robiatulizzati@gmail.com</p>
            </div>
            <div class="box" style="text-align: center;">
                <p><strong>Wiwik Putri</strong><br>wiwikputri@gmail.com</p>
            </div>
        </div>
    </section>
</main>

<!-- Script -->
<script>
    const profile = document.querySelector('.header .profile');
    document.querySelector('#user-btn').onclick = () => {
        profile.classList.toggle('active');
    };
    document.querySelector('#profile-img').onclick = () => {
        profile.classList.toggle('active');
    };
</script>
<script src="js/script.js"></script>
</body>
</html>