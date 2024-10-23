<?php 
function cnx(PDO $conn){
    $sql = "SELECT pseudo , mot de passe  FROM login WHERE pseudo =:pseudo and mdp=:mdp ";
    $res = $conn->query($sql);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function insert_acc(PDO $conn, array $data) {
    $sql = "INSERT INTO login(pseudo, mot_de_passe, nom ,prenom) 
            VALUES (:pseudo, :mot_de_passe ,:nom ,:prenom)";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
    return $conn->lastInsertId();
}

// function login_user(PDO $conn, $pseudo, $mot_de_passe){
//     $sql = "SELECT * FROM login WHERE pseudo = :pseudo AND mot_de_passe = :mot_de_passe";
//     $res = $conn->query($sql);
//     $res->execute([":pseudo" => $pseudo, ":mot_de_passe" => $mot_de_passe]);
//     return $res->fetch(PDO::FETCH_ASSOC);
// }

function update_acc(PDO $conn, array $data) {
    $sql = "UPDATE login SET 
            nom = :nom, 
            prenom = :prenom, 
            pseudo = :pseudo, 
            mot_de_passe = :mot_de_passe 
            where id_login = :id_login";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
}
