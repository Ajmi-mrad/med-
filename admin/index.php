<?php
session_start();

if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin') {
    header('location: okhra.php');
} else {
    if (isset($_POST['mp'])) {
        if (md5($_POST['mp']) == '164e9146159ab8a0ef2d69079acdc5b1') {
            $_SESSION['user'] = 'admin';
            header('location: okhra.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <main class="container">
        <form method="post">
            <input type="password" name="mp" class="form-control">
            <button>Connexion</button>
        </form>
    </main>

</body>

</html>