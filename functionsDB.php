<?php
error_reporting(0);
// koneksi ke mysql DB
$conn = mysqli_connect("localhost", "root", "", "mahasiswa");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function tambah($post)
{
    global $conn;
    $nama = htmlspecialchars($post["nama"]);
    $nim = htmlspecialchars($post["nim"]);
    $email = htmlspecialchars($post["email"]);
    $jurusan = htmlspecialchars($post["jurusan"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO mahasiswa VALUES
            ('', '$nama', '$nim', '$email', '$jurusan', '$gambar');";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn); // mengembalikan nilai 1/-1
}


function upload()
{
    // variable $_FILES bernilai array 2 dimensi
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];

    // cek apakah ada gambar yang di upload atau tidak
    if ($error === 4) {
        echo "<script>
                alert('Silahkan Pilih Gambar Terlebih Dahulu');
                document.location.href = '';
            </script>";
        return false;
    }

    // cek apakah yang diupload itu gambar atau tidak
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile); // = namafile . ekstensi
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Ekstensi file tidak sesuai, silahkan pilih file lain');
                document.location.href = '';
            </script>";
        return false;
    }

    // cek ukuran file
    if ($ukuranFile > 2000000) { // byte
        echo "<script>
                alert('Ukuran File Terlalu Besar');
                document.location.href = '';
            </script>";
        return false;
    }

    // lolos pengecekan, siap di upload
    $namaFileBaru = uniqid();
    $namaFileBaru .= ".";
    $namaFileBaru .= $ekstensiGambar; // namafilebaru.ekstensi

    move_uploaded_file($tmpName, 'img-db/' . $namaFileBaru);
    return $namaFileBaru;
}


function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}


function ubah($post)
{
    global $conn;
    $id = $post["id"];
    $nama = htmlspecialchars($post["nama"]);
    $nim = htmlspecialchars($post["nim"]);
    $email = htmlspecialchars($post["email"]);
    $jurusan = htmlspecialchars($post["jurusan"]);
    $gambarLama = htmlspecialchars($post["gambarLama"]);

    // cek apakah ada perubahan gambar atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE mahasiswa SET
                nama = '$nama',
                nim = '$nim',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
                WHERE id = $id
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn); // mengembalikan nilai 1/-1
}


function registrasi($post)
{
    global $conn;
    $username = stripslashes($post["username"]);
    $password = mysqli_real_escape_string($conn, $post["password"]);
    $password2 = mysqli_real_escape_string($conn, $post["password2"]);

    // cek username sudah digunakan atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username Sudah Digunakan');
                document.location.href = '';
            </script>
            ";
        return false;
    }

    // cek verifikasi password
    if ($password !== $password2) {
        echo "<script>
                alert('Verifikasi password tidak sesuai');
                document.location.href = '';
            </script>
            ";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // query users ke table database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password');");
    return mysqli_affected_rows($conn);
}



// cek search
if (isset($_POST["search"])) {
    $keyword = $_POST["keyword"];
    $_SESSION["keyword"] = $keyword;
} else {
    $keyword = $_SESSION["keyword"];
}

$query = mysqli_query(
    $conn,
    "SELECT * FROM mahasiswa WHERE
        nama LIKE '%$keyword%' OR
        nim LIKE '%$keyword%' OR
        email LIKE '%$keyword%' OR
        jurusan LIKE '%$keyword%'"
);