<?php
session_start();
if (isset($_SESSION['email_pendonor'])) {
    $email = $_SESSION['email_pendonor'];
    $nama = $_SESSION['nama_pendonor'];
    $foto = $_SESSION['foto_pendonor'];
} else {
    header("Location: m_masuk.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">   
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informasi</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <header class="header">
            <section class="flex">
                <a href="m_beranda.php" class="logo">SauDarah Universitas Mataram</a>

                <div class="icons">
                    <div id="user-btn" class="fas fa-user"></div>
                    <a href="m_masuk.php">
                        <div class="fas fa-right-from-bracket"></div>
                    </a>
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
            <h1 class="heading"><br>Informasi Donor Darah</h1>

            <div class="box-container">
                <!-- Box 1 -->
                <div class="box">
                    <img src="img/artikel1.jpeg" alt="Manfaat Donor Darah" class="box-img">
                    <h3 class="box-title">Manfaat Donor Darah</h3>
                    <ol>
                        <li>Menjaga kesehatan jantung dan sirkulasi darah</li>
                        <li>Mengurangi jumlah kolesterol jahat</li>
                        <li>Meningkatkan produksi sel darah merah</li>
                        <li>Membantu mendeteksi dini penyakit tertentu</li>
                        <li>Menjaga kesehatan mental</li>
                    </ol>
                </div>

                <!-- Box 2 -->
                <div class="box">
                    <img src="img/artikel2.jpeg" alt="Syarat Donor" class="box-img">
                    <h3 class="box-title">Syarat Donor</h3>
                    <ol>
                        <li>Usia antara 17 hingga 70 tahun.</li>
                        <li>Memiliki berat badan minimal 45 kg.</li>
                        <li>Tekanan darah normal antara 90/60 - 120/80 mmHg.</li>
                        <li>Kadar hemoglobin 12,5-17 g/dL.</li>
                        <li>Interval donor minimal 3 bulan.</li>
                        <li>Tidak sedang sakit, hamil, atau menyusui.</li>
                        <li>Bersedia menyumbangkan darah secara sukarela.</li>
                    </ol>
                </div>

                <!-- Box 3 -->
                <div class="box">
                    <img src="img/artikel3.jpeg" alt="Kondisi Tidak Boleh" class="box-img">
                    <h3 class="box-title">Kondisi Tidak Boleh</h3>
                    <ol>
                        <li>Diabetes, kanker, jantung, paru-paru, atau ginjal.</li>
                        <li>Tekanan darah terlalu tinggi atau rendah.</li>
                        <li>Epilepsi atau kejang.</li>
                        <li>Penggunaan narkoba suntik.</li>
                        <li>HIV/AIDS, hepatitis B/C, sifilis, malaria.</li>
                    </ol>
                </div>

                <!-- Box 4 -->
                <div class="box">
                    <img src="img/artikel4.jpeg" alt="Sebelum Donor" class="box-img">
                    <h3 class="box-title">Sebelum Donor</h3>
                    <ol>
                        <li>Konsumsi makanan bergizi dan zat besi.</li>
                        <li>Hindari makanan berlemak dan alkohol.</li>
                        <li>Cukup tidur malam sebelumnya.</li>
                        <li>Minum cukup air putih.</li>
                        <li>Pakai baju berlengan pendek atau mudah digulung.</li>
                    </ol>
                </div>

                <!-- Box 5 -->
                <div class="box">
                    <img src="img/artikel5.jpg" alt="Setelah Donor" class="box-img">
                    <h3 class="box-title">Setelah Donor</h3>
                    <ol>
                        <li>Batasi aktivitas fisik setelah donor.</li>
                        <li>Lepas plester setelah 4-5 jam.</li>
                        <li>Hindari matahari langsung dan minuman panas.</li>
                        <li>Tidak merokok 2 jam, dan alkohol 24 jam.</li>
                        <li>Minum banyak cairan dan konsumsi zat besi.</li>
                    </ol>
                </div>
            </div>

            <br><br>
            <h1 class="heading-proses">PROSES DONOR DARAH</h1>
            <div class="box-container-proses">
                <div class="box-proses">
                    <ol class="proses-list">
                        <li>
                            <strong>Registrasi</strong><br>
                            Anda akan diminta untuk menunjukkan kartu identitas (KTP/SIM/Paspor) dan kartu donor (jika punya), serta mengisi formulir pendaftaran seputar identitas diri.
                        </li>
                        <li>
                            <strong>Pemeriksaan kesehatan</strong><br>
                            Petugas akan mewawancarai Anda seputar riwayat kesehatan. Tekanan darah, hemoglobin, suhu tubuh, dan nadi Anda akan diukur.
                        </li>
                        <li>
                            <strong>Donasi</strong><br>
                            Donor dilakukan dalam posisi duduk/berbaring, dengan jarum steril di bagian siku. Sekitar 500 ml darah diambil dalam waktu 8–10 menit.
                        </li>
                        <li>
                            <strong>Istirahat</strong><br>
                            Anda akan diberi waktu memulihkan diri untuk mengisi tenaga setelah kehilangan volume cairan.
                        </li>
                    </ol>
                </div>
            </div>

        </section>

        <script src="js/script.js"></script>
    </body>
</html>