<?php
session_start();
if (!isset($_SESSION['email_admin'])) {
    header("Location: a_masuk.php");
    exit();
}

$email = $_SESSION['email_admin'];
$nama = $_SESSION['nama_admin'];
$foto = $_SESSION['foto_admin'];

$conn = mysqli_connect("localhost", "root", "", "donor_darah");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// Hapus satu riwayat jika ada parameter ?hapus=
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM riwayat_donor WHERE id_riwayat = $id");
    header("Location: a_kelola_riwayat.php");
    exit();
}

// Hapus semua riwayat jika ada parameter ?hapus_semua=1
if (isset($_GET['hapus_semua'])) {
    mysqli_query($conn, "DELETE FROM riwayat_donor");
    header("Location: a_kelola_riwayat.php");
    exit();
}

// Ambil keyword jika ada
$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$sql = "
    SELECT r.*, p.nama_pendonor, p.golongandarah_pendonor
    FROM riwayat_donor r
    JOIN pendonor p ON r.id_pendonor = p.id_pendonor
    WHERE 
        p.nama_pendonor LIKE '%$keyword%' OR
        p.golongandarah_pendonor LIKE '%$keyword%' OR
        r.id_pendonor LIKE '%$keyword%' OR
        r.tanggal_donor LIKE '%$keyword%' OR
        r.lokasi_donor LIKE '%$keyword%' OR
        r.jumlah_ml LIKE '%$keyword%' OR
        r.keterangan LIKE '%$keyword%'
    ORDER BY r.tanggal_donor DESC
";

$result = mysqli_query($conn, $sql);    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Riwayat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
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
    <h1 class="heading">Kelola Riwayat Donor</h1>

    <form method="get" class="search-form">
        <input style="border-radius: 5px;" type="text" name="search" placeholder=" Cari riwayat..." value="<?php echo htmlspecialchars($keyword); ?>" required>
        <button type="submit" class="edit-btn">Cari</button>
        <a href="a_kelola_riwayat.php" class="delete-btn">Reset</a>
    </form>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "
        <tr>
            <th>ID Pendonor</th>
            <th>Nama</th>
            <th>Golongan Darah</th>
            <th>Tanggal Donor</th>
            <th>Lokasi Donor</th>
            <th>Jumlah (ml)</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id_pendonor'] . "</td>";
            echo "<td>" . htmlspecialchars($row['nama_pendonor']) . "</td>";
            echo "<td>" . htmlspecialchars($row['golongandarah_pendonor']) . "</td>";
            echo "<td>" . htmlspecialchars($row['tanggal_donor']) . "</td>";
            echo "<td>" . htmlspecialchars($row['lokasi_donor']) . "</td>";
            echo "<td>" . $row['jumlah_ml'] . "</td>";
            echo "<td>" . htmlspecialchars($row['keterangan']) . "</td>";
            echo "<td><a href='a_kelola_riwayat.php?hapus={$row['id_riwayat']}' class='delete-btn' onclick=\"return confirm('Yakin ingin menghapus riwayat ini?')\">Hapus</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<div style='margin-top: 10px;'> <a href='a_kelola_riwayat.php?hapus_semua=1' class='delete-btn' onclick=\"return confirm('Yakin ingin menghapus semua riwayat donor?')\">Hapus Semua</a> </div>";
    } else {
        echo "<p><br>Tidak ada data riwayat ditemukan.</p>";
    }

    mysqli_close($conn);
    ?>
</section>

<script src="js/script.js"></script>
</body>
</html>
