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
        <title>Informasi</title>
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
            <h1 class="heading">Informasi Donor Darah</h1>
            <h1 class="heading-2">MANFAAT DONOR DARAH</h1>
            <div class="box-container">
                <div class="box">
                    <p>
                        <li>Menjaga kesehatan jantung dan sirkulasi darah</li>
                        <li>Mengurangi jumlah kolesterol jahat</li>
                        <li>Meningkatkan produksi sel darah merah</li>
                        <li>Membantu mendeteksi dini penyakit tertentu</li>
                        <li>Menjaga kesehatan mental</li>
                    </p>
                </div>
            </div>

            <br><br>
            <h1 class="heading-2">SYARAT DONOR DARAH</h1>
            <div class="box-container">
                <div class="box">
                    <p>
                        <li>Usia antara 17 hingga 70 tahun.</li>
                        <li>Memiliki berat badan minimal 45 kg.</li>
                        <li>Tekanan darah normal atau berkisar antara 90/60 hingga 120/80 mmHg.</li>
                        <li>Kadar hemoglobin berada di kisaran 12,5-17 g/dL dan tidak melebihi 20 g/dL.</li>
                        <li>Interval waktu sejak donor darah terakhir minimal 3 bulan atau 12 minggu, jika sudah pernah mendonorkan darah sebelumnya.</li>
                        <li>Tidak sedang mengalami penyakit atau keluhan kesehatan, seperti kelemahan atau demam.</li>
                        <li>Tidak sedang hamil atau menyusui.</li>
                        <li>Bersedia menyumbangkan darah secara sukarela dengan menyetujui informed consent</li>
                    </p>
                </div>
            </div>
            
            <br><br>
            <h1 class="heading-2">KONDISI YANG TIDAK BOLEH DIMILIKI PENDONOR</h1>
            <div class="box-container">
                <div class="box">
                    <p>
                        <li>Mengidap penyakit seperti diabetes, kanker, penyakit jantung, masalah paru-paru, atau gangguan fungsi ginjal.</li>
                        <li>Memiliki tekanan darah yang terlalu tinggi atau terlalu rendah.</li>
                        <li>Menderita epilepsi atau sering mengalami kejang.</li>
                        <li>Memiliki riwayat penggunaan narkoba melalui suntikan.</li>
                        <li>Mengalami gangguan pembekuan darah seperti hemofilia.</li>
                        <li>Mengidap atau berisiko tinggi terkena penyakit menular seperti sifilis, HIV/AIDS, hepatitis B, hepatitis C, atau malaria.</li>
                        <li>Mengidap atau berisiko tinggi terkena penyakit menular seperti sifilis, HIV/AIDS, hepatitis B, hepatitis C, atau malaria.</li>
                        <li>Sedang mengonsumsi obat-obatan atau dalam pengobatan tertentu.</li>
                        <li>Kecanduan minuman beralkohol.</li>
                    </p>
                </div>
            </div>
                    
            <br><br>
            <h1 class="heading-2">HAL YANG HARUS DILAKUKAN SEBELUM DONOR DARAH</h1>
            <div class="box-container">
                <div class="box">
                    <p>
                        <li>Cukupi asupan gizi dan cairan tubuh Anda dengan makanan dan minuman kaya zat besi</li>
                        <li>Hindari makanan berlemak, seperti fast food atau es krim, yang bisa mengecoh hasil tes darah</li>
                        <li>Hindari konsumsi alkohol menjelang hari-H donor darah</li>
                        <li>Usahakan Anda cukup tidur pada malam sebelum melakukan donor darah</li>
                        <li>Perbanyak minum air putih atau minuman non-alkoholik lainnya sebelum donor</li>
                        <li>Gunakan pakaian yang lengannya mudah dilipat hingga di atas siku saat mendonor darah, agar proses lebih mudah dilakukan</li>
                    </p>
                </div>
            </div>
            
            <br><br>
            <h1 class="heading-2">HAL YANG HARUS DILAKUKAN SETELAH DONOR DARAH</h1>
            <div class="box-container">
                <div class="box">
                    <p>
                        <li>Membatasi aktivitas fisik Anda selama setidaknya 5 jam setelah donor</li>
                        <li>Melepaskan plester setidaknya 4-5 jam setelah selesai donor darah</li>
                        <li>Sebaiknya tidak berdiri lama di bawah sinar matahari langsung dan tidak minum minuman panas</li>
                        <li>Jika Anda merokok, sebaiknya jangan merokok selama dua jam setelah donor darah.</li>
                        <li>Jika Anda minum alkohol, sebaiknya jangan minum alkohol sampai 24 jam setelah donor</li>
                        <li>Minum banyak cairan untuk menggantikan cairan tubuh Anda yang hilang</li>
                        <li>Makan makanan yang mengandung zat besi tinggi, Vitamin C, Asam folat, Riboflavin (vitamin B2), Vitamin B6</li>
                    </p>
                </div>
            </div>

            <br><br>
            <h1 class="heading-2">PROSES DONOR DARAH</h1>
            <div class="box-container">
                <div class="box">
                    <p>
                        <ol>
                            <li>Registrasi</li>
                                <p>
                                    Anda akan diminta untuk menunjukkan kartu identitas (KTP/SIM/Paspor) dan kartu donor (jika punya) dan mengisi formulir pendaftaran
                                    seputar identitas diri, termasuk nomor identitas donor (jika Anda adalah pendonor rutin).
                                </p>
                            <li>Pemeriksaan kesehatan</li>
                                <p>
                                    Petugas pelayanan akan mewawancarai Anda seputar riwayat kesehatan dan penyakit Anda. Pada tahap ini, tekanan darah, kadar hemoglobin, 
                                    suhu tubuh, dan nadi Anda akan diukur.
                                </p>
                            <li>Donasi</li>
                                <p>
                                    Donor darah dilakukan dalam posisi duduk atau berbaring, dan dilakukan oleh petugas kesehatan profesional yang terlatih. Sebuah jarum steril 
                                    akan dimasukkan ke kulit di bagian siku
                                    dalam selama 8-10 menit sementara sekitar 500 ml darah dan beberapa tabung sampel darah dikumpulkan. Setelahnya, petugas akan menutup area 
                                    bekas suntikan dengan perban.
                                </p>
                            <li>Istirahat</li>
                                <p>Anda akan diberikan waktu memulihkan diri untuk mengisi kembali tenaga setelah kehilangan banyak volume cairan.</p>
                        </ol>
                    </p>
                </div>
            </div>
        </section>

        <script src="js/script.js"></script>
    </body>
</html>