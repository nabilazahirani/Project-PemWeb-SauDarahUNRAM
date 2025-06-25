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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donor_darah";

$conn = new mysqli($servername, $username, $password, $dbname);

$today = date('Y-m-d H:i:s');
$query = "SELECT * FROM jadwal_donor WHERE tanggal_donor >= '$today' ORDER BY tanggal_donor ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
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
            <a href="m_notifikasi.php"><i class="fas fa-bell"></i><span>Notifikasi</span></a>
            <a href="m_daftar_donor.php"><i class="fas fa-hand-holding-medical"></i><span>Donor</span></a>
            <a href="m_forum.php"><i class="fas fa-comments"></i><span>Forum</span></a>
            <a href="m_riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
            <a href="m_tentang_kami.php"><i class="fas fa-users"></i><span>Tentang Kami</span></a>
        </nav>
    </div>

    <section class="home">
        <h1 class="heading">Notifikasi</h1>

        <div class="box-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $lokasi = $row['lokasi_donor'];
                    $tanggal = date('d M Y', strtotime($row['tanggal_donor']));
                    $jam = date('H:i', strtotime($row['tanggal_donor']));
                    $deskripsi = $row['deskripsi'];

                    echo "<div class='box'>
                            <i class='fas fa-calendar-check'></i>
                            <h3>Donor di $lokasi</h3>
                            <p><strong>Tanggal:</strong> $tanggal<br><strong>Jam:</strong> $jam</p>";
                    if (!empty($deskripsi)) {
                        echo "<p><strong>Catatan:</strong> $deskripsi</p>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<div class='box'>
                        <i class='fas fa-info-circle'></i>
                        <p>Tidak ada kegiatan donor darah yang dijadwalkan saat ini.</p>
                      </div>";
            }
            ?>
        </div>
    </section>

    <script src="js/script.js"></script>
</body>
</html>
