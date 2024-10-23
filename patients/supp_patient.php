<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../cnx/cnx.php");
}

require "../db/conn.php";
require_once '../db/patients.php';


$num_patient = (isset($_GET["num_patient"])) ? intval($_GET["num_patient"]) : intval($_POST["num_patient"]);
$num_maladie = (isset($_GET["num_maladie"])) ? intval($_GET["num_maladie"]) : intval($_POST["num_maladie"]);

$old_pat = patient_fetch_num($conn, $num_patient);
$old_donnees_pat = patient_fetch_donnees($conn, $num_patient);
$maladie_patient = patient_fetch_maladie($conn , $num_patient ,$num_maladie);

// if (isset($_POST['num_patient'])) {
    if (isset($_POST['ok'])){

        $num_patient = $_GET['num_patient'];

        $delete = $conn->prepare("DELETE FROM patient WHERE num_patient=:num_patient");
    
        $delete->execute([':num_patient' => $num_patient]);
         header("location: liste_patients.php");
    }

   
// }

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
    require_once '../menu.php';
    require_once '../db/conn.php';
    require_once '../db/patients.php';
    require_once '../db/maladies_chrs.php';

    $patients = liste_patients($conn);
    $categories = liste_categories($conn);
    ?>

    <div class="container m-5">
        <div class="text-danger">Voulez-vous supprimer ce patient</div>

        <form method="post">
            <h1 style="color: #1c87c9;">Patient</h1>
            <h3 style="color: #19B3D3;">Renseignements personnels</h3>
            <!-- <div class="item">
                <div class="name-item">
                    <input type="hidden" name="num_patient" value="<?= $num_patient ?>">
                    <input type="text" name="nom" placeholder="Nom" value="<?= $old_pat['nom'] ?>" disabled/>
                    <input type="text" name="prenom" placeholder="Prénom" value="<?= $old_pat['prenom'] ?>" disabled/>
                    <input type="text" name="telephone" placeholder="Telephone" value="<?= $old_pat['telephone'] ?>" disabled/>
                    <input type="text" name="adresse" placeholder="Adresse" value="<?= $old_pat['adresse'] ?>" disabled/>
                </div>
            </div>
            <div class="item">
                <p>Date de naissance</p>
                <input type="date" name="date_naiss" value="<?= $old_pat['date_naiss'] ?>" disabled />
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="item">
                <div class="name-item">
                    <input type="text" name="poids" placeholder="Poids" disabled/>
                    <input type="text" name="hauteur" placeholder="Hauteur" disabled/>
                    <input type="text" name="cnam" placeholder="CNAM" value="<?= $old_pat['cnam'] ?>" disabled/>
                    <input type="text" name="nationalite" placeholder="Nationalité" value="<?= $old_pat['nationalite'] ?>" disabled/>
                    <select name="type_id" disabled>
                        <option value="CIN" <?= ($old_pat['type_id'] == 'CIN') ? ' selected' : '' ?>>CIN</option>
                        <option value="Passeport" <?= ($old_pat['type_id'] == 'Passeport') ? ' selected' : '' ?>>Passeport</option>
                    </select>
                    <input type="text" name="nat_id" placeholder="N° Identification" value="<?= $old_pat['nat_id'] ?>" disabled />
                </div>
            </div>
            <div class="item">
                <p>Commentaires</p>
                <textarea name="comment" rows="8" disabled></textarea>
            </div> -->
            <div class="row g-3">
                <div class="col">
                    <input type="text" class="form-control" name="nom" placeholder="Tapez le nom" value="<?= $old_pat['nom'] ?>" disabled>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="prenom" placeholder="Tapez le prenom" value="<?= $old_pat['prenom'] ?>" disabled>
                </div>
            </div>
            <br>
            <div class="row g-3">
                <div class="col">
                    <input type="text" class="form-control" name="telephone" placeholder="Tapez le numéro telephone" value="<?= $old_pat['telephone'] ?>" disabled>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="adresse" placeholder="Tapez l'adresse"  value="<?= $old_pat['adresse'] ?>" disabled>
                </div>
            </div>
            <br>
            <div class="mb-3">
                
            <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Date de naissance</label>
                <input type="date" class="form-control" name ="date_naiss" id="formGroupExampleInput"  value="<?= $old_pat['date_naiss'] ?>" disabled >
                <i class="fas fa-calendar-alt"></i>
            </div>
            
            <div class="row g-3">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Poids</label>
                    <input type="text" class="form-control" name="poids" placeholder="Tapez le poids"  value="<?= $old_donnees_pat['poids'] ?>" disabled>
                </div>
                <div class="col">
                <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Hauteur</label>
                    <input type="text" class="form-control" name="hauteur" placeholder="Tapez l'hauteur" value="<?= $old_donnees_pat['hauteur'] ?> "disabled >
                </div>
            </div>
            <br>
            <div class="row g-3">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF;font-weight: bold; ">CNAM</label>
                    <input type="text" class="form-control" name = "cnam" placeholder="Tapez le numero de CNAM"  value="<?= $old_pat['cnam'] ?>" disabled>
                </div>
                <div class="col">
                <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF;font-weight: bold;">Nationalité</label>
                    <input type="text" class="form-control" name ="nationalite" placeholder ="Entre la nationalité" value="<?= $old_pat['nationalite'] ?>"  disabled>
                </div>
            </div>
            <br>

           <div class="row g-3"> 
            <div class="col">
                <select class="form-control" id="autoSizingSelect" disabled>
                    <option selected <?= ($old_pat['type_id'] == 'CIN') ? ' selected' : '' ?> >CIN</option>
                    <option <?= ($old_pat['type_id'] == 'Passeport') ? ' selected' : '' ?>>Passeport</option>
                </select>
            </div>
                <div class="col">
                    <input type="text" class="form-control" name ="nat_id" placeholder="Enter Le N° Identification" value="<?= $old_pat['nat_id'] ?>" disabled>
                </div>
            </div>
            <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Commentaires</label>
                <div>
                <textarea cols="30" rows="10" class="form-control" name="comment" placeholder="Taper les commentaires..." disabled>
                    <?= $old_donnees_pat['comment'] ?>
                    </textarea>
                </div>
            </div>
            <div class="maladies_chroniques">
            <?php
                    foreach ($categories as $index => $categorie) :
                    ?>
                     
                         <span class="mx-5"><?= $categorie['categorie'] ?></span><br>
                             <?php
                                $maladies_chrs = patient_fetch_maladie($conn, $num_patient ,$categorie['num_categorie']);
                                foreach ($maladies_chrs as $index => $maladies_chr) :
                                ?>
                                 <div class="row mb-1">
                                <div class="col-sm-4 offset-sm-1">
                                 <input class="form-check-input" type="checkbox" id="<?= $maladies_chr['num_maladie'] ?>" name="maladie[]" value="<?= $maladies_chr['num_maladie'] ?>" <?php if($maladies_chr['checked']==0){ echo "checked";} ?> disabled><?= $maladies_chr['maladie'] ?>
                                <br>
                                </div>
                                </div>
                                
                             <?php
                                endforeach;
                                ?>
                               
                 <?php
                    endforeach;
                    ?>

            </div>

                <div class="btn-block mx-5">            
                <button type="submit" name="ok" class="btn btn-outline-primary btn-lg">Supprimer</button>
                <button type="button" name="cancel" class="btn btn-outline-secondary btn-lg">Annuler</button>
            
            </div>
        </form>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

</html>