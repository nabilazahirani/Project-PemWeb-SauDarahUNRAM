<?php
session_start();
if (!isset($_SESSION['email_pendonor'])) {
    header("Location: m_masuk.php");
    exit();
}

$email = $_SESSION['email_pendonor'];
$nama = $_SESSION['nama_pendonor'];
$foto = $_SESSION['foto_pendonor'];
$id_pendonor = $_SESSION['id_pendonor']; // pastikan ini sudah diset saat login

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

// Handle tambah komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['isi_komentar'])) {
    $isi_komentar = $conn->real_escape_string($_POST['isi_komentar']);
    $insert_komentar = "INSERT INTO forum_komentar (id_topik, id_pendonor, isi_komentar) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_komentar);
    $stmt->bind_param("iis", $id_topik, $id_pendonor, $isi_komentar);
    $stmt->execute();
    header("Location: m_topik.php?id_topik=$id_topik");
    exit;
}

// Handle hapus komentar
if (isset($_GET['hapus_komentar'])) {
    $id_komentar = intval($_GET['hapus_komentar']);
    $cek_kepemilikan = "SELECT id_komentar FROM forum_komentar WHERE id_komentar = ? AND id_pendonor = ?";
    $stmt = $conn->prepare($cek_kepemilikan);
    $stmt->bind_param("ii", $id_komentar, $id_pendonor);
    $stmt->execute();
    $result_cek = $stmt->get_result();
    if ($result_cek->num_rows > 0) {
        $conn->query("DELETE FROM forum_komentar WHERE id_komentar = $id_komentar");
    }
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
    <title>Detail Topik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <section class="flex">
        <a href="m_beranda.php" class="logo">SauDarah Universitas Mataram</a>
        <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
            <a href="m_masuk.php"><div class="fas fa-right-from-bracket"></div></a>
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

<section class="home">
    <h1 class="heading"><?php echo htmlspecialchars($topik['judul_topik']); ?></h1>
    <div class="boxComment">
        <p ><?php echo nl2br(htmlspecialchars($topik['isi_topik'])); ?></p>
        <p style="font-size: 1rem;"><strong>Dibuat oleh:</strong> <?php echo htmlspecialchars($topik['nama_pendonor']); ?> <br>
        <strong>Tanggal:</strong> <?php echo $topik['tanggal_post']; ?></p>
    </div>

    <h2 class="heading" style="margin-top: 20px;">Komentar</h2>
    <?php while ($komen = $result_komentar->fetch_assoc()): ?>
        <div class="box" style="margin-bottom: 10px;">
            <p font-size: 1rem;><strong><?php echo htmlspecialchars($komen['nama_pendonor']); ?></strong> 
            <small style="color: #888;"><?php echo $komen['tanggal_komentar']; ?></small></p>
            <p style="font-size: 2rem;"><?php echo nl2br(htmlspecialchars($komen['isi_komentar'])); ?></p>
            <?php if ($komen['id_pendonor'] == $id_pendonor): ?>
                <a href="?id_topik=<?php echo $id_topik; ?>&hapus_komentar=<?php echo $komen['id_komentar']; ?>" 
                   class="inline-cancel-comment" 
                   onclick="return confirm('Yakin ingin menghapus komentar ini?')">Hapus</a>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

    <h2 class="heading" style="margin-top: 30px;">Tulis Komentar</h2>
    <form action="" method="post" class="form-buat-topik">
        <textarea name="isi_komentar" rows="5" class="box" required placeholder="Tulis komentar kamu di sini..."></textarea>
        <input type="submit" value="Kirim Komentar" class="inline-btn">
        <a href="m_forum.php" class="inline-btn-cancel">Kembali ke Forum</a>
    </form>
</section>

<script src="js/script.js"></script>
</body>
</html>
                