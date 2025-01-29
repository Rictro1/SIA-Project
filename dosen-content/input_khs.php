<?php
session_start();
include '../database/koneksi.php';

$dosen_id = $_SESSION['dosen_id'];

$success_message = "";
$error_message = "";

$sql_filter = "SELECT DISTINCT semester, kelas, program_studi FROM data_mhs";
$result_filter = $conn->query($sql_filter);

$semester = '';
$kelas = '';
$program_studi = '';

if (isset($_POST['filter'])) {
    $semester = $_POST['semester'];
    $kelas = $_POST['kelas'];
    $program_studi = $_POST['program_studi'];
}

$sql_mhs = "SELECT mhs_id, mhs_name FROM data_mhs WHERE 1=1";

if (!empty($semester)) $sql_mhs .= " AND semester = '$semester'";
if (!empty($kelas)) $sql_mhs .= " AND kelas = '$kelas'";
if (!empty($program_studi)) $sql_mhs .= " AND program_studi = '$program_studi'";

$result_mhs = $conn->query($sql_mhs);

$sql_matkul = "SELECT mm.mhs_id, mm.matkul_id, mm.dosen_id 
                FROM mhs_matkul mm 
                WHERE mm.dosen_id = '$dosen_id'";
$result_matkul = $conn->query($sql_matkul);

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['filter'])) {
    $mhs_id = $_POST['mhs_id'];
    $matkul_id = $_POST['matkul_id'];
    $tugas_quiz = $_POST['tugas_quiz'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];

    $sql_mhs_name = "SELECT mhs_name FROM data_mhs WHERE mhs_id = '$mhs_id'";
    $result_mhs_name = $conn->query($sql_mhs_name);
    $mhs_name = $result_mhs_name->fetch_assoc()['mhs_name'];

    $sql_matkul_name = "SELECT matkul_name FROM mhs_matkul WHERE matkul_id = '$matkul_id'";
    $result_matkul_name = $conn->query($sql_matkul_name);
    $matkul_name = $result_matkul_name->fetch_assoc()['matkul_name'];

    $sql_dosen_name = "SELECT dosen_name FROM data_dosen WHERE dosen_id = '$dosen_id'";
    $result_dosen_name = $conn->query($sql_dosen_name);
    $dosen_name = $result_dosen_name->fetch_assoc()['dosen_name'];

    $sql_check_dosen_id = "SELECT * FROM data_dosen WHERE dosen_id = '$dosen_id'";
    $result_check_dosen_id = $conn->query($sql_check_dosen_id);

    if ($result_check_dosen_id->num_rows > 0) {
        $insert = "INSERT INTO khs (mhs_id, matkul_id, tugas_quiz, uts, uas, dosen_id, mhs_name, matkul_name, dosen_name) 
                    VALUES ('$mhs_id', '$matkul_id', '$tugas_quiz', '$uts', '$uas', '$dosen_id', '$mhs_name', '$matkul_name', '$dosen_name')";
        if ($conn->query($insert) === TRUE) {
            $success_message = "Nilai berhasil disimpan!";
        } else {
            $error_message = "Terjadi kesalahan saat menyimpan nilai.";
        }
    } else {
        $error_message = "Error: Dosen ID tidak ditemukan.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Nilai</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/alert.css">
    <script type="text/javascript" src="../js/app.js" defer></script>
    <style>
    body {
        font-family: Poppins, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .nilai {
        width: 90%;
        max-width: 700px;
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        animation: fadeSlideIn 0.8s ease-out forwards;
        opacity: 0;
        transform: translateY(50px);
        margin: 20px auto;
    }

    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .nilai h2 {
        font-size: 26px;
        font-weight: bold;
        text-align: center;
        border-bottom: 2px solid black;
        margin-bottom: 20px;
        padding-bottom: 20px;
        background: linear-gradient(to right, #bdbd0c, #F25C00);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-group {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 16px;
        font-weight: bold;
        color: #555;
        flex: 1;
        text-align: left;
    }

    .form-group input, 
    .form-group select {
        flex: 2;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-group input:focus, 
    .form-group select:focus {
        border-color: #F25C00;
        background: #fff;
        box-shadow: 0 0 5px rgba(255, 242, 0, 0.5);
    }

    .form-actions {
        text-align: center;
    }

    .form-actions button {
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

    .form-actions button:hover {
        background: linear-gradient(to right, rgb(213, 213, 34), rgb(255, 200, 0));
        transform: scale(1.05);
    }

    .form-actions button::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: -100%;
        background: rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .form-actions button:hover::after {
    left: 100%;
}
</style>


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
        <a href="input-absen.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18q30 0 58.5 3t55.5 9l-70 70q-11-2-21.5-2H400q-71 0-127.5 17T180-306q-9 5-14.5 14t-5.5 20v32h250l80 80H80Zm542 16L484-282l56-56 82 82 202-202 56 56-258 258ZM400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm10 240Zm-10-320q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Z"/></svg>
          <span>Input Absen</span>
        </a>
      </li>
      <li class="active">
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
<div class="nilai">
    <h2>Input Nilai Mahasiswa</h2>

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

    <form method="post">
        <div class="form-group">
            <label for="semester">Semester:</label>
            <select name="semester" id="semester">
                <option value="">Pilih Semester</option>
                <?php
                while ($row = $result_filter->fetch_assoc()) {
                    echo "<option value='{$row['semester']}' " . ($semester == $row['semester'] ? "selected" : "") . ">{$row['semester']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="kelas">Kelas:</label>
            <select name="kelas" id="kelas">
                <option value="">Pilih Kelas</option>
                <?php
                $result_filter->data_seek(0);
                while ($row = $result_filter->fetch_assoc()) {
                    echo "<option value='{$row['kelas']}' " . ($kelas == $row['kelas'] ? "selected" : "") . ">{$row['kelas']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="program_studi">Program Studi:</label>
            <select name="program_studi" id="program_studi">
                <option value="">Pilih Program Studi</option>
                <?php
                $result_filter->data_seek(0);
                while ($row = $result_filter->fetch_assoc()) {
                    echo "<option value='{$row['program_studi']}' " . ($program_studi == $row['program_studi'] ? "selected" : "") . ">{$row['program_studi']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" name="filter">Filter</button>
        </div>
    </form>

    <form method="post">
        <div class="form-group">
            <label for="mhs_id">Mahasiswa:</label>
            <select name="mhs_id" id="mhs_id">
                <?php
                while ($row = $result_mhs->fetch_assoc()) {
                    echo "<option value='{$row['mhs_id']}'>{$row['mhs_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="matkul_id">Mata Kuliah:</label>
            <select name="matkul_id" id="matkul_id">
                <?php
                while ($row = $result_matkul->fetch_assoc()) {
                    echo "<option value='{$row['matkul_id']}'>Matkul ID: {$row['matkul_id']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="tugas_quiz">Tugas/Quiz:</label>
            <input type="text" name="tugas_quiz" id="tugas_quiz">
        </div>

        <div class="form-group">
            <label for="uts">UTS:</label>
            <input type="text" name="uts" id="uts">
        </div>

        <div class="form-group">
            <label for="uas">UAS:</label>
            <input type="text" name="uas" id="uas">
        </div>

        <div class="form-actions">
            <button type="submit">Simpan</button>
        </div>
    </form>
</div>
</body>
</html>
