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

$conn = mysqli_connect('localhost', 'root', '', 'donor_darah');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Fetch user details
$sql = "SELECT * FROM admin WHERE email_admin='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $edit_id = $row['id_admin'];
    $edit_nama = $row['nama_admin'];
    $edit_foto = $row['foto_admin'];
    $edit_email = $row['email_admin'];
    $edit_sandi = $row['sandi_admin'];
} else {
    echo "<p>Profil tidak ditemukan.</p>";
    exit;
}

// Update profile
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id_admin'];
    $nama = sanitize($_POST['nama_admin']);
    $email = sanitize($_POST['email_admin']);
    $sandi = sanitize($_POST['sandi_admin']);
    $foto = sanitize($_POST['foto_admin']);
    $foto_dir = "uploads/"; // Direktori penyimpanan foto
    $foto_path = $foto_dir . $foto;

    $sql = "UPDATE admin SET nama_admin='$nama', foto_admin='$foto_path',email_admin='$email', sandi_admin='$sandi' WHERE id_admin='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<p>Profil berhasil diperbarui.</p>";
        $_SESSION['nama_admin'] = $nama;
        $_SESSION['foto_admin'] = $foto_path;
        header("Location: a_beranda.php");
        exit();
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <header class="header">
            <section class="flex">
            <a href="a_beranda.php" class="logo">BLOOD UNITY: SISTEM INFORMASI PENDONORAN DARAH</a>

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

        <section class="update">
            <div class="row mt-50">
                <div class="image">
                    <img src="img/ubah-profil.png" alt="">
                </div>

                <form class="ubah" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <h3>Ubah Profil</h3>
                    <input type="hidden" name="id_admin" value="<?php echo $edit_id; ?>">
                    <input type="text" name="nama_admin" placeholder="Nama" value="<?php echo $edit_nama; ?>" required><br>
                    <input type="file" name="foto_admin" value="<?php echo $edit_foto; ?>" required><br><br>
                    <input type="text" name="email_admin" placeholder="Email" value="<?php echo $edit_email; ?>" required><br>
                    <input type="text" name="sandi_admin" placeholder="Password" value="<?php echo $edit_sandi; ?>" required><br>
                    <input type="submit" name="update" value="Update">
                    <a href="a_beranda.php" class="cancel-btn">Batal</a>
                </form>
            </div>

        </section>

        <script src="js/script.js"></script>
    </body>
</html>
