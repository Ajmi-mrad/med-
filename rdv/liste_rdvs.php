<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../cnx/cnx.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <title>Medecin</title>
</head>

<body>
    

    <?php
    require_once '../menu.php';
    require_once '../db/conn.php';
    require_once '../db/rdvs.php';

    $date_deb = (isset($_POST['date_deb']) && $_POST['date_deb']) ? $_POST['date_deb'] : date('Y-m-d');
    $date_fin = (isset($_POST['date_fin']) && $_POST['date_fin']) ? $_POST['date_fin'] : date('Y-m-d');
    $rdvs = liste_rdvs_periode($conn , $date_deb , $date_fin);


    // print_r($rdvs);
    ?>
    <div class="container m-5">
        <form method="post">
            <div class="m-2">
                <input type="date" name="date_deb" value="<?= $date_deb ?>" />
                <i class="fas fa-calendar-alt"></i>

                <input type="date" name="date_fin" value="<?= $date_fin ?>" />
                <i class="fas fa-calendar-alt"></i>
                <a class="btn btn-primary" href="ajouter_rdv.php">Ajouter rdv</a>
                <button class="btn btn-primary" type="submit" name="search" style="margin:18px;">Chercher</button>
            </div>

            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>L'heure</th>
                            <th>Téléphone</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    <?php
                    if (count($rdvs) == 0) {
                        echo "<div class=\"text-danger\">Aucun RDV entre le $date_deb et le $date_fin</div>";
                    }
                    echo "Il y' a ".count($rdvs)." rdv(s) dans cette periode";
                    foreach ($rdvs as $index => $rdv) :
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $rdv['nom'] ?></td>
                            <td><?= $rdv['prenom'] ?></td>
                            <td><?= $rdv['date_cons'] ?></td>
                            <td><?= $rdv['telephone'] ?></td>
                            <td>
                                <a href="modif_rdv.php?num_patient=<?= $rdv['num_patient'] ?>">Changer la date</a>
                                <a href="supp_rdv.php?num_patient=<?= $rdv['num_patient'] ?>&date_cons=<?= $rdv['date_cons'] ?>" onclick="return confirm('Tu es sur de supprimer le rdv !?');">Supprimer le rdv</a>
                                <a href="cons.php?num_patient=<?= $rdv['num_patient'] ?>">Consultation</a>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </table>
            </div>
        </form>
    </div>
</body>
<script>
    function myFunction() {
        var txt;
        var r = confirm("Tu es sur de supprimer ce patient");
        if (r == true) {
            continue;
            alert("ce patient est supprimé");
        } else {
            return;
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

</html>