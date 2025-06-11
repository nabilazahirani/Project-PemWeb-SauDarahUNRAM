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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tentang Kami</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <header class="header">
            <section class="flex">
            <a href="a_beranda.php" class="logo">SauDarah Universitas Mataram</a>
               
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
                <a href="a_beranda.php"><i class="fas fa-home"></i><span>Beranda</span></a>
                <a href="a_informasi.php"><i class="fas fa-info-circle"></i><span>Tentang</span></a>
                <a href="a_lihat_jadwal.php"><i class="fas fa-calendar-alt"></i><span>Jadwal Donor</span></a>
                <a href="a_lihat_pendaftaran_jadwal.php"><i class="fas fa-clipboard-list"></i><span>Pendaftaran</span></a>
                <a href="a_lihat_pendonor.php"><i class="fas fa-user-friends"></i><span>Pendonor</span></a>
                <a href="a_menu_input_donor.php"><i class="fas fa-notes-medical"></i><span>Data Donor</span></a>
                <a href="a_kelola_forum.php"><i class="fas fa-comments"></i><span>Kelola Forum</span></a>
                <a href="a_kelola_riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
                <a href="a_tentang_kami.php"><i class="fas fa-users"></i><span>Tentang Kami</span></a>
            </nav>
        </div>

        <section class="about">
            <h1 class="heading">Tentang Kami</h1>
            <h1 class="heading-2">SauDarah Universitas Mataram</h1>
            <div class="box-container">
                <div class="box">
                    <style>
                        .indented {
                            text-indent: 50px;
                        }
                    </style>
                    <p class="indented">
                        SauDarah Universitas Mataram adalah sebuah sistem informasi yang dirancang khusus untuk memfasilitasi kegiatan
                        donor darah secara efisien dan aman. Sistem informasi ini menonjolkan aspek keamanan dan privasi
                        data dengan sangat baik. Pengguna dapat merasa tenang mengetahui bahwa informasi pribadi
                        dan medis mereka dikelola dengan hati-hati dan dirahasiakan. Dengan Blood Unity, sistem
                        telah dirancang untuk memastikan bahwa data pengguna hanya digunakan untuk keperluan yang
                        relevan dengan donor darah. Hal ini memastikan bahwa data tidak akan disalahgunakan atau
                        digunakan secara tidak benar.
                    </p>
                    <br></br>
                    <p class="indented">
                        Selain itu, aplikasi ini menawarkan berbagai fitur yang memudahkan pengguna dalam melakukan
                        kegiatan donor darah, termasuk informasi tentang donor dan pendaftaran kegiatan donor.
                        Dengan kombinasi antara kemudahan penggunaan dan fokus yang kuat pada keamanan dan privasi
                        data, Blood Unity menjadi pilihan yang ideal bagi mereka yang ingin berpartisipasi dalam
                        kegiatan donor darah dengan percaya diri dan aman.
                    </p>
                </div>
            </div>
            <br><br>
            <h1 class="heading-2">KONTAK KAMI</h1>
               <div class="box-container">
                <div class="box" style="text-align: center;">
                    <p>
                        <strong>Nabila Zahirani</strong> <br>
                        nabilaZahirani@gmail.com
                    </p>
                </div>
                <div class="box" style="text-align: center;">
                    <p>
                        <strong>Robiatul Izzati</strong> <br>
                        robiatulIzzati@gmail.com
                    </p>
                </div>
                <div class="box" style="text-align: center;">
                    <p>
                        <strong>Wiwik Putri</strong> <br>
                        wiwikputri@gmail.com
                    </p>
                </div>
            </div>
        </section>

        <script src="js/script.js"></script>
    </body>
</html>