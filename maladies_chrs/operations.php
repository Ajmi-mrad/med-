<?php

require "../db/conn.php";
require "../db/maladies_chrs.php";

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

if ($table == 'categorie') {
    if ($operation == 'insert') {
        $data = ['categorie' => $_POST['categorie']];
        $id = insert_categorie($conn, $data);
        echo $id;
    }

    if ($operation == 'delete') {
        delete_categorie($conn, $_POST['num_cat']);
        delete_maladie_parcat($conn, $_POST['num_cat']);
    }

    if ($operation == 'update') {
        $data = ['categorie' => $_POST['categorie'] , 'num_categorie'=> $_POST['num_cat']];
        update_categorie($conn, $data);
    }
}

if ($table == 'maladie') {
    if ($operation == 'insert') {
        $data = ['maladie' => $_POST['maladie'] , 'num_categorie' => $_POST['num_cat']];
        $id = insert_maladie($conn, $data);
        echo $id;
    }

    if ($operation == 'delete') {
        delete_maladie($conn, $_POST['num_mal']);
    }

    if ($operation == 'update') {
        $data = ['maladie' => $_POST['maladie'] , 'num_maladie'=> $_POST['num_mal']];
        update_maladie($conn, $data);
    }
}



