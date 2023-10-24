<?php
session_start();
require 'functionsDB.php';

// konfigurasi cookie
if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"]; // username

    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha256', $row["username"])) {
        $_SESSION["login"] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}


if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    // cek username
    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set session
            $_SESSION["login"] = true;

            // set cookie
            if (isset($_POST["remember"])) {
                // buat cookie
                setcookie("id", $row["id"], time() + 3600);
                setcookie("key", hash('sha256', $row["username"]), time() + 3600);
            }

            header("Location: index.php");
            exit;
        }
    }
    $err = true;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="style/style.css" rel="stylesheet">

    <title>Login USS</title>

</head>

<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <form action="" method="post" class="uniqcustom">
            <h1 class="text-center mb-4 text-primary">Log in</h1>

            <?php if (isset($err)) : ?>
            <p style="color: red; font-size: small; margin-bottom: 10px;"> Username/Password Salah!!</p>
            <?php endif; ?>

            <!-- Username input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="username">Username</label>
                <input type="username" name="username" id="username" class="form-control" autofocus required />
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" autofocus required />
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
                <div class="col">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="" id="remember"
                            checked />
                        <label class="form-check-label" for="remember"> Remember me </label>
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <div class="d-md-flex justify-content-md-end">
                <button type="submit" name="login" class="btn btn-primary mb-4">Log in</button>
            </div>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="registrasi.php">Register</a></p>
            </div>

        </form>
    </div>
</body>

</html>