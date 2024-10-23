<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../cnx/cnx.php");
}

require_once '../menu.php';
require_once '../db/conn.php';
require_once '../db/patients.php';
require_once '../db/maladies_chrs.php';

$num_patient = (isset($_GET["num_patient"])) ? intval($_GET["num_patient"]) : intval($_POST["num_patient"]);
// $num_maladie = (isset($_GET["num_maladie"])) ? intval($_GET["num_maladie"]) : intval($_POST["num_maladie"]);
$num_maladie =  isset($_POST["num_maladie"]);

$old_pat = patient_fetch_num($conn, $num_patient);
$old_donnees_pat = patient_fetch_donnees($conn, $num_patient);
$maladie_patient = patient_fetch_maladie($conn, $num_patient, $num_maladie);
// print_r($old_pat);
// print_r($old_donnees_pat);

// print_r($_POST);

if (isset($_POST['ok'])) {
    if (isset($_POST['ok']) && isset($_POST["num_patient"]) && isset($_POST['nom']) && isset($_POST['prenom'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $date_naiss = $_POST['date_naiss'];
        $telephone = $_POST['telephone'];
        $adresse = $_POST['adresse'];
        $nationalite = $_POST['nationalite'];
        $type_id = $_POST['type_id'];
        $nat_id = $_POST['nat_id'];
        $cnam = $_POST['cnam'];

        $poids = doubleval($_POST["poids"]);
        $hauteur = doubleval($_POST["hauteur"]);
        $comment = $_POST["comment"];
        $date = date("Y-m-d");

        update_patient($conn, [
            'num_patient' => $num_patient,
            'nom' => $nom,
            'prenom' => $prenom,
            'date_naiss' => $date_naiss,
            'telephone' => $telephone,
            'adresse' => $adresse,
            'nationalite' => $nationalite,
            'type_id' => $type_id,
            'nat_id' => $nat_id,
            'cnam' => $cnam
        ]);
        $pat = patient_fetch_date($conn, $num_patient, $date);
        if ($pat) {
            update_donnees_pat($conn, [
                'num_patient' => $num_patient,
                'date_cons' => $date,
                'poids' => $poids,
                'hauteur' => $hauteur,
                'comment' => $comment
            ]);
        } else {
            $id = insert_donnees_pat($conn, [
                'num_patient' => $num_patient,
                'date_cons' => $date,
                'poids' => $poids,
                'hauteur' => $hauteur,
                'comment' => $comment
            ]);
        }
    }
    delete_maladie_patient($conn, $num_patient);
    foreach ($_POST['maladie'] as $value) {
        $num_maladie = $value;
        // echo "value : ".$value.'<br/>';
        $mp = insert_maladie_patient($conn, [
            'num_patient' => $num_patient,
            'num_maladie' => $num_maladie
        ]);
    }
    header("location: liste_patients.php");
}
    else if(isset($_POST['cancel'])){
        header("location: liste_patients.php");
    }

    



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>Medecin</title>
</head>

<body>

    <?php

    $categories = liste_categories($conn);

    ?>
    <div class="container m-5">
        <form method="post">
            <h1 style="color: #1c87c9;">Patient</h1>
            <h3 style="color: #19B3D3;">Renseignements personnels</h3>
            <div class="row g-3">
                <div class="col">
                    <input type="text" class="form-control" name="nom" placeholder="Tapez le nom" value="<?= $old_pat['nom'] ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="prenom" placeholder="Tapez le prenom" value="<?= $old_pat['prenom'] ?>">
                </div>
            </div>
            <br>
            <div class="row g-3">
                <div class="col">
                    <input type="text" class="form-control" name="telephone" placeholder="Tapez le numéro telephone" value="<?= $old_pat['telephone'] ?>">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="adresse" placeholder="Tapez l'adresse" value="<?= $old_pat['adresse'] ?>">
                </div>
            </div>
            <br>
            <div class="mb-3">

                <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Date de naissance</label>
                <input type="date" class="form-control" name="date_naiss" id="formGroupExampleInput" value="<?= $old_pat['date_naiss'] ?>" required>
                <i class="fas fa-calendar-alt"></i>
            </div>

            <div class="row g-3">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Poids</label>
                    <input type="text" class="form-control" name="poids" placeholder="Tapez le poids" value="<?= $old_donnees_pat['poids'] ?>">
                </div>
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Hauteur</label>
                    <input type="text" class="form-control" name="hauteur" placeholder="Tapez l'hauteur" value="<?= $old_donnees_pat['hauteur'] ?> ">
                </div>
            </div>
            <br>
            <div class="row g-3">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF;font-weight: bold; ">CNAM</label>
                    <input type="text" class="form-control" name="cnam" placeholder="Tapez le numero de CNAM" value="<?= $old_pat['cnam'] ?>">
                </div>
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF;font-weight: bold;">Nationalité</label>
                    <input type="text" class="form-control" name="nationalite" placeholder="Entre la nationalité" value="<?= $old_pat['nationalite'] ?>">
                </div>
            </div>
            <br>

            <div class="row g-3">
                <div class="col">
                    <select name="type_id" class="form-control" id="autoSizingSelect">
                        <option <?= ($old_pat['type_id'] == 'CIN') ? ' selected' : '' ?>>CIN</option>
                        <option <?= ($old_pat['type_id'] == 'Passeport') ? ' selected' : '' ?>>Passeport</option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="nat_id" placeholder="Enter Le N° Identification" value="<?= $old_pat['nat_id'] ?> ">
                </div>
            </div>
            <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Commentaires</label>
            <div>
                <textarea cols="30" rows="10" class="form-control" name="comment" placeholder="Taper les commentaires..."><?= $old_donnees_pat['comment'] ?></textarea>
                    
                    
            </div>
    </div>
   
    <div class="maladies_chroniques">
        <?php
        foreach ($categories as $index => $categorie) :
        ?>

            <span class="mx-5"><?= $categorie['categorie'] ?></span><br>
            <?php
            $maladies_chrs = patient_fetch_maladie($conn, $num_patient, $categorie['num_categorie']);
            foreach ($maladies_chrs as $index => $maladies_chr) :
            ?>
                <div class="row mb-1">
                    <div class="col-sm-4 offset-sm-1">
                        <input class="form-check-input" type="checkbox" id="<?= $maladies_chr['num_maladie'] ?>" name="maladie[]" value="<?= $maladies_chr['num_maladie'] ?>" <?php if ($maladies_chr['checked'] == 0) {
                                                                                                                                                                                    echo "checked";
                                                                                                                                                                                } ?>><?= $maladies_chr['maladie'] ?>
                        <br>
                    </div>
                </div>

            <?php
            endforeach;
            ?>

        <?php
        endforeach;
        ?>
        <input type="hidden" name="num_patient" value="<?= $num_patient ?>">
    </div>
    
    <div class="btn-block mx-5">
        <button type="submit" name="ok" class="btn btn-outline-primary btn-lg">Enregistrer</button>
        <button type="submit" name="cancel" class="btn btn-outline-secondary btn-lg">Annuler</button>
    </div>
    </form>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

</html>