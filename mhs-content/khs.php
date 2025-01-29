<?php
session_start();
include '../database/koneksi.php';

$mhs_id = $_SESSION['mhs_id'];

$sql_mhs = "
    SELECT mhs_id, mhs_name, semester, program_studi
    FROM data_mhs
    WHERE mhs_id = '$mhs_id'
";
$result_mhs = $conn->query($sql_mhs);
$data_mhs = $result_mhs->fetch_assoc();

$sql_khs = "
    SELECT 
        k.matkul_id,
        k.matkul_name,
        k.tugas_quiz,
        k.uts,
        k.uas,
        mm.sks,
        a.nilai AS hadir,
        -- Menghitung total
        (COALESCE(a.nilai, 0) * 0.1 + k.tugas_quiz * 0.2 + k.uts * 0.3 + k.uas * 0.4) AS total,
        -- Menghitung indeks berdasarkan total
        CASE 
            WHEN (COALESCE(a.nilai, 0) * 0.1 + k.tugas_quiz * 0.2 + k.uts * 0.3 + k.uas * 0.4) >= 85 THEN 'A'
            WHEN (COALESCE(a.nilai, 0) * 0.1 + k.tugas_quiz * 0.2 + k.uts * 0.3 + k.uas * 0.4) >= 70 THEN 'B'
            WHEN (COALESCE(a.nilai, 0) * 0.1 + k.tugas_quiz * 0.2 + k.uts * 0.3 + k.uas * 0.4) >= 55 THEN 'C'
            WHEN (COALESCE(a.nilai, 0) * 0.1 + k.tugas_quiz * 0.2 + k.uts * 0.3 + k.uas * 0.4) >= 40 THEN 'D'
            ELSE 'E'
        END AS indeks
    FROM khs k
    JOIN mhs_matkul mm ON k.matkul_id = mm.matkul_id
    LEFT JOIN absensi a ON k.matkul_id = a.matkul_id AND mm.mhs_id = a.mhs_id
    WHERE mm.mhs_id = '$mhs_id'
";

$result_khs = $conn->query($sql_khs);

$khs_data = [];
while ($row = $result_khs->fetch_assoc()) {
    if (!array_key_exists($row['matkul_id'], $khs_data)) {
        $khs_data[$row['matkul_id']] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KHS Report</title>
    <link rel="stylesheet" href="../css/main.css">
    <script type="text/javascript" src="../js/app.js" defer></script>
    <style>


    .khs-card {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.8s ease-in-out;
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
        

    .info-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid black;
        color: #444;
        padding-bottom: 20px;
    }

    .khs-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 0.8s ease-out;
    }
    .khs-table td {
        color: black;
    }

    .khs-table th,
    .khs-table td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease-in-out;
    }

    .khs-table th {
        background-color: #F25C00;
        color: #fff;
    }

    .khs-table tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.1);
    }

    .khs-table tr:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: scale(1.01);
    }

    .khs-table td:hover {
        background: rgba(255, 255, 255, 0.5);
        color: black;
    }

    .btn {
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

    .btn:hover {
        background: linear-gradient(to right,rgb(213, 213, 34),rgb(255, 200, 0));
        transform: scale(1.05);
    }

    .btn::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: -100%;
        background: rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .btn:hover::after {
        left: 100%;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media print {
        .btn {
            display: none;
        }
        .khs-table th{
            color: black;
        }
        .khs-card::after {
            content: "Kartu Hasil Studi - Cetakan Resmi";
            display: block;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .row {
            border-bottom: 2px solid #ddd;
        }
        #sidebar {
            display: none;
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
            <li class="active"><a href="khs.php">KHS</a></li>
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
            <li><a href="angket-dosen.php">Angket Dosen</a></li>
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
    <div class="khs-card">
        <h1>Kartu Hasil Studi (KHS)</h1>
        <div class="info">
            <div class="info-item">
                <div class="row">
                    <div class="label">ID Mahasiswa</div>
                    <div class="value">: <?= $data_mhs['mhs_id'] ?></div>
                </div>
                <div class="row">
                    <div class="label">Nama</div>
                    <div class="value">: <?= $data_mhs['mhs_name'] ?></div>
                </div>
                <div class="row">
                    <div class="label">Semester</div>
                    <div class="value">: <?= $data_mhs['semester'] ?></div>
                </div>
                <div class="row">
                    <div class="label">Program Studi</div>
                    <div class="value">: <?= $data_mhs['program_studi'] ?></div>
                </div>
            </div>
        </div>
        <table class="khs-table">
            <thead>
                <tr>
                    <th>Matkul ID</th>
                    <th>Matkul Name</th>
                    <th>SKS</th>
                    <th>Hadir</th>
                    <th>Tugas & Quiz</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Total</th>
                    <th>Indeks</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($khs_data as $data): ?>
                <tr>
                    <td><?= $data['matkul_id'] ?></td>
                    <td><?= $data['matkul_name'] ?></td>
                    <td><?= $data['sks'] ?></td>
                    <td><?= $data['hadir'] ?></td>
                    <td><?= $data['tugas_quiz'] ?></td>
                    <td><?= $data['uts'] ?></td>
                    <td><?= $data['uas'] ?></td>
                    <td><?= $data['total'] ?></td>
                    <td><?= $data['indeks'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <button id="printButton" class="btn" onclick="window.print()">Cetak</button>
    </div>

    <script>
        // Sembunyikan tombol cetak setelah proses cetak
        window.onafterprint = function () {
            document.getElementById('printButton').style.display = 'none';
        }
    </script>
</body>
</html>
