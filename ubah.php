<?php
session_start();

if (!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

require "functionsDB.php";

$id = $_GET["id"];
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

if (isset($_POST["ubah"])){
    // cek apakah berhasil diubah atau tidak
    if (ubah($_POST) > 0){
        echo "
            <script>
                alert('Data Berhasil di Ubah');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal di Ubah');
                document.location.href = 'index.php';
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
    <title>Update</title>

</head>

<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100">

        <form action="" method="post" enctype="multipart/form-data" class="uniqcustom-insert">
            <h1 class="text-center mb-4 text-primary">Ubah Data Mahasiswa</h1>

            <input type="hidden" name="id" value="<?= $mhs["id"];?>">
            <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"];?>">

            <!-- nama input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= ucwords($mhs["nama"]);?>" required />
            </div>

            <!-- nim input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="nim">NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" value="<?= $mhs["nim"];?>" required />
            </div>

            <!-- email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control" value="<?= $mhs["email"];?>" required />
            </div>

            <!-- jurusan input -->
            <label class="form-label" for="jurusan">Jurusan</label>
            <div class="input-group mb-3">
                <select class="form-select" name="jurusan" id="jurusan" required>
                    <option hidden><?= ucwords($mhs["jurusan"]);?></option>
                    <option value="teknik mesin">Teknik Mesin</option>
                    <option value="teknik industri">Teknik Industri</option>
                    <option value="teknik elektro">Teknik Elektro</option>
                    <option value="ilmu komputer">Ilmu Komputer</option>
                    <option value="ilmu komunikasi">Ilmu Komunikasi</option>
                    <option value="broadcasting">Broadcasting</option>
                </select>
            </div>

            <!-- upload foto -->
            <div class="input-group mb-3">
                <label class="input-group-text" for="gambar">Upload foto</label>
                <input type="file" name="gambar" class="form-control" id="gambar">
            </div>

            <!-- Submit button -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <a class="btn btn-danger me-md-1" href="index.php" role="button">kembali</a>
                <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
            </div>

        </form>
    </div>

</body>

</html>