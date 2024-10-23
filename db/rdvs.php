<?php

function insert_rdv(PDO $conn, array $data) {
    $sql = "INSERT INTO consultation(date_cons ,num_patient , `type` ,consultation ) 
            VALUES (:date_cons , :num_patient , :type , :consultation)";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
}
function liste_rdvs(PDO $conn  ,string $date_cons) {
    $sql = "SELECT telephone, nom, prenom , date_cons , consultation ,patient.num_patient
    FROM patient INNER JOIN consultation ON patient.num_patient = consultation.num_patient
    WHERE DATE(consultation.date_cons) = :date_cons  ";
    $res = $conn->prepare($sql);
    $res ->execute([':date_cons' => $date_cons]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function liste_rdvs_periode(PDO $conn  ,string $deb , string $fin) {
    $sql = "SELECT telephone, nom, prenom , date_cons , consultation ,patient.num_patient
    FROM patient INNER JOIN consultation ON patient.num_patient = consultation.num_patient
    WHERE DATE(consultation.date_cons) between :deb and :fin ";
    $res = $conn->prepare($sql);
    $res ->execute([':deb' => $deb , ':fin'=> $fin]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}


function update_cons(PDO $conn, array $data) {
    $sql = "UPDATE consultation SET 
            date_cons = :ndate_cons, 
            consultation = :consultation, 
            `type` = :type
            where num_patient = :num_patient AND 
                  date_cons = :odate_cons" ;
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
}

function patient_fetch_date_rdv(PDO $conn , int $num_patient){
    $sql = "SELECT * FROM consultation WHERE num_patient = :num_patient ORDER BY date_cons "; 
    $res = $conn->prepare($sql);
    $res->execute([':num_patient' => $num_patient]);
    return $res->fetch(PDO::FETCH_ASSOC);
}
    
function patient_fetch_date_rdvs(PDO $conn , int $num_patient){
    $sql = "SELECT * FROM consultation WHERE num_patient = :num_patient ORDER BY date_cons "; 
    $res = $conn->prepare($sql);
    $res->execute([':num_patient' => $num_patient]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function patient_fetch_date_cons(PDO $conn , int $num_patient , string $date_cons){
    $sql = "SELECT * FROM consultation WHERE num_patient = :num_patient and date_cons = :date_cons"; 
    $res = $conn->prepare($sql);
    $res->execute([':num_patient' => $num_patient , ':date_cons' => $date_cons]);
    return $res->fetch(PDO::FETCH_ASSOC);
}

function update_text_cons(PDO $conn, array $data) {
    $sql = "UPDATE consultation SET 
            date_cons = :date_cons, 
            consultation = :consultation, 
            `type` = :type
            where num_patient = :num_patient AND 
                  date_cons = :date_cons" ;
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
}
