<?php
session_start();

require 'functionsDB.php';

if (isset($_POST["registrasi"])){
    if (registrasi($_POST) > 0){
        echo "
        <script>
            alert('Username Berhasil di Tambahkan');
            document.location.href = 'login.php';
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
    <title>Document</title>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100">

        <form action="" method="post" class="uniqcustom">
            <h1 class="text-center mb-4 text-primary">Sign Up</h1>

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

            <!-- Password verification input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="password2">Password</label>
                <input type="password" name="password2" id="password2" class="form-control" autofocus required />
            </div>

            <!-- Submit button -->
            <div class="d-md-flex justify-content-md-end">
                <button type="submit" name="registrasi" class="btn btn-primary mb-4 justify-content-center align-items-center">Sign Up</button>
            </div>
            
            <!-- login buttons -->
            <div class="text-center">
                <p>Have an account? <a href="login.php">login</a></p>
            </div>

        </form>
    </div>

</body>

</html>