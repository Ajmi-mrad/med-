<?php
function liste_compte(PDO $conn) {
    $sql = "SELECT * FROM login ORDER BY nom, prenom";
    $res = $conn->query($sql);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function select_cord(PDO $conn , string $type){
    $sql = "SELECT * FROM login where type = :type ";
    $res = $conn->prepare($sql);
    $res->execute([':type' => $type]);
    return $res->fetch(PDO::FETCH_ASSOC);
}

function insert_compte(PDO $conn, array $data) {
    $sql = "INSERT INTO login(pseudo, mot_de_passe, nom ,prenom,type) 
            VALUES (:pseudo, :mot_de_passe ,:nom ,:prenom,:type)";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
    return $conn->lastInsertId();
}

function update_compte(PDO $conn, array $data) {
    $sql = "UPDATE login SET 
            nom = :nom, 
            prenom = :prenom, 
            pseudo = :pseudo, 
            type = :type,
            mot_de_passe = :mot_de_passe 
            where id_login = :id_login";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
}


function login_user(PDO $conn, string $pseudo, string $mot_de_passe){
    $sql = "SELECT * FROM `login` WHERE pseudo = :pseudo AND mot_de_passe = :mot_de_passe";
    $res = $conn->prepare($sql);
    $res->execute([":pseudo" => $pseudo, ":mot_de_passe" => $mot_de_passe]);
    return $res->fetch(PDO::FETCH_ASSOC);
}