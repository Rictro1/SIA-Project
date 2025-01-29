<?php
session_start();
include '../database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_matkul'])) {
        $matkul_name = $_POST['matkul_name'];
        $dosen_id = $_POST['dosen_id'];
        $sks = $_POST['sks'];
        $hari = $_POST['hari'];
        $pukul = $_POST['pukul'];

        $sql = "INSERT INTO mata_kuliah (matkul_name, dosen_id, sks, hari, pukul) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiss", $matkul_name, $dosen_id, $sks, $hari, $pukul);
        $stmt->execute();
    }

    if (isset($_POST['edit_matkul'])) {
        $matkul_id = $_POST['matkul_id'];
        $matkul_name = $_POST['matkul_name'];
        $dosen_id = $_POST['dosen_id'];
        $sks = $_POST['sks'];
        $hari = $_POST['hari'];
        $pukul = $_POST['pukul'];

        $sql = "UPDATE mata_kuliah SET matkul_name = ?, dosen_id = ?, sks = ?, hari = ?, pukul = ? WHERE matkul_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siissi", $matkul_name, $dosen_id, $sks, $hari, $pukul, $matkul_id);
        $stmt->execute();
    }

    if (isset($_POST['delete_matkul'])) {
        $matkul_id = $_POST['matkul_id'];

        $sql = "DELETE FROM matkul_list WHERE matkul_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $matkul_id);
        $stmt->execute();
    }
}

$matkul_sql = "SELECT mk.*, dd.dosen_name FROM matkul_list mk JOIN data_dosen dd ON mk.dosen_id = dd.dosen_id";
$matkul_result = $conn->query($matkul_sql);

$dosen_sql = "SELECT dosen_id, dosen_name FROM data_dosen";
$dosen_result = $conn->query($dosen_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mata Kuliah</title>
    <link rel="stylesheet" href="../css/adm_dsn.css">
    <script type="text/javascript" src="../js/app.js" defer></script>
    <style>
        body {
            font-family: Poppins, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-out forwards;
        }

        h2 {
            border-bottom: 2px solid black;
            margin: 60px 0;
            padding-bottom: 20px;
            background: linear-gradient( #bdbd0c, #F25C00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 20px;
        }


        .matkul-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.2);
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.8s ease-out;
        }

        .matkul-table th, .matkul-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease-in-out;
        }

        .matkul-table th {
            background-color:  #F25C00;
            color: #ffffff;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .matkul-table tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }

        .matkul-table tr:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: scale(1.01);
        }

        .matkul-table td:hover {
            background: rgba(255, 255, 255, 0.5);
            color: black;
        }


        .table-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .edit-btn, .delete-btn {
            display: inline-block;
            width: 80px;
            height: 40px;
            padding: 8px 0;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #ffffff;
        }

        .edit-btn {
            background-color: #28a745;
            text-decoration: none;
        }

        .edit-btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .add-btn {
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

        .add-btn:hover {
            background: linear-gradient(to right,rgb(213, 213, 34),rgb(255, 200, 0));
            transform: scale(1.05);
        }

        .add-btn::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: -100%;
            transition: all 0.3s ease;
        }

        .add-btn:hover::after {
            left: 100%;
        }


        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
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
        <a href="edit_data.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
          <span>Edit Data Mhs</span>
        </a>
      </li>
      <li>
        <a href="edit_dosen.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
          <span>Edit Data Dosen</span>
        </a>
      </li>
      <li class="active">
        <a href="matkul_list.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
          <span>Edit List Matkul</span>
        </a>
      </li>
      <li>
        <a href="angket-dsn-list.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M640-120q-33 0-56.5-23.5T560-200v-160q0-33 23.5-56.5T640-440h160q33 0 56.5 23.5T880-360v160q0 33-23.5 56.5T800-120H640Zm0-80h160v-160H640v160ZM80-240v-80h360v80H80Zm560-280q-33 0-56.5-23.5T560-600v-160q0-33 23.5-56.5T640-840h160q33 0 56.5 23.5T880-760v160q0 33-23.5 56.5T800-520H640Zm0-80h160v-160H640v160ZM80-640v-80h360v80H80Zm640 360Zm0-400Z"/></svg>
          <span>Angket Dosen List</span>
        </a>
      </li>
      <li>
        <a href="angket-institusi-list.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M640-120q-33 0-56.5-23.5T560-200v-160q0-33 23.5-56.5T640-440h160q33 0 56.5 23.5T880-360v160q0 33-23.5 56.5T800-120H640Zm0-80h160v-160H640v160ZM80-240v-80h360v80H80Zm560-280q-33 0-56.5-23.5T560-600v-160q0-33 23.5-56.5T640-840h160q33 0 56.5 23.5T880-760v160q0 33-23.5 56.5T800-520H640Zm0-80h160v-160H640v160ZM80-640v-80h360v80H80Zm640 360Zm0-400Z"/></svg>
          <span>Angket Institusi List</span>
        </a>
      </li>
      <li>
        <a href="kritik-saran-list.php">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#F3F3F3"><path d="M120-160v-80h480v80H120Zm520-280q-83 0-141.5-58.5T440-640q0-83 58.5-141.5T640-840q83 0 141.5 58.5T840-640q0 83-58.5 141.5T640-440Zm-520-40v-80h252q7 22 16 42t22 38H120Zm0 160v-80h376q23 14 49 23.5t55 13.5v43H120Zm500-200h40v-160h-40v160Zm20-200q8 0 14-6t6-14q0-8-6-14t-14-6q-8 0-14 6t-6 14q0 8 6 14t14 6Z"/></svg>
          <span>Kritik/Saran List</span>
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
    <div class="container">
        <h2>Data Mata Kuliah</h2>
        <a href="add_matkul.php" class="add-btn">Tambah Mata Kuliah</a>
        <div class="table-wrapper">
            <table class="matkul-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Dosen ID</th>
                        <th>Nama Dosen</th>
                        <th>SKS</th>
                        <th>Hari</th>
                        <th>Pukul</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $matkul_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['matkul_id']) ?></td>
                        <td><?= htmlspecialchars($row['matkul_name']) ?></td>
                        <td><?= htmlspecialchars($row['dosen_id']) ?></td>
                        <td><?= htmlspecialchars($row['dosen_name']) ?></td>
                        <td><?= htmlspecialchars($row['sks']) ?></td>
                        <td><?= htmlspecialchars($row['hari']) ?></td>
                        <td><?= htmlspecialchars($row['pukul']) ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="edit-matkul.php?id=<?= $row['matkul_id'] ?>" class="edit-btn">Edit</a>
                                <form method="post" style="margin: 0;">
                                    <input type="hidden" name="matkul_id" value="<?= $row['matkul_id'] ?>">
                                    <button type="submit" name="delete_matkul" class="delete-btn">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
