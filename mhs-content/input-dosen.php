<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['mhs_id'])) {
    die("Anda harus login terlebih dahulu.");
}

$mhs_id = $_SESSION['mhs_id'];
$success_message = "";
$error_message = "";

if (!isset($_GET['dosen_id']) || !isset($_GET['matkul_name'])) {
    die("Dosen ID atau Mata Kuliah tidak ditemukan.");
}

$dosen_id = $_GET['dosen_id'];
$matkul_name = urldecode($_GET['matkul_name']);
$hari = urldecode($_GET['hari']);
$pukul = urldecode($_GET['pukul']);

$sql = "SELECT dosen_name FROM data_dosen WHERE dosen_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $dosen_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Dosen tidak valid.");
}

$dosen = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $saran = $_POST['saran'] ?? '';

    $aspek = [];
    for ($i = 1; $i <= 12; $i++) {
        $aspek[$i] = $_POST['aspek' . $i] ?? null;
    }

    foreach ($aspek as $key => $value) {
        if ($value === null) {
            die("Aspek ke-$key belum diisi. Silakan lengkapi semua aspek.");
        }
    }

    $sql_mhs_name = "SELECT mhs_name FROM data_mhs WHERE mhs_id = '$mhs_id'";
    $result_mhs_name = $conn->query($sql_mhs_name);
    $mhs_name = $result_mhs_name->fetch_assoc()['mhs_name'];

    $sql_dosen_name = "SELECT dosen_name FROM data_dosen WHERE dosen_id = '$dosen_id'";
    $result_dosen_name = $conn->query($sql_dosen_name);
    $dosen_name = $result_dosen_name->fetch_assoc()['dosen_name'];

    $insert = "INSERT INTO angket_dosen (mhs_id, mhs_name, dosen_id, dosen_name, aspek1, aspek2, aspek3, aspek4, aspek5, aspek6, aspek7, aspek8, aspek9, aspek10, aspek11, aspek12, saran)
              VALUES ('$mhs_id', '$mhs_name', '$dosen_id', '$dosen_name', '$aspek[1]', '$aspek[2]', '$aspek[3]', '$aspek[4]', '$aspek[5]', '$aspek[6]', '$aspek[7]', '$aspek[8]', '$aspek[9]', '$aspek[10]', '$aspek[11]', '$aspek[12]', '$saran')";
    if ($conn->query($insert) === TRUE) {
        $success_message = "Data berhasil disimpan!";
    } else {
        $error_message = "Terjadi kesalahan saat menyimpan data.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angket Dosen</title>
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/alert.css">
    <script type="text/javascript" src="../js/app.js" defer></script>
    <style>
.angket-form {
    max-width: 1200px;
    margin: 50px auto;
    padding: 30px;
    background-color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    animation: fadeIn 1s ease-in-out;
}

.angket-form-title {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 2px solid black;
    background: linear-gradient(to right, #bdbd0c, #F25C00);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
}

.info {
    width: 80%;
    margin: 20px auto;
    animation: fadeIn 1s ease-in-out;
}

.info-item {
    padding: 15px;
    color: black;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.info-row {
    display: flex;
    padding: 15px 10px;
    margin-bottom: 10px;
    border-radius: 10px;
    transition: background-color 0.3s;
}

.info-row:nth-child(odd) {
    background-color: #f8f9fa;
}

.info-row:nth-child(even) {
    background-color: #e9ecef;
}

.info-row:hover {
    background-color: #e8edd4;
}

.info-label {
    width: 40%;
    font-weight: bold;
}

.info-value {
    width: 60%;
    color: #212529;
}

.angket-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    animation: fadeInUp 0.8s ease-out;
}

.angket-table-header {
    background-color: #ff6600;
    color: white;
    text-align: center;
    padding: 10px;
}

.angket-table-row:nth-child(even) {
    background: rgba(255, 255, 255, 0.1);
}

.angket-table-row:hover {
    background: rgba(255, 255, 255, 0.4);
    transform: scale(1.01);
}

.angket-table-cell {
    padding: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease-in-out;
    color: black;
    vertical-align: middle;
}


.angket-table-cell:hover {
    background: rgba(255, 255, 255, 0.5);
    color: black;
}

.radio-group-label {
    display: inline-block;
    width: 20px;
    gap: 10px;
    text-align: center;
    margin: 0;
}

.radio-group-label input[type="radio"] {
    margin: 0 auto;
    display: block;
}

.saran-label {
    font-weight: bold;
    color: black;
}

.saran-textarea {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 20px;
    resize: vertical;
}

.angket-submit-btn {
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
}

.angket-submit-btn:hover {
    background: linear-gradient(to right, rgb(213, 213, 34), rgb(255, 200, 0));
    transform: scale(1.05);
}

.angket-submit-btn::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: -100%;
    background: rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.angket-submit-btn:hover::after {
    left: 100%;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(-30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
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
      <li>
        <a href="account.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Zm80 0h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
          <span>Account</span>
        </a>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M657-121 544-234l56-56 57 57 127-127 56 56-183 183Zm-537 1v-80h360v80H120Zm0-160v-80h360v80H120Zm0-160v-80h720v80H120Zm0-160v-80h720v80H120Zm0-160v-80h720v80H120Z"/></svg>
          <span>Grade</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="krs.php">KRS</a></li>
            <li><a href="khs.php">KHS</a></li>
          </div>
        </ul>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
          <span>Angket</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li class="active"><a href="angket-dosen.php">Angket Dosen</a></li>
            <li><a href="angket-institusi.php">Angket Institusi</a></li>
          </div>
        </ul>
      </li>
      <li>
        <button onclick=toggleSubMenu(this) class="dropdown-btn">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm200-190q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-200v-560 560Z"/></svg>
          <span>Assignment</span>
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M480-361q-8 0-15-2.5t-13-8.5L268-556q-11-11-11-28t11-28q11-11 28-11t28 11l156 156 156-156q11-11 28-11t28 11q11 11 11 28t-11 28L508-372q-6 6-13 8.5t-15 2.5Z"/></svg>
        </button>
        <ul class="sub-menu">
          <div>
            <li><a href="project-akhir.php">Projek Akhir (M)</a></li>
            <li><a href="ujian-perbaiki.php">Ujian Perbaikan (M)</a></li>
            <li><a href="ujian-susulan.php">Ujian Susulan</a></li>
          </div>
        </ul>
      </li>
      <li>
        <a href="kritik.php">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240ZM330-120 120-330v-300l210-210h300l210 210v300L630-120H330Zm34-80h232l164-164v-232L596-760H364L200-596v232l164 164Zm116-280Z"/></svg>
          <span>Kritik dan Saran (M)</span>
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
  <div class="angket-form">
    <h2 class="angket-form-title">Angket Kinerja Dosen</h2>

    <?php if ($success_message): ?>
        <div class="succes-card">
            <svg class="succes-wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L1428.6,320C1417.1,320,1394,320,1371,320C1348.6,320,1326,320,1303,320C1280,320,1257,320,1234,320C1211.4,320,1189,320,1166,320C1142.9,320,1120,320,1097,320C1074.3,320,1051,320,1029,320C1005.7,320,983,320,960,320C937.1,320,914,320,891,320C868.6,320,846,320,823,320C800,320,777,320,754,320C731.4,320,709,320,686,320C662.9,320,640,320,617,320C594.3,320,571,320,549,320C525.7,320,503,320,480,320C457.1,320,434,320,411,320C388.6,320,366,320,343,320C320,320,297,320,274,320C251.4,320,229,320,206,320C182.9,320,160,320,137,320C114.3,320,91,320,69,320C45.7,320,23,320,11,320L0,320Z" fill-opacity="1"></path>
            </svg>
            <div class="succes-icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" stroke-width="0" fill="currentColor" stroke="currentColor" class="succes-icon">
                    <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"></path>
                </svg>
            </div>
            <div class="succes-message-text-container">
                <p class="succes-message-text"><?php echo $success_message; ?></p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15" stroke-width="0" fill="none" stroke="currentColor" class="succes-cross-icon">
                <path fill="currentColor" d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z" clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
        <div class="error-card">
            <svg class="error-wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L1428.6,320C1417.1,320,1394,320,1371,320C1348.6,320,1326,320,1303,320C1280,320,1257,320,1234,320C1211.4,320,1189,320,1166,320C1142.9,320,1120,320,1097,320C1074.3,320,1051,320,1029,320C1005.7,320,983,320,960,320C937.1,320,914,320,891,320C868.6,320,846,320,823,320C800,320,777,320,754,320C731.4,320,709,320,686,320C662.9,320,640,320,617,320C594.3,320,571,320,549,320C525.7,320,503,320,480,320C457.1,320,434,320,411,320C388.6,320,366,320,343,320C320,320,297,320,274,320C251.4,320,229,320,206,320C182.9,320,160,320,137,320C114.3,320,91,320,69,320C45.7,320,23,320,11,320L0,320Z" fill-opacity="1"></path>
            </svg>
            <div class="error-icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" stroke-width="0" fill="currentColor" stroke="currentColor" class="error-icon">
                    <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"></path>
                </svg>
            </div>
            <div class="error-message-text-container">
                <p class="error-message-text"><?php echo $error_message; ?></p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15" stroke-width="0" fill="none" stroke="currentColor" class="error-cross-icon">
                <path fill="currentColor" d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z" clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </div>
        <?php endif; ?>
        
    <div class="info">
        <div class="info-item">
            <div class="row info-row">
                <div class="label info-label">Mata Kuliah</div>
                <div class="value info-value">: <?= htmlspecialchars($matkul_name); ?></div>
            </div>
            <div class="row info-row">
                <div class="label info-label">Hari</div>
                <div class="value info-value">: <?= htmlspecialchars($hari); ?></div>
            </div>
            <div class="row info-row">
                <div class="label info-label">Pukul</div>
                <div class="value info-value">: <?= htmlspecialchars($pukul); ?></div>
            </div>
            <div class="row info-row">
                <div class="label info-label">Nama Dosen</div>
                <div class="value info-value">: <?= htmlspecialchars($dosen['dosen_name']); ?></div>
            </div>
        </div>
    </div>

    <form method="POST" class="angket-form-body">
        <table class="angket-table" border="1">
            <thead>
                <tr>
                    <th class="angket-table-header">Aspek yang Dinilai</th>
                    <th class="angket-table-header">Skala Penilaian</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $aspek = [
                    "Dosen menjelaskan Silabus/SAP dan buku pegangan pada saat pertemuan pertama kuliah",
                    "Kepedulian Dosen membantu kesulitan tentang materi kuliah",
                    "Dosen berusaha menjelaskan bahan kuliah sebagai bekal pengetahuan menghadapi dunia kerja",
                    "Kedisiplinan dosen (tepat waktu dan selesai kuliah)",
                    "Sistematika dan cara penyampaian materi dalam mengajar",
                    "Dosen memberikan kesempatan diskusi dan bertanya kepada mahasiswa tanpa membedakan suku, agama, ras dan golongan",
                    "Kemampuan dosen menanggapi pertanyaan dan pendapat",
                    "Kesesuaian soal yang diujikan dengan bahan ajar yang dipelajari",
                    "Dosen sering memberi tugas/pekerjaan rumah/bahan diskusi",
                    "Apakah dosen dapat memotivasi mahasiswa terhadap materi perkuliahan atau hal-hal lainnya",
                    "Kesesuaian antara materi disilabus dengan bahan yang diajarkan",
                    "Bagaimana kemampuan dosen secara umum dalam mengajar"
                ];
                foreach ($aspek as $index => $text) {
                    echo "<tr class='angket-table-row'>
                            <td class='angket-table-cell'>$text</td>
                            <td class='angket-table-cell'>
                                <label class='radio-group-label'><input type='radio' name='aspek" . ($index + 1) . "' value='SK'> SK </label>
                                <label class='radio-group-label'><input type='radio' name='aspek" . ($index + 1) . "' value='K'> K </label>
                                <label class='radio-group-label'><input type='radio' name='aspek" . ($index + 1) . "' value='C'> C </label>
                                <label class='radio-group-label'><input type='radio' name='aspek" . ($index + 1) . "' value='B'> B </label>
                                <label class='radio-group-label'><input type='radio' name='aspek" . ($index + 1) . "' value='SB'> SB </label>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>

        <p class="saran-label"><strong>Saran untuk Dosen:</strong></p>
        <textarea name="saran" rows="4" cols="50" class="saran-textarea" placeholder="Tuliskan saran Anda di sini..."></textarea>

        <button type="submit" class="btn angket-submit-btn">Kirim Angket</button>
    </form>
</div>

</body>
</html>
