<?php
session_start();
if (!isset($_SESSION['email_admin'])) {
    header("Location: a_masuk.php");
    exit();
}
$nama = $_SESSION['nama_admin'];
$foto = $_SESSION['foto_admin'];
$email = $_SESSION['email_admin'];

$conn = mysqli_connect("localhost", "root", "", "donor_darah");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$id_jadwal = isset($_GET['id_jadwal']) ? intval($_GET['id_jadwal']) : 0;

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM pendaftaran WHERE id_pendaftaran = $id");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pendaftar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
</head>
<body>
<header class="header">
    <section class="flex">
        <span class="logo">SauDarah Universitas Mataram</span>
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
            document.querySelector('#user-btn').onclick = () => {
                document.querySelector('.header .profile').classList.toggle('active');
            };
            document.querySelector('#profile-img').onclick = () => {
                document.querySelector('.header .profile').classList.toggle('active');
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
        <a href="a_lihat_jadwal.php"><i class="fas fa-calendar-alt"></i><span>Jadwal Donor</span></a>
        <a href="a_lihat_pendaftaran_jadwal.php"><i class="fas fa-clipboard-list"></i><span>Pendaftaran</span></a>
        <a href="a_lihat_pendonor.php"><i class="fas fa-user-friends"></i><span>Pendonor</span></a>
        <a href="a_menu_input_donor.php"><i class="fas fa-notes-medical"></i><span>Data Donor</span></a>
        <a href="a_kelola_forum.php"><i class="fas fa-comments"></i><span>Kelola Forum</span></a>
        <a href="a_kelola_riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
    </nav>
</div>

<section class="events">
    <h1 class="heading">Pendaftar pada Jadwal Donor ID: <?php echo $id_jadwal; ?></h1>
    <a href="a_tambah_pendaftaran.php?id_jadwal=<?php echo $id_jadwal; ?>" class="add-contact-btn">Tambah Pendaftar</a>
    <?php
    $sql = "SELECT pendaftaran.id_pendaftaran, pendonor.id_pendonor, pendonor.nama_pendonor, pendonor.email_pendonor, pendaftaran.waktupendaftaran 
            FROM pendaftaran 
            JOIN pendonor ON pendaftaran.id_pendonor = pendonor.id_pendonor 
            WHERE pendaftaran.id_jadwal = $id_jadwal";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<table><tr><th>ID Pendonor</th><th>Nama</th><th>Email</th><th>Waktu Daftar</th><th>Aksi</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id_pendonor']}</td>";
            echo "<td>{$row['nama_pendonor']}</td>";
            echo "<td>{$row['email_pendonor']}</td>";
            echo "<td>{$row['waktupendaftaran']}</td>";
            echo "<td>
                    <a href='?id_jadwal=$id_jadwal&delete={$row['id_pendaftaran']}' class='delete-btn'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Belum ada pendaftar pada jadwal ini.</p>";
    }
    ?>
</section>
</body>
</html>
