<?php

function liste_categories(PDO $conn) {
    $sql = "SELECT * FROM categorie_maladie ORDER BY categorie";
    $res = $conn->query($sql);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}
function liste_maladies_chroniques(PDO $conn , int $num_categorie){
    $sql = "SELECT * FROM maladies_chroniques WHERE num_categorie = :num_categorie ORDER BY maladie";
    $res = $conn->prepare($sql);
    $res->execute([':num_categorie' => $num_categorie]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function insert_categorie(PDO $conn, array $data) {
    $sql = "INSERT INTO categorie_maladie(categorie) 
            VALUES (:categorie)";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
    return $conn->lastInsertId();
}
function delete_categorie(PDO $conn , int $num_categorie){
  	$delete = $conn->prepare("DELETE FROM categorie_maladie  WHERE num_categorie=:num_categorie");
  	$delete->execute([':num_categorie' => $num_categorie]);
}

function update_categorie(PDO $conn, array $data) {
    $sql = "UPDATE categorie_maladie SET 
            categorie = :categorie
            where num_categorie = :num_categorie";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
}

function delete_maladie_parcat(PDO $conn , int $num_categorie){
    $delete = $conn->prepare("DELETE FROM maladies_chroniques WHERE num_categorie=:num_categorie");
    $delete->execute([':num_categorie' => $num_categorie]);
}

function insert_maladie(PDO $conn, array $data) {
    $sql = "INSERT INTO maladies_chroniques(maladie , num_categorie) 
            VALUES (:maladie , :num_categorie)";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
    return $conn->lastInsertId();

}


function delete_maladie(PDO $conn , int $num_maladie){
    $delete = $conn->prepare("DELETE FROM maladies_chroniques WHERE num_maladie=:num_maladie");
    $delete->execute([':num_maladie' => $num_maladie]);
}
function update_maladie(PDO $conn, array $data) {
    $sql = "UPDATE maladies_chroniques SET 
            maladie = :maladie
            where num_maladie = :num_maladie";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
}
