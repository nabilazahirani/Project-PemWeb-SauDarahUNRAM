<?php
    $conn = mysqli_connect('localhost', 'root', '', 'donor_darah');

    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_GET['id_jadwal'])){
        $id = $_GET['id_jadwal'];

        $sql = "DELETE FROM jadwal WHERE id_jadwal='$id'";

        if (mysqli_query($conn, $sql)){
            header("Location: a_lihat_jadwal.php");
            exit;
        }else{
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    }else{
        echo "<p>Invalid request.</p>";
    }
?>