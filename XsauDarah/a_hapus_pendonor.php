<?php
    $conn = mysqli_connect('localhost', 'root', '', 'donor_darah');

    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_GET['id_pendonor'])){
        $id = $_GET['id_pendonor'];

        $sql = "DELETE FROM pendonor WHERE id_pendonor='$id'";

        if (mysqli_query($conn, $sql)){
            header("Location: a_lihat_pendonor.php");
            exit;
        }else{
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }
    }else{
        echo "<p>Invalid request.</p>";
    }
?>