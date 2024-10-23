<?php
require_once '../db/conn.php';
require_once '../db/admin.php';

$type = "dr";
$liste_compte=select_cord($conn, $type);
// print_r($liste_compte['nom']);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand , text-primary" href="#">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="../patients/liste_patients.php" id="navbarDropdown" role="button" >
                        Patient
                    </a>
            
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../maladies_chrs/liste_mds.php" id="navbarDropdown" role="button" >
                        Maladies Chroniques
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../rdv/liste_rdvs.php" id="navbarDropdown" role="button">
                        Gestion rdv
                    </a>
                    
                </li>

               

                <li class="nav-item">
                    <a class="nav-link" href="../logout.php" id="navbarDropdown" role="button">
                        Déconnexion
                    </a>
                </li>

            </ul>

                
                <input type="text"  class="p-1 mb-1 bg-primary text-white" name="nom" style="border:none;" value="<?= $_SESSION['user']['nom'] ?>" readonly/>
                <input type="text"  class="p-1 mb-1 bg-secondary text-white" style="border:none; "  name="prenom" value="<?= $_SESSION['user']['prenom'] ?>" readonly/>
                <!-- <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Chercher</button> -->
            </form>
        </div>
    </nav>