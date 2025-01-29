<?php
session_start();
include '../database/koneksi.php';

$dosen_id = $_SESSION['dosen_id']; 

$query1 = "SELECT COUNT(DISTINCT mhs_id) AS total_mahasiswa FROM mhs_matkul WHERE dosen_id = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $dosen_id);
$stmt1->execute();
$result1 = $stmt1->get_result();
$data1 = $result1->fetch_assoc();
$total_mahasiswa = $data1['total_mahasiswa'];

$query2 = "SELECT COUNT(DISTINCT mhs_id) AS total_perbaikan FROM ujian_perbaiki WHERE dosen_id = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $dosen_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$data2 = $result2->fetch_assoc();
$total_perbaikan = $data2['total_perbaikan'];

$query3 = "SELECT COUNT(DISTINCT mhs_id) AS total_susulan FROM ujian_susulan WHERE dosen_id = ?";
$stmt3 = $conn->prepare($query3);
$stmt3->bind_param("i", $dosen_id);
$stmt3->execute();
$result3 = $stmt3->get_result();
$data3 = $result3->fetch_assoc();
$total_susulan = $data3['total_susulan'];

$stmt1->close();
$stmt2->close();
$stmt3->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="../css/main.css">
  <script type="text/javascript" src="../js/app.js" defer></script>
  <style>
        .head-text {
          border-bottom: 2px solid black;
          margin: 40px 20px;
          padding-bottom: 20px;
          background: linear-gradient( #bdbd0c, #F25C00);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          text-align: left;
        }
        .all-card {
          display: flex;
          justify-content: space-around;
          align-items: center;
        }

        .info-card {
            width: 250px;
            height: 200px;
            background: rgb(223, 225, 235);
            overflow: hidden;
            border-radius: 20px;
            box-shadow:
                inset 0px 56px 40px #2224,
                inset 0px -56px 40px #fff,
                1px 1px 2px #fff,
                -1px -1px 2px #4442;
        }

        .info-content {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 300%;
            height: 100%;
            transform: translateX(0%);
            animation: anim 5s infinite cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .info-word {
            width: 40%;
            text-align: center;
            color: #333;
            font-size: 20px;
            font-weight: 600;
            text-shadow: 9px 8px 3px #4443;
        }

        @keyframes anim {
        0% {
            transform: translateX(0%);
        }
        20% {
            transform: translateX(0%);
        }
        30% {
            transform: translateX(-33.33%);
        }
        70% {
            transform: translateX(-33.33%);
        }
        80% {
            transform: translateX(-66.66%);
        }
        100% {
            transform: translateX(-66.66%);
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
      <li class="active">
        <a href="main.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M240-200h120v-200q0-17 11.5-28.5T400-440h160q17 0 28.5 11.5T600-400v200h120v-360L480-740 240-560v360Zm-80 0v-360q0-19 8.5-36t23.5-28l240-180q21-16 48-16t48 16l240 180q15 11 23.5 28t8.5 36v360q0 33-23.5 56.5T720-120H560q-17 0-28.5-11.5T520-160v-200h-80v200q0 17-11.5 28.5T400-120H240q-33 0-56.5-23.5T160-200Zm320-270Z"/></svg>
          <span>Dashboard</span>
        </a>
      </li>
      <li>
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
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M360-240h440v-107H360v107ZM160-613h120v-107H160v107Zm0 187h120v-107H160v107Zm0 186h120v-107H160v107Zm200-186h440v-107H360v107Zm0-187h440v-107H360v107ZM160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Z"/></svg>
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
  <main>
    <div class="welcome-text">
        <h1>Hello, <span><?php echo $_SESSION['dosen_name']; ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="m430-500 283-283q12-12 28-12t28 12q12 12 12 28t-12 28L487-444l-57-56Zm99 99 254-255q12-12 28.5-12t28.5 12q12 12 12 28.5T840-599L586-345l-57-56ZM211-211q-91-91-91-219t91-219l120-120 59 59q7 7 12 14.5t10 15.5l148-149q12-12 28.5-12t28.5 12q12 12 12 28.5T617-772L444-599l-85 84 19 19q46 46 44 110t-49 111l-57-56q23-23 25.5-54.5T321-440l-47-46q-12-12-12-28.5t12-28.5l57-56q12-12 12-28.5T331-656l-64 64q-68 68-68 162.5T267-267q68 68 163 68t163-68l239-240q12-12 28.5-12t28.5 12q12 12 12 28.5T889-450L649-211q-91 91-219 91t-219-91Zm219-219ZM680-39v-81q66 0 113-47t47-113h81q0 100-70.5 170.5T680-39ZM39-680q0-100 70.5-170.5T280-921v81q-66 0-113 47t-47 113H39Z"/></svg>
        Selamat datang di Dashboard SIA Kaputama.</h1>
    </div>
    <div class="head-text">
      <h1>Dashboard Dosen</h1>
    </div>
    <div class="all-card">
      <div class="info-card">
        <div class="info-content">
            <div class="info-word">Jumlah Mahasiswa</div>
            <div class="info-word" id="total_mahasiswa">Total : <?= $total_mahasiswa ?></div>
            <div class="info-word">Jumlah Mahasiswa</div>
          </div>
      </div>
      <div class="info-card">
        <div class="info-content">
            <div class="info-word">Mahasiswa Ujian Perbaikan</div>
            <div class="info-word" id="total_perbaikan">Total : <?= $total_perbaikan ?></div>
            <div class="info-word">Mahasiswa Ujian Perbaikan</div>
          </div>
      </div>
      <div class="info-card">
        <div class="info-content">
            <div class="info-word">Mahasiswa Ujian Susulan</div>
            <div class="info-word" id="total_susulan">Total : <?= $total_susulan ?></div>
            <div class="info-word">Mahasiswa Ujian Susulan</div>
          </div>
      </div>
    </div>
  </main>
  <script>
    function updateJumlahData() {
        $.ajax({
            url: 'get_total_data.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $("#total_mahasiswa").text(response.total_mahasiswa);
                $("#total_perbaikan").text(response.total_perbaikan);
                $("#total_susulan").text(response.total_susulan);
            }
        });
    }

    setInterval(updateJumlahData, 5000);
</script>
  </body>
</html>