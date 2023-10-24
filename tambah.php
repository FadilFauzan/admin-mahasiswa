<?php
session_start();

if (!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

require "functionsDB.php";

if (isset($_POST["tambah"])){
    // cek apakah berhasil ditambahkan atau tidak
    if (tambah($_POST) > 0){
        echo "
            <script>
                alert('Data Berhasil di Tambahkan');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal di Tambahkan');
                document.location.href = '';
            </script>
        ";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Insert</title>

</head>

<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100">

        <form action="" method="post" enctype="multipart/form-data" class="uniqcustom-insert">
            <h1 class="text-center mb-4 text-primary">Tambah Data Mahasiswa</h1>

            <!-- nama input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" autofocus required />
            </div>

            <!-- nim input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="nim">NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" autocomplete="off" autofocus required />
            </div>

            <!-- email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" autocomplete="off" autofocus required />
            </div>

            <!-- jurusan input -->
            <label class="form-label" for="jurusan">Jurusan</label>
            <div class="input-group mb-4">
                <select class="form-select" name="jurusan" id="jurusan" autofocus required>
                    <option hidden>Pilih Jurusan</option>
                    <option value="teknik mesin">Teknik Mesin</option>
                    <option value="teknik industri">Teknik Industri</option>
                    <option value="teknik elektro">Teknik Elektro</option>
                    <option value="ilmu komputer">Ilmu Komputer</option>
                    <option value="ilmu komunikasi">Ilmu Komunikasi</option>
                    <option value="broadcasting">Broadcasting</option>
                </select>
            </div>

            <!-- upload foto -->
            <label class="form-label" for="gambar">Foto</label>
            <div class="input-group mb-4">
                <input type="file" name="gambar" class="form-control" id="gambar">
            </div>

            <!-- Submit button -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <a class="btn btn-danger me-md-1" href="index.php" role="button">kembali</a>
                <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
            </div>

        </form>
    </div>
</body>

</html>