<?php
session_start();

include('../database/koneksi.php');


if (isset($_POST['login'])) {
    $mhs_id = $_POST['mhs_id'];
    $password = $_POST['password'];

    $sql = "SELECT mhs_id, mhs_name FROM data_mhs WHERE mhs_id = '$mhs_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $mahasiswa = $result->fetch_assoc();
        
        $_SESSION['mhs_id'] = $mahasiswa['mhs_id'];
        $_SESSION['mhs_name'] = $mahasiswa['mhs_name'];

        header("Location: ../mhs-content/main.php");
        exit();
    } else {
        echo '<script>alert("ID atau password salah!");</script>';
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login dan Registrasi</title>
    <link rel="stylesheet" href="../css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <samp class="bg-animate"></samp>
        <samp class="bg-animate2"></samp>
        
        <div class="form-box login">
            <h2 class="animation">Login</h2>
            <form method="POST" action="#">
                <div class="input-box animation" >
                    <input type="text" name="mhs_id" required>
                    <label for="mhs_id">ID</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation">
                    <input type="password" name="password" required>
                    <label for="password">Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" name="login" class="btn animation">Login</button>
            </form>
        </div>
        
        <div class="info-text login">
            <img class="animation" style="--i:0; --j:20" src="../img/kaputama.png">
            <h2 class="animation" style="--i:1; --j:21;">Sistem Informasi Akademik</h2>
            <p class="animation" style="--i:2; --j:22;">Hello! Log in to Access Your Account.</p>
        </div>
</body>
</html>
