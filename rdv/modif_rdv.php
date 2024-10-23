
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


$num_patient = (isset($_GET["num_patient"])) ? intval($_GET["num_patient"]) : intval($_POST["num_patient"]);
// $date_cons = (isset($_GET["date_cons"])) ? is_bool($_GET["date_cons"]) : is_bool($_POST["date_cons"]);

$old_pat = patient_fetch_num($conn, $num_patient);
$old_rdv = patient_fetch_date_rdv($conn, $num_patient);


// echo gettype($date_cons);

if (isset($_POST['ok']) || isset($_POST['cancel'])) {
    if (isset($_POST['ok']) && isset($_POST['heure'])) {
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
        $odate = $_POST['oheure'];
        // $dbInsertDate = date("Y-m-d H:i:s", strtotime($date));
        $consultation = '';
        $type = 'rdv';

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

        update_cons($conn, [
            'num_patient' => $num_patient,
            'ndate_cons' => $date,
            'consultation' => $consultation,
            'type' => $type,
            'odate_cons' => $odate
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>Medecin</title>
</head>

<body>
<?php
    require_once '../menu.php';
?>
    <div class="container m-5">
        <form method="post">
            <div class="m-2">
                <button type="submit" name="ok" class="btn btn-outline-primary btn-lg" onclick=tanbih()>Modifier rdv</button>
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
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    
                    <td><input type="text" class="form-control" name="nom" placeholder="Tapez le nom"value="<?= $old_pat['nom'] ?>" ></td>
                    <td><input type="text" class="form-control" name="prenom" placeholder="Tapez le prenom" value="<?= $old_pat['prenom'] ?>" ></td>
                    <td>
                    <input type="datetime-local" class="form-control" name ="heure" id="formGroupExampleInput" value="<?= str_replace(' ', 'T', $old_rdv['date_cons'])?>">
                            <i class="fas fa-calendar-alt"></i>

                        <input type="hidden" name="oheure" value="<?= $old_rdv['date_cons'] ?>">
                    </td>
                    <td><input type="text" class="form-control" name="telephone" placeholder="Tapez le numéro telephone" value="<?= $old_pat['telephone'] ?>">
                    <td><a href="cons.php?num_patient=<?= $rdv['num_patient'] ?>">Consultation</a></td>

                </table>
            </div>
        </form>
    </div>
</body>
<script>
    function tanbih() {
        if (document.getElementsByName("nom") == '' || document.getElementsByName("prenom") == '' || document.getElementsByName("telephone") == '') {
            alert("Svp Entrer tous les informations");
        }

    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

</html>