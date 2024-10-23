<?php

require "../db/conn.php";
require "../db/rdvs.php";

// print_r($_POST);

if (isset($_POST['operation'])) {
    $operation = $_POST['operation'];
} else {
    $operation = "";
}

if (isset($_POST['table'])) {
    $table = $_POST['table'];
} else {
    $table = "";
}

if ($table == 'consultation') {
    if ($operation == 'insert') {
        $data = [
            'consultation' => $_POST['consultation'], 
            'num_patient'=> intval($_POST['num_pat']), 
            'type' => $_POST['type'], 
            'date_cons' => $_POST['date_cons']
        ];
        insert_rdv($conn, $data);
        $rdv = patient_fetch_date_cons($conn, $data['num_patient'], $data['date_cons']);
        echo json_encode(["success" => "ok", "rdv" => $rdv]);
    }

    // if ($operation == 'delete') {
    //     delete_categorie($conn, $_POST['num_cat']);
    //     delete_maladie_parcat($conn, $_POST['num_cat']);
    // }

    if ($operation == 'update') {
        $data = [
            'consultation' => $_POST['consultation'] , 
            'num_patient'=> $_POST['num_pat'] , 
            'type' => $_POST['type'], 
            'date_cons' => $_POST['date_cons']
        ];
        update_text_cons($conn, $data);
        echo json_encode(["success" => "ok"]);
    }
}
