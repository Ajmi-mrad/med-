<?php
session_start();

if (isset($_SESSION['user'])) {
  header('location: ../patients/liste_patients.php');
  die();
}

require_once '../db/conn.php';
require_once '../db/admin.php';

// print_r($_POST);
$message = "";
if (isset($_POST['adresse']) && isset($_POST['mdp'])) {
  $user = login_user($conn, $_POST['adresse'], $_POST['mdp']);
  // count($liste_acc) == 0
  if ($user) {
    $_SESSION['user'] = $user;
    header("location: ../patients/liste_patients.php");
  } else {
    $message = 'Desole les infromations incorrect';
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Connexion</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style_cnx.css">
</head>

<body>
  <div class="main-block">
    <h1>Connexion</h1>
    <form method="post">

      <label id="icon" for="name"><i class="fas fa-user"></i></label>
      <input type="text" name="adresse" placeholder="Adresse" required />

      <label id="icon" for="name"><i class="fas fa-unlock-alt"></i></label>
      <input type="password" name="mdp" placeholder="Mot de passe" required />
      <hr>
      <div class="btn-block">
        <button type="submit" name="">Connexion</button>
      </div>

    </form>

    
  </div>
  <div><?= $message ?></div>
</body>

</html>