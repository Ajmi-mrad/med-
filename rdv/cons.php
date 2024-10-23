<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../cnx/cnx.php");
}
?>
<?php
require_once '../db/conn.php';
require_once '../db/patients.php';
require_once '../db/rdvs.php';

$num_patient = (isset($_GET["num_patient"])) ? intval($_GET["num_patient"]) : intval($_POST["num_patient"]);
$old_pat = patient_fetch_num($conn, $num_patient);
$old_donnees_pat = patient_fetch_donnees($conn, $num_patient);

// print_r($old_pat);
// print_r($old_donnees_pat);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Medecin</title>
</head>

<body>
  
    <?php
    require_once '../menu.php';
    $rdvs = patient_fetch_date_rdvs($conn, $num_patient);
    ?>
    <script>
        const num_patient = <?= $num_patient ?>;
        const rdvs = <?= json_encode($rdvs) ?>;
    </script>
    <div class="container m-5">
        <form methode='post' name="f">
           
            <input type="hidden" name="num_patient" value="<?= $num_patient ?>">
            <div class="row g-3">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Nom</label>
                    <input type="text" class="form-control" name="poids" value="<?= $old_pat['nom'] ?>" disabled>
                </div>
                <div class="col">
                <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Prenom</label>
                    <input type="text" class="form-control" name="hauteur" value="<?= $old_pat['prenom'] ?>" disabled>
                </div>
            </div>
            <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Age</label>
                <input  class="form-control" name="age" value="<?= substr(date("Y-m-d"), 0, 4) - substr($old_pat['date_naiss'], 0, 4).' Ans' ?>" disabled>
            
            <div class="row g-3">
                <div class="col">
                    <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Poids</label>
                    <input type="text" class="form-control" name="poids" value="<?= $old_donnees_pat['poids'] ?>" disabled>
                </div>
                <div class="col">
                <label for="formGroupExampleInput" class="form-label" style="color: #9F33FF; font-weight: bold;">Hauteur</label>
                    <input type="text" class="form-control" name="hauteur" value="<?= $old_donnees_pat['hauteur'] ?> " disabled>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-sm-4">
                    <h4>Historique</h4>
                    <div id="historique">
                        <div class="list-group">

                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <h4>Consultation</h4>
                    <div id="consultation">
                        <textarea name="text_cons" id="text_cons" cols="30" rows="10" class="form-control" placeholder="Taper une consultation" readonly></textarea>
                    </div>
                    <div id="edit" class="my-2">
                        <button class="btn btn-dark">Modifier</button>
                    </div>
                    <div id="confirm" class="my-2">
                        <button class="btn btn-primary">Enregistrer</button>
                        <button class="btn btn-secondary">Annuler</button>
                    </div>
                </div>
            </div>
            <nav class="nav nav-pills nav-justified">
            <a class="nav-link active" aria-current="page" href="doc_pat.php?num_patient=<?= $num_patient ?>">Document</a>
            </nav>
        </form>
    </div>
</body>
<script>
    function toISOString(d) {
        return d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +
        ("0" + d.getDate()).slice(-2) + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2)+ ":" + ("0" + d.getSeconds()).slice(-2);

    }

    $(() => {
        const histDiv = $('#historique');
        const histList = histDiv.find('.list-group');
        const textArea = $('#text_cons');
        const editDiv = $('#edit');
        const confirmDiv = $('#confirm');

        const btnModifier = editDiv.find('button').eq(0);
        const btnEnregistrer = confirmDiv.find('button').eq(0);
        const btnAnnuler = confirmDiv.find('button').eq(1);

        // var selIndex = histList.prop('selectedIndex');

        btnModifier
            .click((e) => {
                e.preventDefault();

                if (selectedRDV == null) {
                    alert("Aucun RDV sélectionné!");
                    return;
                }

                btnModifierClicked();
            });

        btnAnnuler
            .click((e) => {
                e.preventDefault();

                btnAnnulerClicked();
            });

        btnEnregistrer
            .click((e) => {
                e.preventDefault();

                btnEnregistrerClicked();
            });


        let mode = '';
        let selectedRDV = null;

        function dataSaved() {
            mode = '';
            editDiv.show();
            confirmDiv.hide();
            textArea
                .attr('readonly', 'true');
            selectedRDV['consultation'] = textArea.val();
        }

        function btnModifierClicked() {
            mode = 'edit';
            editDiv.hide();
            confirmDiv.show();
            textArea.removeAttr('readonly');
        }

        function linkNouveauClicked() {
            mode = 'new';
            editDiv.hide();
            confirmDiv.show();
            textArea
                .val('')
                .removeAttr('readonly');
        }

        function btnEnregistrerClicked() {
            const consultation = textArea.val();
            const type = 'cons';
            let date_cons;
            let operation;

            console.log(mode);
            
            if (mode == 'edit') {
                date_cons = selectedRDV['date_cons'];
                operation = 'update';
            } else if (mode == 'new') {
                date_cons = toISOString(new Date());
                operation = 'insert';
            }
            
            $.post("operations.php", {
                'consultation': consultation,
                'num_pat': num_patient,
                'date_cons': date_cons,
                'type': type,
                'table': 'consultation',
                'operation': operation
            }, function(data) {
                if (mode == 'new') {
                    rdvs.push(data.rdv);
                    initRDV();
                }
                dataSaved();
            }, 'json')
            .fail(() => {
                alert("Les données n'ont pas été enregistré!");
            });        
        }

        function btnAnnulerClicked() {
            mode = '';
            editDiv.show();
            confirmDiv.hide();
            textArea
                .val(selectedRDV['consultation'])
                .attr('readonly', 'true');
        }

        function initRDV() {
            histList.html('');

            //editDiv.hide();
            confirmDiv.hide();

            for (let rdv of rdvs) {
                const link = $('<a>')
                    .addClass('list-group-item')
                    .addClass('list-group-item-action')
                    .attr('href', '#')
                    // .attr('name' , 'date_cons')
                    .text(rdv['date_cons'])
                    .appendTo(histList);
                link.click((e) => {
                    e.preventDefault();

                    if (mode != '') {
                        alert("Veuillez terminer l'opération en cours avant de sélectionner une date!");
                        return;
                    }

                    histList.find('a').removeClass('active');

                    const link = $(e.target);
                    const date = link.text();

                    selectedRDV = rdvs.find(mrdv => mrdv['date_cons'] == date);

                    textArea
                        .val(selectedRDV['consultation']);
                    link
                        .attr('aria-current', 'true')
                        .addClass('active');

                    editDiv.show();
                });
            }

            const nvCons = $('<a>')
                .addClass('list-group-item')
                .addClass('list-group-item-action')
                .attr('href', '#')
                .text('Nouvelle consultation')
                // .attr('type', 'date')
                .appendTo(histList);
            nvCons.click((e) => {
                e.preventDefault();
                // .text(date("Y-m-d"))
                if (mode != '') {
                    alert("Veuillez terminer l'opération en cours avant de sélectionner une date!");
                    return;
                }
                histList.find('a').removeClass('active');

                const nvCons = $(e.target);
                nvCons
                    // .attr('type', 'date')
                    .attr('aria-current', 'true')
                    .addClass('active');
                // .prop("value", "Input New Text");

                linkNouveauClicked();
            });
        }

        // PP
        mode = '';
        selectedRDV = null;
        initRDV();
    });
</script>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script> -->

</html>