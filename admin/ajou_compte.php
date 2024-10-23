<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: index.php");
    die();
}
?>
<?php
require_once '../db/conn.php';
require_once '../db/admin.php';

// print_r($_POST);

if (isset($_POST['ok']) || isset($_POST['cancel'])) {
    if (isset($_POST['ok']) && isset($_POST['nom']) && isset($_POST['prenom'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['mdp'];
        $type = $_POST['type'];

        $id_login = insert_compte($conn, [
            'nom' => $nom,
            'prenom' => $prenom,
            'pseudo' => $pseudo,
            'mot_de_passe' => $mdp,
            'type' => $type

        ]);
    }
    header("location: okhra.php");
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
    <div class="container m-5">
        <form method="post">
            <h1 style="color: #1c87c9;">Ajouter un compte</h1>
            <hr>
            <div class="row g-3">
                <div class="col">
                    <input type="text" class="form-control" name="nom" placeholder="Tapez le nom">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="prenom" placeholder="Tapez le prenom">
                </div>
            </div>
            <br>
            <div class="row g-3">
                <div class="col">
                    <input type="text" class="form-control" name="pseudo" placeholder="Tapez l'adresse">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="mdp" placeholder="Tapez le mot de passe">
                </div>
            </div>
            <br>
            <div class="mb-3">
                <input type="text" class="form-control" name="type" placeholder="Tapez le type" id="formGroupExampleInput">
            </div>


            <div class="position-relative my-5 ">
                <!-- <div class="position-absolute top-50 start-45"> -->

                <button type="submit" name="ok" class="btn btn-outline-primary btn-lg">Ajouter</button>
                <button type="button" name="cancel" class="btn btn-outline-secondary btn-lg">Annuler</button>

            </div>
            <!-- </div> -->
        </form>
    </div>
</body>

</html>