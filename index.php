<?php
// memunculkan error
// if (!$result) {
//     echo mysqli_error($conn);
// }

// ambil data (fetch) mahsiswa dari object result :
// mysqli_fetch_row() --> array numerik
// mysqli_fetch_assoc() --> array associative
// mysqli_fetch_array() --> array numerik dan associative
// mysqli_fetch_object()

// while ($mhs = mysqli_fetch_assoc($result)) {
//     var_dump($mhs);
// }

session_start();
require "functionsDB.php";

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


// konfigurasi pagination
$jumlahDataPerPage = 5;
$banyakData = mysqli_num_rows($query);
$jumlahPage = ceil($banyakData / $jumlahDataPerPage); // dibulatkan keatas
// cek halaman yang sedang aktif
$activePage = (isset($_GET["page"])) ? $_GET["page"] : 1; // operator ternary
$dataIndex = ($jumlahDataPerPage * $activePage) - $jumlahDataPerPage;


// ambil data dari tabel user
$id = $_COOKIE["id"];

$result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
$row = mysqli_fetch_assoc($result);


// mengambil data dari tabel mahasiswa / query data mahasiswa
$mahasiswa = query("SELECT * FROM mahasiswa WHERE
            nama LIKE '%$keyword%' OR
            nim LIKE '%$keyword%' OR
            email LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%'
            
            LIMIT $dataIndex, $jumlahDataPerPage");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Data Mahasiswa</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container-fluid navv py-2">
            <p class="h5 text-light d-flex align-items-center justify-center mb-0"><span><img src="img-style/pngegg.png"
                        class="img me-2"></span> Universitas Suka Suka</p>
            <div class="d-flex mergecol">
                <div class="flex-row navbar-nav align-items-center justify-content-center navbar-white-50 fontcustom">
                    <li><a class="pe-3 nav-link active" aria-current="page" href="#">Dashboard</a></li>
                    <li><a class="pe-3 nav-link" href="#">About</a></li>
                    <li><a class="nav-link" href="#">Home</a></li>
                </div>

                <div class="d-flex align-items-center fontcustom">
                    <a class="pe-2 nav-link disabled" href="#" aria-disabled="true"> | <?= $row["username"]; ?></a>
                    <img src="img-style/default-profile-pic-e1513291410505.jpg" class="img2" alt="">
                </div>
            </div>
        </div>
    </nav>


    <div class="d-flex flex-wrap justify-content-center align-items-center">
        <div class="justify-content-center align-items-center allin">

            <h2 class="mt-4 mb-1 text-center">Data Mahasiswa</h2>
            <p class="text-center">Universitas Suka Suka</p>
            <div class=" my-4">
                <a class="btn btn-success" href="tambah.php" role="button">
                    <span><i class="fa-solid fa-plus"></i></span> Tambah Data
                </a>
                <a class="btn btn-danger mx-1" href="logout.php" role="button"
                    onclick="return confirm('Logout?')">Logout</a>
            </div>

            <!-- input group -->
            <form action="" method="post">
                <div class="input-group mb-4">
                    <input type="text" name="keyword" class="form-control" id="keyword"
                        placeholder="Masukkan kata kunci" autocomplete="off" autofocus>
                    <button class="btn btn-primary" type="submit" name="search">Search</button>
                </div>
            </form>

            <!-- table data mahasiswa -->
            <div class="my-custom-scrollbar my-custom-scrollbar-primary" id="container">
                <table class="table table-striped table-hover">
                    <tr class="table-dark">
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Email</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>

                    <?php $i = 1;
                    foreach ($mahasiswa as $mhs) : ?>
                    <tr>
                        <td><?= $i + $dataIndex . '.'; ?></td>
                        <td><img src="img/<?= $mhs["gambar"] ?>" alt="" class="img"></td>
                        <td><?= strtoupper($mhs["nama"]) ?></td>
                        <td><?= $mhs["nim"] ?></td>
                        <td><?= $mhs["email"] ?></td>
                        <td><?= ucwords($mhs["jurusan"]) ?></td>
                        <td>
                            <!-- edit button -->
                            <a class="btn btn-success mt-1" href="ubah.php?id=<?= $mhs["id"]; ?>" role="button"
                                title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <!-- delete button -->
                            <a class="btn btn-danger mt-1" href="hapus.php?id=<?= $mhs["id"]; ?>" role="button"
                                title="Delete" onclick="return confirm('Yakin Ingin Menghapus Data?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <?php $i++ ?>
                    <?php endforeach; ?>
                </table>
            </div>

            <!-- pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center my-3 mb-5">
                    <?php if ($activePage > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $activePage - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $jumlahPage; $i++) : ?>
                        <?php if ($i == $activePage) : ?>
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i ?></a>
                            </li>
                            <?php else : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor ?>

                    <?php if ($activePage < $jumlahPage) : ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $activePage + 1; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

        </div>
    </div>



    <script>
    var myCustomScrollbar = document.querySelector('.my-custom-scrollbar');
    var ps = new PerfectScrollbar(myCustomScrollbar);

    var scrollbarY = myCustomScrollbar.querySelector('.ps__rail-y');

    myCustomScrollbar.onscroll = function() {
        scrollbarY.style.cssText =
            `top: ${this.scrollTop}px!important; height: 400px; right: ${-this.scrollLeft}px`;
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>


</body>

</html>