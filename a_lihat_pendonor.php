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
        <title>Lihat Pendonor</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <header class="header">
            <section class="flex">
            <span class="logo">SauDarah Universitas Mataram</span>
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

        <section class="events">
            <h1 class="heading">pendonor Donor Darah</h1>

            <a href="a_tambah_pendonor.php" class="add-contact-btn">Tambah pendonor</a>

            <?php
                $conn = mysqli_connect('localhost', 'root', '', 'donor_darah');

                if (!$conn){
                    die("Connection failed: " . mysqli_connect_error());
                }
                function sanitize($data){
                    return htmlspecialchars(stripslashes(trim($data)));
                }
                if (isset($_GET['delete'])){
                    $id = $_GET['delete'];

                    $sql = "DELETE FROM pendonor WHERE id_pendonor='$id'";

                    if (mysqli_query($conn, $sql)){
                    }else{
                        echo "<p>Error: " . mysqli_error($conn) . "</p>";
                    }
                }
                $sql = "SELECT * FROM pendonor";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0){
                    echo "<table>";
                    echo "<tr><th>NIK</th><th>Nama</th><th>Alamat</th><th>Tanggal Lahir</th><th>Jenis Kelamin</th><th>Golongan Darah</th><th>Aksi</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>" . $row['nik_pendonor'] . "</td>";
                        echo "<td>" . $row['nama_pendonor'] . "</td>";
                        echo "<td>" . $row['alamat_pendonor'] . "</td>";
                        echo "<td>" . $row['tanggallahir_pendonor'] . "</td>";
                        echo "<td>" . $row['jeniskelamin_pendonor'] . "</td>";
                        echo "<td>" . $row['golongandarah_pendonor'] . "</td>";
                        echo "<td>";
                        echo "<a href='a_edit_pendonor.php?id=" . $row['id_pendonor'] . "' class='edit-btn'>Edit</a> ";
                        echo "<a href='?delete=" . $row['id_pendonor'] . "' class='delete-btn'>Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }else{
                    echo "<p>Tidak ada data ditemukan.</p>";
                }
            ?>
        </section>
            

        <script src="js/script.js"></script>
    </body>
</html>