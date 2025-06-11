<!-- 
    fungsi session dalam PHP digunakan untuk membuat, mengakses, dan mengelola sesi (session) pada aplikasi web. sesuatu yang
    disimpan dalam sesi dapat diakses di beberapa halaman atau skrip PHP selama sesi pengguna aktif.
    
    session_start(): fungsi ini harus dipanggil di awal setiap halaman yang menggunakan sesi. fungsi ini memulai sesi atau
    melanjutkan sesi yang sudah ada. tanpa memanggil fungsi ini, tidak akan mungkin mengakses atau menyimpan data ke dalam sesi.
-->

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

<!-- 
    user harus melalui login terlebih dahulu untuk masuk ke dalah halaman beranda dan mengakses fitur2 lainnya sesuai level
    user masing2.
    - jika session 'email' sudah di-set, maka variabel $email dan $nama akan diisi dengan nilai dari session tersebut.
    - jika session 'email' belum di-set atau tidak ada, pengguna akan diarahkan ke halaman 'a_masuk.php' untuk masuk (login).
-->

<!DOCTYPE html>
<html lang="en">
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

        <<section class="home">
            <h1 class="heading" style="margin-bottom: 0px;">Beranda</h1>
            <div class="row" style="margin-top: 0px;">
                <div class="image" >
                    <img src="img/beranda.jpg" alt="">
                </div>

                <div class="content">
                    <h3>Donor Darah</h3>
                    <p>
                        Donor darah adalah tindakan mulia yang dapat menyelamatkan banyak nyawa. Jumlah yang diberikan dalam prosedur donor darah akan
                        bergantung pada tinggi badan, berat badan, dan jumlah trombosit Anda. Donor darah di Indonesia diatur oleh <b>Peraturan Pemerintah
                        No. 2/2011</b> tentang pelayanan donor darah yang diatur oleh <b>Palang Merah Indonesia (PMI)</b> sebagai tujuan sosial dan kemanusiaan.
                        Setiap tetes darah yang Anda berikan sangat berharga dan dapat memberikan kesempatan hidup baru bagi mereka yang membutuhkan.
                        Bergabunglah dengan komunitas donor darah hari ini dan jadilah pahlawan bagi sesama. Bersama kita bisa membuat perbedaan!
                    </p>
                    <a href="a_lihat_penyelenggara.php" class="inline-btn">Jadwal Donor</a>
                </div>
            </div>
        </section>

        <script src="js/script.js"></script>
    </body>
</html>