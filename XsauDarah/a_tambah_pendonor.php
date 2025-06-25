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
        <title>Tambah Pendonor</title>
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
                <a href="a_index.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
                <a href="a_lihat_jadwal.php"><i class="fas fa-calendar-alt"></i><span>Jadwal Donor</span></a>
                <a href="a_lihat_pendaftaran_jadwal.php"><i class="fas fa-clipboard-list"></i><span>Pendaftaran</span></a>
                <a href="a_lihat_pendonor.php"><i class="fas fa-user-friends"></i><span>Pendonor</span></a>
                <a href="a_menu_input_donor.php"><i class="fas fa-notes-medical"></i><span>Data Donor</span></a>
                <a href="a_kelola_forum.php"><i class="fas fa-comments"></i><span>Kelola Forum</span></a>
                <a href="a_kelola_riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
            </nav>
        </div>

        <section class="edit">
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
                    $conn = mysqli_connect('localhost', 'root', '', 'donor_darah');

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    function sanitize($data){
                        return htmlspecialchars(stripslashes(trim($data)));
                    }

                    $nik = sanitize($_POST['nik_pendonor']);
                    $nama = sanitize($_POST['nama_pendonor']);
                    $alamat = sanitize($_POST['alamat_pendonor']);
                    $tl = sanitize($_POST['tanggallahir_pendonor']);
                    $jk = sanitize($_POST['jeniskelamin_pendonor']);
                    $gd = sanitize($_POST['golongandarah_pendonor']);
                    $email = sanitize($_POST['email_pendonor']);
                    $sandi = sanitize($_POST['sandi_pendonor']);

                    // Upload foto
                    $foto_dir = "uploads/";
                    $foto_name = basename($_FILES["foto_pendonor"]["name"]);
                    $foto_path = $foto_dir . $foto_name;
                    $foto_ext = strtolower(pathinfo($foto_path, PATHINFO_EXTENSION));
                    $allowed_ext = array("jpg", "jpeg", "png");

                    if (!is_dir($foto_dir)) {
                        mkdir($foto_dir, 0777, true);
                    }

                    if (!in_array($foto_ext, $allowed_ext)) {
                        echo "<p style='color:red;'>Error: Hanya file JPG, JPEG, dan PNG yang diperbolehkan.</p>";
                    } elseif ($_FILES["foto_pendonor"]["size"] > 500000) {
                        echo "<p style='color:red;'>Error: Ukuran file maksimal 500 KB.</p>";
                    } elseif (move_uploaded_file($_FILES["foto_pendonor"]["tmp_name"], $foto_path)) {
                        // Simpan ke database
                        $sql = "INSERT INTO pendonor (nik_pendonor, nama_pendonor, alamat_pendonor, tanggallahir_pendonor, jeniskelamin_pendonor, golongandarah_pendonor, email_pendonor, sandi_pendonor, foto_pendonor)
                                VALUES ('$nik', '$nama', '$alamat', '$tl', '$jk', '$gd', '$email', '$sandi', '$foto_path')";

                        if (mysqli_query($conn, $sql)) {
                            mysqli_close($conn);
                            header("Location: a_lihat_pendonor.php");
                            exit();
                        } else {
                            echo "<p>Error: " . mysqli_error($conn) . "</p>";
                        }
                    } else {
                        echo "<p style='color:red;'>Error: Gagal mengunggah foto.</p>";
                    }
                }
            ?>

            <div class="row mt-35">
  
                <form class="editan" method="POST" action="">
                    <h3>Tambah pendonor</h3>
                    <input type="text" name="nik_pendonor" placeholder="NIK" required><br>
                    <input type="text" name="nama_pendonor" placeholder="Nama" required><br>
                    <input type="text" name="alamat_pendonor" placeholder="Alamat" required><br>
                    <input type="date" name="tanggallahir_pendonor" placeholder="Tanggal Lahir" required><br>
                    <div>
                        <p>Jenis Kelamin</p>
                        <select id="jeniskelamin_pendonor" name="jeniskelamin_pendonor" required maxlength="100">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    
                    <div>
                        <p>Golongan Darah</p>
                        <select id="golongandarah_pendonor" name="golongandarah_pendonor" required maxlength="100">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <input type="text" name="email_pendonor" placeholder="Email" required><br>
                    <input type="text" name="sandi_pendonor" placeholder="Password" required><br>
                    <input type="file" name="foto_pendonor" required><br>
                    <input type="submit" name="add" value="Tambah">
                    <a href="a_lihat_pendonor.php" class="cancel-btn">Batal</a>
                </form>

        </section> 

        <script src="js/script.js"></script>
    </body>
</html>