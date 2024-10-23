<?php
function liste_patients(PDO $conn) {
    $sql = "SELECT * FROM patient ORDER BY nom, prenom";
    $res = $conn->query($sql);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}
function liste_données_pat(PDO $conn){
    $sql = "SELECT * FROM donnees_pat ORDER BY date_cons";
    $res = $conn->query($sql);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function patient_fetch_num(PDO $conn, int $num_patient) {
    $sql = "SELECT * FROM patient WHERE num_patient = :num_patient";
    $res = $conn->prepare($sql);
    $res->execute([':num_patient' => $num_patient]);
    return $res->fetch(PDO::FETCH_ASSOC);
}

function insert_patient(PDO $conn, array $data) {
    $sql = "INSERT INTO patient(nom, prenom, adresse, date_naiss, telephone, cnam, nationalite, type_id, nat_id) 
            VALUES (:nom, :prenom, :adresse, :date_naiss, :telephone, :cnam, :nationalite, :type_id, :nat_id)";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
    return $conn->lastInsertId();
}

function insert_donnees_pat(PDO $conn, array $data) {
    $sql = "INSERT INTO donnees_pat(num_patient, date_cons, poids, hauteur, comment) 
            VALUES (:num_patient, :date_cons, :poids, :hauteur, :comment)";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
    return $conn->lastInsertId();
}

function update_patient(PDO $conn, array $data) {
    $sql = "UPDATE patient SET 
            nom = :nom, 
            prenom = :prenom, 
            adresse = :adresse, 
            date_naiss = :date_naiss, 
            telephone = :telephone, 
            cnam = :cnam, 
            nationalite = :nationalite, 
            `type_id` = :type_id, 
            nat_id = :nat_id 
            where num_patient = :num_patient";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
}
function delete_patient(PDO $conn , array $data){
    $sql = "DELETE FROM patient WHERE num_patient = :num_patient";
    
}


function update_donnees_pat(PDO $conn, array $data) {
    $sql = "UPDATE donnees_pat SET 
            poids = :poids, 
            hauteur = :hauteur, 
            comment = :comment 
            where num_patient = :num_patient AND 
                date_cons = :date_cons";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
}

function patient_fetch(PDO $conn , string $input_cher) {
    $ch = '%'.$input_cher.'%' ; 
    // $sql = 'SELECT * FROM patient WHERE where date_naiss like :ch or nom like :ch prenom like :ch ' ;
    $sql = 'SELECT * FROM patient WHERE date_naiss like :ch or nom like :ch or prenom like :ch ' ;
    $res = $conn->prepare($sql);
    $res->execute([':ch' => $ch]);
    // $res->execute([':date_naiss' => $ch , ':nom' => $ch , ':prenom' => $ch]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function patient_fetch_donnees(PDO $conn, int $num_patient) {
    $sql = "SELECT * FROM donnees_pat WHERE num_patient = :num_patient ORDER BY date_cons desc" ;
    $res = $conn->prepare($sql);
    $res->execute([':num_patient' => $num_patient]);
    return $res->fetch(PDO::FETCH_ASSOC);
}

function patient_fetch_date(PDO $conn , int $num_patient ,string $date_cons){
    $sql = "SELECT * FROM donnees_pat WHERE num_patient = :num_patient AND date_cons = :date_cons" ; 
    $res = $conn->prepare($sql);
    $res->execute([':num_patient' => $num_patient , ':date_cons' => $date_cons ]);
    return $res->fetch(PDO::FETCH_ASSOC);
}

function insert_maladie_patient(PDO $conn, array $data) {
    $sql = "INSERT INTO maladie_patient(num_patient, num_maladie) 
            VALUES (:num_patient, :num_maladie)";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
    // return $conn->lastInsertId();
}

function delete_maladie_patient(PDO $conn , int $num_patient){
    $delete = $conn->prepare("DELETE FROM maladie_patient WHERE num_patient=:num_patient ");
    $delete->execute([':num_patient' => $num_patient]);
}
// function patient_fetch_maladie(PDO $conn , int $num_patient , int $num_maladie ){
//     $sql = "SELECT * FROM maladie_patient WHERE num_patient = :num_patient and num_maladie = :num_maladie" ; 
//     $res = $conn->prepare($sql);
//     $res->execute([':num_patient' => $num_patient , ':num_maladie' => $num_maladie]);
//     return $res->fetchAll(PDO::FETCH_ASSOC);
// }

function patient_fetch_maladie(PDO $conn, int $num_patient , int $num_categorie){
    $sql = "SELECT mc.*, ISNULL(mp.num_maladie) AS checked
    FROM `maladies_chroniques` AS mc LEFT JOIN (SELECT num_maladie FROM `maladie_patient` WHERE num_patient = :num_patient)
     AS mp ON mc.num_maladie=mp.num_maladie where num_categorie = :num_categorie";
    $res = $conn->prepare($sql);
    $res->execute([':num_patient' => $num_patient , ':num_categorie' => $num_categorie]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
  }

// function patient_fetch_maladie(PDO $conn , int $num_patient ){
//     $sql = "SELECT * FROM donnees_pat WHERE num_patient = :num_patient "; 
//     $res = $conn->prepare($sql);
//     $res->execute([':num_patient' => $num_patient ]);
//     return $res->fetchAll(PDO::FETCH_ASSOC);
// }