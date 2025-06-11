<?php
session_start();
if (!isset($_SESSION['email_admin'])) {
    header("Location: a_masuk.php");
    exit();
}
$email = $_SESSION['email_admin'];
$nama = $_SESSION['nama_admin'];
$foto = $_SESSION['foto_admin'];

$conn = mysqli_connect('localhost', 'root', '', 'donor_darah');
if (!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}

function sanitize($data){
    return htmlspecialchars(stripslashes(trim($data)));
}

$id_jadwal = isset($_GET['id_jadwal']) ? intval($_GET['id_jadwal']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pendonor'])) {
    $selected = $_POST['pendonor'];
    $now = date('Y-m-d H:i:s');

    foreach ($selected as $id_pendonor) {
        $id_pendonor = intval($id_pendonor);
        $cek = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE id_jadwal='$id_jadwal' AND id_pendonor='$id_pendonor'");
        if (mysqli_num_rows($cek) == 0) {
            mysqli_query($conn, "INSERT INTO pendaftaran (id_pendonor, id_jadwal, waktupendaftaran) VALUES ('$id_pendonor', '$id_jadwal', '$now')");
        }
    }
    echo "<script>alert('Pendaftaran berhasil.'); window.location='a_lihat_pendaftaran_pendonor.php?id_jadwal=$id_jadwal';</script>";
    exit();
}

$pendonor = mysqli_query($conn, "
    SELECT * FROM pendonor 
    WHERE id_pendonor NOT IN (
        SELECT id_pendonor FROM pendaftaran WHERE id_jadwal = '$id_jadwal'
    )
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pendaftaran</title>
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
                document.querySelector('#user-btn').onclick = () => { profile.classList.toggle('active'); };
                document.querySelector('#profile-img').onclick = () => { profile.classList.toggle('active'); };
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

    <section class="events">
        <h1 class="heading">Tambah Pendaftaran Pendonor</h1>
        <form method="POST">
            <?php if (mysqli_num_rows($pendonor) > 0): ?>
                <table>
                    <tr>
                        <th>Pilih</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Golongan Darah</th>
                        <th>Tanggal Lahir</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($pendonor)): ?>
                        <tr>
                            <td><input type="checkbox" name="pendonor[]" value="<?php echo $row['id_pendonor']; ?>"></td>
                            <td><?php echo $row['nik_pendonor']; ?></td>
                            <td><?php echo $row['nama_pendonor']; ?></td>
                            <td><?php echo $row['email_pendonor']; ?></td>
                            <td><?php echo $row['golongandarah_pendonor']; ?></td>
                            <td><?php echo $row['tanggallahir_pendonor']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <br>
                <button type="submit" class="add-contact-btn">Simpan Pendaftaran</button>
            <?php else: ?>
                <p>Tidak ada pendonor yang tersedia.</p>
            <?php endif; ?>
        </form>
    </section>

    <script src="js/script.js"></script>
</body>
</html>
