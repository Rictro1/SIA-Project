<?php
session_start();
include '../database/koneksi.php';

$dosen_id = $_SESSION['dosen_id'];

$sql = "SELECT dosen_id, dosen_name, jenis_kelamin, tempat_tgl_lahir, alamat, no_hp, email 
        FROM data_dosen 
        WHERE dosen_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $dosen_id);
$stmt->execute();
$result = $stmt->get_result();

$data_dosen = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="../css/sidebar.css">
    <script type="text/javascript" src="../js/app.js" defer></script>
    <style>
        .profile-place {
            width: 80%;
            margin: 20px auto;
            animation: fadeIn 1s ease-in-out;
          }
          
          .profile-card {
            padding: 50px;
            color: black;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
          }

          .profile-card h2 {
            border-bottom: 2px solid black;
            margin-bottom: 20px;
            padding-bottom: 20px;
            background: linear-gradient(to right, #bdbd0c, #F25C00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
          }
          
          .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
          }
          
          .row {
            display: flex;
            padding: 15px 10px;
            margin-bottom: 10px;
            border-radius: 10px;
            transition: background-color 0.3s;
          }
          
          .row:nth-child(odd) {
            background-color: #f8f9fa;
          }
          
          .row:nth-child(even) {
            background-color: #e9ecef;
          }
          
          .row:hover {
            background-color: #e8edd4;
          }
          
          .label {
            width: 40%;
            font-weight: bold;
            color: #495057;
          }
          
          .value {
            width: 60%;
            color: #212529;
          }
          
          .edit-button {
            background: linear-gradient(to right, #bdbd0c, #F25C00);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin: 20px;
            text-decoration: none;
          }

          .edit-button:hover {
            background: linear-gradient(to right,rgb(213, 213, 34),rgb(255, 200, 0));
            transform: scale(1.05);
          }

          .edit-button::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: -100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
          }

          .edit-button:hover::after {
            left: 100%;
          }
          @keyframes fadeIn {
            from {
              opacity: 0;
              transform: translateY(20px);
            }
            to {
              opacity: 1;
              transform: translateY(0);
            }
          }
    </style>
</head>
<body>
<nav id="sidebar">
    <ul>
      <li>
        <img src="../img/kaputama.png">
        <span class="logo">SIA Kaputama</span>
        <button onclick=toggleSidebar() id="toggle-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m313-480 155 156q11 11 11.5 27.5T468-268q-11 11-28 11t-28-11L228-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T468-692q11 11 11 28t-11 28L313-480Zm264 0 155 156q11 11 11.5 27.5T732-268q-11 11-28 11t-28-11L492-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l184-184q11-11 27.5-11.5T732-692q11 11 11 28t-11 28L577-480Z"/></svg>
        </button>
      </li>
      <li>
        <a href="main.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-200h120v-200q0-17 11.5-28.5T400-440h160q17 0 28.5 11.5T600-400v200h120v-360L480-740 240-560v360Zm-80 0v-360q0-19 8.5-36t23.5-28l240-180q21-16 48-16t48 16l240 180q15 11 23.5 28t8.5 36v360q0 33-23.5 56.5T720-120H560q-17 0-28.5-11.5T520-160v-200h-80v200q0 17-11.5 28.5T400-120H240q-33 0-56.5-23.5T160-200Zm320-270Z"/></svg>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="active">
        <a href="account.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
          <span>Account</span>
        </a>
      </li>
      <li>
        <a href="input-absen.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18q30 0 58.5 3t55.5 9l-70 70q-11-2-21.5-2H400q-71 0-127.5 17T180-306q-9 5-14.5 14t-5.5 20v32h250l80 80H80Zm542 16L484-282l56-56 82 82 202-202 56 56-258 258ZM400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm10 240Zm-10-320q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Z"/></svg>
          <span>Input Absen</span>
        </a>
      </li>
      <li>
        <a href="input_khs.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
          <span>Input Nilai</span>
        </a>
      </li>
      <li>
        <a href="fixexam-list.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
          <span>List Ujian Perbaiki</span>
        </a>
      </li>
      <li>
        <a href="onexam-list.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M360-240h440v-107H360v107ZM160-613h120v-107H160v107Zm0 187h120v-107H160v107Zm0 186h120v-107H160v107Zm200-186h440v-107H360v107Zm0-187h440v-107H360v107ZM160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Z"/></svg>
          <span>List Ujian Susulan</span>
        </a>
      </li>
      <li>
        <a href="../index.php?logout=true">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
          <span>Sign Out</span>
        </a>
      </li>
    </ul>
  </nav>
  <div class="profile-place">
        <div class="profile-card">
            <h2>Profil Dosen</h2>
            <p><a href="update-pass.php">Ingin mengganti password? Klik disini</a></p>
            <div class="row">
                <div class="label">ID Dosen</div>
                <div class="value">: <?= htmlspecialchars($data_dosen['dosen_id']) ?></div>
            </div>
            <div class="row">
                <div class="label">Nama Lengkap</div>
                <div class="value">: <?= htmlspecialchars($data_dosen['dosen_name']) ?></div>
            </div>
            <div class="row">
                <div class="label">Jenis Kelamin</div>
                <div class="value">: <?= htmlspecialchars($data_dosen['jenis_kelamin']) ?></div>
            </div>
            <div class="row">
                <div class="label">Tempat/Tanggal Lahir</div>
                <div class="value">: <?= htmlspecialchars($data_dosen['tempat_tgl_lahir']) ?></div>
            </div>
            <div class="row">
                <div class="label">No. Telp</div>
                <div class="value">: <?= htmlspecialchars($data_dosen['no_hp']) ?></div>
            </div>
            <div class="row">
                <div class="label">Email</div>
                <div class="value">: <?= htmlspecialchars($data_dosen['email']) ?></div>
            </div>
            <div class="row">
                <div class="label">Alamat</div>
                <div class="value">: <?= htmlspecialchars($data_dosen['alamat']) ?></div>
            </div>
            <a href="edit-account.php" class="edit-button">EDIT</a>
        </div>
    </div>
</body>
</html>
