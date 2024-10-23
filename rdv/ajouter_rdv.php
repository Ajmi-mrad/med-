<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../cnx/cnx.php");
}
?>

<?php
require_once '../db/conn.php';
require_once '../db/rdvs.php';
require_once '../db/patients.php';

// print_r($_POST);

if (isset($_POST['ok']) || isset($_POST['cancel'])) {
    if (isset($_POST['ok']) && isset($_POST['nom']) && isset($_POST['heure'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $date_naiss = '01-01-2000';
        $telephone = $_POST['telephone'];
        $adresse = '';
        $nationalite = 'tunisienne';
        $type_id = 'cin';
        $nat_id = '';
        $cnam = '';
        $date = $_POST['heure'];
        
        $num_patient = insert_patient($conn, [
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

        $id = insert_donnees_pat($conn, [
            'num_patient' => $num_patient,
            'date_cons' => $date,
            'poids' => 00,
            'hauteur' => 00,
            'comment' => '',
        ]);

        $date_cons = insert_rdv($conn, [
            'num_patient' => $num_patient,
            'date_cons' => $date,
            'type' => 'rdv',
            'consultation' => ''
        ]);
    }
    header("location: liste_rdvs.php");
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
require_once '../menu.php';
?>
    <div class="container m-5">
        <form method="POST">
        <div class="m-2">
        <button type="submit" name="ok" class="btn btn-outline-primary btn-lg" onclick=tanbih()>Ajouter rdv</button>
        <button type="button" name="cancel" class="btn btn-outline-secondary btn-lg">Annuler</button>
        </div>

        <div>
            <table class="table">
                <thead>
                    <tr>
                        
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>L'heure</th>
                        <th>Téléphone</th>
                     
                    </tr>
                </thead>
                        <td><input type="text" class="form-control" name="nom" placeholder="Tapez le nom" ></td>
                        <td><input type="text" class="form-control" name="prenom" placeholder="Tapez le prenom" ></td>
                        
                        <td>
                            <input type="datetime-local" class="form-control" name ="heure" id="formGroupExampleInput">
                            <i class="fas fa-calendar-alt"></i>
                        </td>

                        <td><input type="text" class="form-control" name="telephone" placeholder="Tapez le numéro telephone" ></td>
                       
                        
            </table>
        </div>
        </form>
    </div>
</body>
<script>
    
function tanbih() {
  if (document.getElementsByName("nom") == '' || document.getElementsByName("prenom") == '' || document.getElementsByName("telephone") =='' ){
      alert("Svp Entrer tous les informations");
  }
    
}
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

</html>