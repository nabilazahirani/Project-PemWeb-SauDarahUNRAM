<?php
session_start();
if (isset($_SESSION['email_admin'])) {
    $email = $_SESSION['email_admin'];
    $nama = $_SESSION['nama_admin'];
    $foto = $_SESSION['foto_admin'];
    $id_admin = $_SESSION['id_admin'];
} else {
    header("Location: a_masuk.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donor_darah";

$conn = new mysqli($servername, $username, $password, $dbname);

$id_topik = $_GET['id_topik'] ?? 0;

// Ambil detail topik
$query_topik = "SELECT ft.*, p.nama_pendonor 
                FROM forum_topik ft 
                JOIN pendonor p ON ft.id_pendonor = p.id_pendonor 
                WHERE ft.id_topik = ?";
$stmt = $conn->prepare($query_topik);
$stmt->bind_param("i", $id_topik);
$stmt->execute();
$result_topik = $stmt->get_result();
$topik = $result_topik->fetch_assoc();

if (!$topik) {
    echo "Topik tidak ditemukan.";
    exit;
}

// Handle tambah komentar (jika admin boleh komentar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['isi_komentar'])) {
    $isi_komentar = $_POST['isi_komentar'];
    $insert_komentar = "INSERT INTO forum_komentar (id_topik, id_pendonor, isi_komentar) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_komentar);
    $stmt->bind_param("iis", $id_topik, $id_admin, $isi_komentar);
    $stmt->execute();
    $stmt->close();
    header("Location: m_topik.php?id_topik=$id_topik");
    exit;
}

// Handle hapus komentar (admin bisa hapus komentar mana saja)
if (isset($_GET['hapus_komentar'])) {
    $id_komentar = intval($_GET['hapus_komentar']);
    $stmt = $conn->prepare("DELETE FROM forum_komentar WHERE id_komentar = ?");
    $stmt->bind_param("i", $id_komentar);
    $stmt->execute();
    $stmt->close();
    header("Location: m_topik.php?id_topik=$id_topik");
    exit;
}

// Ambil komentar
$query_komentar = "SELECT fk.*, p.nama_pendonor 
                   FROM forum_komentar fk 
                   JOIN pendonor p ON fk.id_pendonor = p.id_pendonor 
                   WHERE fk.id_topik = ? 
                   ORDER BY fk.tanggal_komentar DESC";
$stmt = $conn->prepare($query_komentar);
$stmt->bind_param("i", $id_topik);
$stmt->execute();
$result_komentar = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Topik</title>
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
        <a href="a_lihat_jadwal.php"><i class="fas fa-calendar-alt"></i><span>Jadwal Donor</span></a>
        <a href="a_lihat_pendaftaran_jadwal.php"><i class="fas fa-clipboard-list"></i><span>Pendaftaran</span></a>
        <a href="a_lihat_pendonor.php"><i class="fas fa-user-friends"></i><span>Pendonor</span></a>
        <a href="a_menu_input_donor.php"><i class="fas fa-notes-medical"></i><span>Data Donor</span></a>
        <a href="a_kelola_forum.php"><i class="fas fa-comments"></i><span>Kelola Forum</span></a>
        <a href="a_kelola_riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
    </nav>
</div>

<section class="home">
    <h1 class="heading"><?php echo htmlspecialchars($topik['judul_topik']); ?></h1>
    <div class="boxComment">
        <p><?php echo nl2br(htmlspecialchars($topik['isi_topik'])); ?></p>
        <p style="font-size: 1rem;"><strong>Dibuat oleh:</strong> <?php echo htmlspecialchars($topik['nama_pendonor']); ?> <br>
        <strong>Tanggal:</strong> <?php echo $topik['tanggal_post']; ?></p>
    </div>

    <h2 class="heading" style="margin-top: 20px;">Komentar</h2>
    <?php while ($komen = $result_komentar->fetch_assoc()): ?>
        <div class="box" style="margin-bottom: 10px;">
            <p><strong><?php echo htmlspecialchars($komen['nama_pendonor']); ?></strong> 
            <small style="color: #888;"><?php echo $komen['tanggal_komentar']; ?></small></p>
            <p style="font-size: 2rem;"><?php echo nl2br(htmlspecialchars($komen['isi_komentar'])); ?></p>
            <a href="?id_topik=<?php echo $id_topik; ?>&hapus_komentar=<?php echo $komen['id_komentar']; ?>" 
               class="inline-btn-cancel" 
               onclick="return confirm('Yakin ingin menghapus komentar ini?')">Hapus</a>
        </div>
    <?php endwhile; ?>
</section>

<script src="js/script.js"></script>
  
</body>
</html>
