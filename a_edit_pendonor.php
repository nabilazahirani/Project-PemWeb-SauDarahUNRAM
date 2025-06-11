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
    <title>Edit Pendonor</title>
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

<section class="edit">
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'donor_darah');
    if (!$conn) die("Connection failed: " . mysqli_connect_error());

    function sanitize($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM pendonor WHERE id_pendonor='$id'";
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
            $edit_email = $row['email_pendonor'];
            $edit_sandi = $row['sandi_pendonor'];
            $edit_foto = $row['foto_pendonor'];
        } else {
            echo "<p>Pendonor tidak ditemukan.</p>";
            exit;
        }
    } else {
        echo "<p>Permintaan tidak valid.</p>";
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id = $_POST['id_pendonor'];
        $nik = sanitize($_POST['nik_pendonor']);
        $nama = sanitize($_POST['nama_pendonor']);
        $alamat = sanitize($_POST['alamat_pendonor']);
        $tl = sanitize($_POST['tanggallahir_pendonor']);
        $jk = sanitize($_POST['jeniskelamin_pendonor']);
        $gd = sanitize($_POST['golongandarah_pendonor']);
        $email = sanitize($_POST['email_pendonor']);
        $sandi = sanitize($_POST['sandi_pendonor']);
        $foto_lama = $edit_foto;
        $foto_final = $foto_lama;

        if (!empty($_FILES['foto_pendonor']['name'])) {
            $foto_baru = $_FILES['foto_pendonor']['name'];
            $ext = pathinfo($foto_baru, PATHINFO_EXTENSION);
            $foto_final = $id . '.' . $ext;
            $target_dir = 'uploads/';
            $target_file = $target_dir . $foto_final;

            if (file_exists($target_dir . $foto_lama) && $foto_lama != '') {
                unlink($target_dir . $foto_lama);
            }

            move_uploaded_file($_FILES["foto_pendonor"]["tmp_name"], $target_file);
        }

        $sql = "UPDATE pendonor SET 
            nik_pendonor='$nik',
            nama_pendonor='$nama',
            alamat_pendonor='$alamat',
            tanggallahir_pendonor='$tl',
            jeniskelamin_pendonor='$jk',
            golongandarah_pendonor='$gd',
            email_pendonor='$email',
            sandi_pendonor='$sandi',
            foto_pendonor='$foto_final'
            WHERE id_pendonor='$id'";

        if (mysqli_query($conn, $sql)) {
            header("Location: a_lihat_pendonor.php");
            exit;
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>

    <div class="row">
        <form class="editan" method="POST" action="" enctype="multipart/form-data">
            <h3>Edit Pendonor</h3>
            <input type="hidden" name="id_pendonor" value="<?php echo $edit_id; ?>">
            <input type="text" name="nik_pendonor" placeholder="NIK" value="<?php echo $edit_nik; ?>" required><br>
            <input type="text" name="nama_pendonor" placeholder="Nama" value="<?php echo $edit_nama; ?>" required><br>
            <input type="text" name="alamat_pendonor" placeholder="Alamat" value="<?php echo $edit_alamat; ?>" required><br>
            <input type="date" name="tanggallahir_pendonor" value="<?php echo $edit_tl; ?>" required><br>

            <p>Jenis Kelamin</p>
            <select name="jeniskelamin_pendonor" required>
                <option value="<?php echo $edit_jk; ?>"><?php echo $edit_jk; ?></option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

            <p>Golongan Darah</p>
            <select name="golongandarah_pendonor" required>
                <option value="<?php echo $edit_gd; ?>"><?php echo $edit_gd; ?></option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="AB">AB</option>
                <option value="O">O</option>
            </select>

            <input type="text" name="email_pendonor" placeholder="Email" value="<?php echo $edit_email; ?>" required><br>
            <input type="text" name="sandi_pendonor" placeholder="Password" value="<?php echo $edit_sandi; ?>" required><br>

            <p>Foto Saat Ini</p>
            <img id="preview" src="uploads/<?php echo $edit_foto; ?>" alt="Foto Pendonor" style="max-width: 150px; margin-bottom:10px;"><br>

            <label for="foto_pendonor">Ganti Foto:</label>
            <input type="file" name="foto_pendonor" id="foto_pendonor" accept="image/*" onchange="previewImage(event)"><br><br>

            <input type="submit" name="update" value="Update">
            <a href="a_lihat_pendonor.php" class="cancel-btn">Batal</a>
        </form>
    </div>
</section>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>
