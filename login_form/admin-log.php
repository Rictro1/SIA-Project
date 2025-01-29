<?php
session_start();

include('../database/koneksi.php');

if (isset($_POST['login'])) {
    $admin_id = $_POST['admin_id'];
    $password = $_POST['password'];


    $sql = "SELECT admin_id, admin_name FROM data_admin WHERE admin_id = '$admin_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $dosen = $result->fetch_assoc();
        
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['admin_name'];

        header("Location: ../admin-content/main.php");
        exit();
    } else {
        echo '<script>alert("ID atau password salah!");</script>';
    }
}
?>