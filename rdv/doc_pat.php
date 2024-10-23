<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../cnx/cnx.php");
}
require_once "../menu.php";
require_once "../db/conn.php";
require_once "../db/image.php";


$num_patient = (isset($_GET["num_patient"])) ? intval($_GET["num_patient"]) : intval($_POST["num_patient"]);
$status = $statusMsg = '';
if (isset($_POST["submit"])) {
    $status = 'error';
    if (!empty($_FILES["image"]["name"])) {
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));
            $date = date('Y-m-d H:i:s');
            $num_patient = $_POST['num_patient'];

            // Insert image content into database 

            $insert = insert_image($conn, [
                'num_patient' => $num_patient,
                'date_img' => $date,
                'image' => $imgContent

            ]);

            if ($insert) {
                $status = 'Succès';
                $statusMsg = "Fichier téléchargé avec succès.";
            } else {
                $statusMsg = "Échec du téléchargement du fichier, veuillez réessayer.";
            }
        } else {
            $statusMsg = 'Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés à télécharger.';
        }
    } else {
        $statusMsg = 'Veuillez sélectionner un fichier image à télécharger.';
    }
}
echo $statusMsg;

$result = select_img($conn, $num_patient);
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

    <form method="POST" enctype="multipart/form-data">
        <main class="container ">
            <div>
                <input type="hidden" name="num_patient" value="<?= $num_patient ?>">
                <!-- <input type="file" name="image"> -->
                <div class="mb-3">
                    <?php
                    if (count($result) > 0) { ?>
                        <div class="gallery row">
                            <?php foreach ($result as $row) { ?>
                                <div class="col-sm-2 text-center">
                                    <a href="display_image.php?num_image=<?= $row['num_image']?>" target="_blank" rel="noopener noreferrer">
                                        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode(stripslashes($row['image'])); ?>" width="128">
                                        <!--img onmouseover="bigImg(this)" onmouseout="normalImg(this)" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode(stripslashes($row['image'])); ?>" width="128"-->
                                    </a>
                                    <div><?php echo substr($row['date_img'], 0, 11,) ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p class="status error">Image(s) not found...</p>
                    <?php } ?>

                    <label for="formFile" class="form-label">Choisir l'image</label>
                    <input class="form-control" type="file" name="image">
                    <button name="submit" class="btn btn-outline-primary btn-lg my-3"> Enregistrer</button>
                </div>

            </div>
        </main>
        <div class="mx-5">

        </div>

    </form>

    <script>
        function bigImg(x) {
            x.style.height = "600px";
            x.style.width = "800px";
        }

        function normalImg(x) {
            x.style.height = "128px";
            x.style.width = "128px";
        }
    </script>

</body>

</html>