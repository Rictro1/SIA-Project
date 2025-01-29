<?php
session_start();

include('../database/koneksi.php');

if (isset($_POST['login'])) {
  if (isset($_POST['dosen_id']) && isset($_POST['password'])) {
      $dosen_id = $_POST['dosen_id'];
      $password = $_POST['password'];

    $sql = "SELECT dosen_id, dosen_name FROM data_dosen WHERE dosen_id = '$dosen_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $dosen = $result->fetch_assoc();
        
        $_SESSION['dosen_id'] = $dosen['dosen_id'];
        $_SESSION['dosen_name'] = $dosen['dosen_name'];

        header("Location: ../dosen-content/main.php");
        exit();
    } else {
        echo '<script>alert("ID atau password salah!");</script>';
    }
}
}

if (isset($_POST['login'])) {
    $admin_id = $_POST['admin_id'];
    $password = $_POST['password'];

    $sql = "SELECT admin_id, admin_name FROM data_admin WHERE admin_id = '$admin_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['admin_name'];

        header("Location: ../admin-content/main.php");
        exit();
    } else {
        echo '<script>alert("ID atau password salah!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Dosen / Admin Log Form</title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'><link rel="stylesheet" href="../css/adm_dsn.css">
  <script type="text/javascript" src="../js/dosen.js"></script>

</head>
<body>
<p class="tip"></p>
<div class="cont">
    <div class="form sign-in">
      <h2>Dosen Login</h2>
      <form method="post" action="" id="sign_in_form">
        
        <label id="dosen_id">
          <span>ID Dosen</span>
          <input type="id" name="dosen_id" ><br>
        </label>
        <label>
          <span>Password</span>
          <input type="password" name="password" placeholder="**********"  />
        </label>
        <button type="submit" name="login" class="btn animation" onclick="window.location.href='../dosen-content/main.php';">Login</button>
      </form>
    </div>
      

  <div class="sub-cont">
    <div class="img">
      <div class="img__text m--up">
        <h2>Login ke Admin?</h2>
        <h2>Klik Button Dibawah</h2>
      </div>
      <div class="img__text m--in">
      <h2>Login ke Dosen?</h2>
      <h2>Klik Button Dibawah</h2>
      </div>
      <div class="img__btn">
        <span class="m--up">Admin</span>
        <span class="m--in">Dosen</span>
      </div>
    </div>
    <div class="form sign-up">
      <h2>Admin Login</h2>
      <form method="post" action=""  id="sign_in_form">     
        <label>
          <span>ID Admin</span>
            <input type="id" name="admin_id" ><br>
        </label>
        <label>
          <span>Password</span>
          <input type="password" name="password"  placeholder="**********" > <br>
        </label>
        <button type="submit" name="login" class="btn animation" onclick="window.location.href='../admin-content/main.php';">Login</button>
        
      </form>
    </div>
  </div>
</div>

<a class="icon-link">
  <img src="https://www.medipol.edu.tr/medium/GalleryImage-Image-41.vsf">
</a>
  <script type="text/javascript" src="../js/log-btn.js"></script>
</body>
</html>

