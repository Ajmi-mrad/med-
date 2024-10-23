<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: index.php");
    die();
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
<?php
    require_once '../menu.php';
    require_once '../db/conn.php';
    require_once '../db/admin.php';

    
    $comptes = liste_compte($conn);    
    // print_r($comptes);
    ?> 

<div class="container m-5">
    <form method ="post" class="d-flex">
       
        <div class="m-2">
           
            <a class="btn btn-primary" href="ajou_compte.php">Ajouter Compte</a>
            <a href="logout.php">Déconnexion</a>
        </div>
    </form>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Type</th>
                        <th>Adresse</th>
                        <th>Mot de passe</th>
                        <th>Opérations</th>
                    </tr>
                </thead>
                <?php
                foreach ($comptes as $index => $compte) :
                ?>
                    <tr>
                        
                        <td><?= $index + 1 ?></td>
                        <td><?= $compte['nom'] ?></td>
                        <td><?= $compte['prenom'] ?></td>
                        <td><?= $compte['type'] ?></td>
                        <td><?= $compte['pseudo'] ?></td>
                        <td><?= $compte['mot_de_passe'] ?></td>
                        <td>
                            <?php if ($compte['id_login'] != $liste_compte['id_login']): ?>
                            <a href="supp_compte.php?id_login=<?= $compte['id_login'] ?>" onclick="return confirm('Tu es sur de supprimer le compte !?');">Supprimer</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </table>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

</html>