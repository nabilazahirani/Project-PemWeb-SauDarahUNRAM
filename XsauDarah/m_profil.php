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

$conn = mysqli_connect('localhost', 'root', '', 'donor_darah');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Fetch user details
$sql = "SELECT * FROM pendonor WHERE email_pendonor='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $edit_id = $row['id_pendonor'];
    $edit_nik = $row['nik_pendonor'];
    $edit_nama = $row['nama_pendonor'];
    $edit_alamat = $row['alamat_pendonor'];
    $edit_tl = $row['tanggallahir_pendonor'];
    $edit_jk = $row['jeniskelamin_pendonor'];
    $edit_gd = $row['golongandarah_pendonor'];
    $edit_sandi = $row['sandi_pendonor'];
    $edit_foto = $row['foto_pendonor'];
} else {
    echo "<p>Profil tidak ditemukan.</p>";
    exit;
}

// Update profile
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id_pendonor'];
    $nik = sanitize($_POST['nik_pendonor']);
    $nama = sanitize($_POST['nama_pendonor']);
    $alamat = sanitize($_POST['alamat_pendonor']);
    $tl = sanitize($_POST['tanggallahir_pendonor']);
    $jk = sanitize($_POST['jeniskelamin_pendonor']);
    $gd = sanitize($_POST['golongandarah_pendonor']);
    $sandi = sanitize($_POST['sandi_pendonor']);

    $foto_path = $edit_foto; // Default to existing photo

    if (isset($_FILES['foto_pendonor']) && $_FILES['foto_pendonor']['error'] == UPLOAD_ERR_OK) {
        $foto_tmp_name = $_FILES['foto_pendonor']['tmp_name'];
        $foto_name = basename($_FILES['foto_pendonor']['name']);
        $foto_dir = "uploads/";
        $foto_path = $foto_dir . $foto_name;

        if (move_uploaded_file($foto_tmp_name, $foto_path)) {
            // Successfully uploaded
        } else {
            echo "<p>Error uploading photo.</p>";
            exit();
        }
    }

    $sql = "UPDATE pendonor SET 
            nik_pendonor='$nik', 
            nama_pendonor='$nama', 
            alamat_pendonor='$alamat', 
            tanggallahir_pendonor='$tl', 
            jeniskelamin_pendonor='$jk', 
            golongandarah_pendonor='$gd', 
            sandi_pendonor='$sandi', 
            foto_pendonor='$foto_path' 
            WHERE id_pendonor='$id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['nama_pendonor'] = $nama;
        $_SESSION['foto_pendonor'] = $foto_path;
        header("Location: m_beranda.php");
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
            <a href="m_beranda.php" class="logo">SauDarah Universitas Mataram</a>

            <div class="icons">
                <div id="user-btn" class="fas fa-user"></div>
                <a href="m_masuk.php">
                    <div class="fas fa-right-from-bracket"></div>
                </a>
            </div>

            <div class="profile">
                <img src="<?php echo $foto; ?>" class="image" alt="">
                <h3 class="name"><?php echo $nama; ?></h3>
                <p class="role"><?php echo $email; ?></p>

                <div class="flex-btn">
                    <a href="m_profil.php" class="option-btn">Ubah Profil</a>
                </div>
            </div>
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

    <section class="update">
        <div class="row">
            <div class="image">
                <img src="img/ubah-profil.png" alt="">
            </div>

            <form class="ubah" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <h3>Ubah Profil</h3>
                <input type="hidden" name="id_pendonor" value="<?php echo $edit_id; ?>">
                <input type="text" name="nik_pendonor" placeholder="NIK" value="<?php echo $edit_nik; ?>" required><br>
                <input type="text" name="nama_pendonor" placeholder="Nama" value="<?php echo $edit_nama; ?>" required><br>
                <input type="text" name="alamat_pendonor" placeholder="Alamat" value="<?php echo $edit_alamat; ?>" required><br>
                <input type="date" name="tanggallahir_pendonor" placeholder="Tanggal Lahir" value="<?php echo $edit_tl; ?>" required><br>
                <div>
                    <p>Jenis Kelamin</p>
                    <select id="jeniskelamin_pendonor" name="jeniskelamin_pendonor" required><br>
                        <option value="<?php echo $edit_jk; ?>"><?php echo $edit_jk; ?></option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <p>Golongan Darah</p>
                    <select id="golongandarah_pendonor" name="golongandarah_pendonor" required><br>
                        <option value="<?php echo $edit_gd; ?>"><?php echo $edit_gd; ?></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
                <input type="text" name="sandi_pendonor" placeholder="Password" value="<?php echo $edit_sandi; ?>" required><br><br>
                <input type="file" name="foto_pendonor" required><br><br>
                <input type="submit" name="update" value="Update">
                <a href="m_beranda.php" class="cancel-btn">Batal</a>
            </form>
        </div>
    </section>

    <script src="js/script.js"></script>
</body>
</html>
