<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Daftar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="sign-up">
    <div class="container regis">
        <div class="login form">
            <header>Daftar sebagai pendonor</header>
            <form action="m_daftar.php" method="post" enctype="multipart/form-data">
                <input type="text" placeholder="Nomor Induk Kependudukan" id="nik_pendonor" name="nik_pendonor" required maxlength="50">
                <input type="text" placeholder="Nama" id="nama_pendonor" name="nama_pendonor" required maxlength="50">
                <input type="text" placeholder="Alamat Rumah" id="alamat_pendonor" name="alamat_pendonor" required maxlength="100">
                <input type="date" placeholder="Tanggal lahir" id="tanggallahir_pendonor" name="tanggallahir_pendonor" required>
                <div class="opsi">
                    <select id="jeniskelamin_pendonor" name="jeniskelamin_pendonor" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="opsi">
                    <select id="golongandarah_pendonor" name="golongandarah_pendonor" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
                <input type="email" placeholder="Alamat email" id="email_pendonor" name="email_pendonor" required maxlength="50">
                <input type="password" placeholder="Kata sandi" id="sandi_pendonor" name="sandi_pendonor" required maxlength="50">
                <input type="file" id="foto_pendonor" name="foto_pendonor" required>
                <input type="submit" class="submit-button" value="Daftar">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nik = $_POST['nik_pendonor'];
                $nama = $_POST['nama_pendonor'];
                $ttl = $_POST['tanggallahir_pendonor'];
                $jk = $_POST['jeniskelamin_pendonor'];
                $gd = $_POST['golongandarah_pendonor'];
                $alamat = $_POST['alamat_pendonor'];
                $email = $_POST['email_pendonor'];
                $sandi = $_POST['sandi_pendonor'];

                $foto_dir = "uploads/";
                $foto_path = $foto_dir . basename($_FILES["foto_pendonor"]["name"]);
                $foto_extension = strtolower(pathinfo($foto_path, PATHINFO_EXTENSION));
                $allowed_extensions = array("jpg", "jpeg", "png");

                if (!is_dir($foto_dir)) {
                    mkdir($foto_dir, 0777, true);
                }

                if (!in_array($foto_extension, $allowed_extensions)) {
                    echo "Error: Jenis file foto tidak valid. Hanya file dengan ekstensi JPG, JPEG, dan PNG yang diperbolehkan.";
                } elseif ($_FILES["foto_pendonor"]["size"] > 500000) {
                    echo "Error: Ukuran file foto terlalu besar. Maksimal 500 KB.";
                } elseif (move_uploaded_file($_FILES["foto_pendonor"]["tmp_name"], $foto_path)) {
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "donor_darah";
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $stmt = $conn->prepare("INSERT INTO pendonor (nik_pendonor, nama_pendonor, tanggallahir_pendonor, jeniskelamin_pendonor, golongandarah_pendonor, alamat_pendonor, email_pendonor, sandi_pendonor, foto_pendonor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssss", $nik, $nama, $ttl, $jk, $gd, $alamat, $email, $sandi, $foto_path);

                    if ($stmt->execute()) {
                        echo "New record created successfully";
                        header("Location: m_masuk.php");
                        exit();
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    $stmt->close();
                    $conn->close();
                } else {
                    echo "Error: Terjadi kesalahan saat mengunggah file foto.";
                }
            }
            ?>

            <div class="ask">
                <span class="ask">Sudah memiliki akun?
                <a href="m_masuk.php">Masuk</a>
                </span>
            </div>
        </div>
    </div>
</body>
</html>
