<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email_login'];
    $sandi = $_POST['sandi_login'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "donor_darah";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Cek apakah sebagai admin
    $sql_admin = "SELECT * FROM admin WHERE email_admin = '$email' AND sandi_admin = '$sandi'";
    $result_admin = $conn->query($sql_admin);

    if ($result_admin->num_rows > 0) {
        $row = $result_admin->fetch_assoc();
        $_SESSION['email_admin'] = $email;
        $_SESSION['nama_admin'] = $row['nama_admin'];
        $_SESSION['id_admin'] = $row['id_admin'];
        $_SESSION['foto_admin'] = $row['foto_admin'];

        echo "<script>
            alert('Berhasil masuk sebagai Admin');
            window.location.href = 'a_lihat_jadwal.php';
        </script>";
        exit();
    }

    // Cek apakah sebagai pendonor
    $sql = "SELECT * FROM pendonor WHERE email_pendonor = '$email' AND sandi_pendonor = '$sandi'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['email_pendonor'] = $email;
        $_SESSION['nama_pendonor'] = $row['nama_pendonor'];
        $_SESSION['id_pendonor'] = $row['id_pendonor'];
        $_SESSION['foto_pendonor'] = $row['foto_pendonor'];

        echo "<script>
            alert('Berhasil masuk sebagai Pendonor');
            window.location.href = 'm_beranda.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Email atau kata sandi salah!');
            window.location.href = 'm_masuk.php';
        </script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Masuk</title>

    <link rel="stylesheet" href="style.css">
</head>

<body class="sign-in">
    <div class="container">
        <div style="text-align: center; margin-bottom: 2px;">
            <img src="img/pmi.png" width="80" alt="Logo PMI" />
        </div>
        <div class="login form">
            <header>Masuk sebagai pendonor</header>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type="email" placeholder="Alamat email" id="email_login" name="email_login" required maxlength="50">
                <input type="password" placeholder="Kata sandi" id="sandi_login" name="sandi_login" required maxlength="50">
                <input type="submit" class="button" value="Masuk">
            </form>
            
            <div class="ask">
                <span class="ask">Tidak memiliki akun?
                <a href="m_daftar.php">Daftar</a>
                </span>
            </div>
            <div class="ask" style="margin-top: 5px;">
                <a href="a_masuk.php">Atau masuk sebagai admin</a>
            </div>
        </div>
    </div>
</body>
</html>
