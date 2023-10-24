<?php
require "../functionsDB.php";

$keyword = $_GET["key"];
$query2 = "SELECT * FROM mahasiswa WHERE
        nama LIKE '%$keyword%' OR
        nim LIKE '%$keyword%' OR
        email LIKE '%$keyword%' OR
        jurusan LIKE '%$keyword%'
        ";

$mahasiswa = query($query2);
?>

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
    foreach ($mahasiswa as $mhs): ?>
        <tr>
            <td><?= $i + $dataIndex . '.'; ?></td>
            <td><img src="img/<?= $mhs["gambar"] ?>" alt="" class="img"></td>
            <td><?= strtoupper($mhs["nama"]) ?></td>
            <td><?= $mhs["nim"] ?></td>
            <td><?= $mhs["email"] ?></td>
            <td><?= ucwords($mhs["jurusan"]) ?></td>
            <td>
                <!-- edit button -->
                <a class="btn btn-success mt-1" href="ubah.php?id=<?= $mhs["id"];?>" role="button" title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>

                <!-- delete button -->
                <a class="btn btn-danger mt-1" href="hapus.php?id=<?= $mhs["id"];?>" role="button" title="Delete" onclick =
                "return confirm('Yakin Ingin Menghapus Data?');">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>

    <?php $i++ ?>
    <?php endforeach; ?>
</table>

