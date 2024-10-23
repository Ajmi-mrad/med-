<?php
function insert_image(PDO $conn, array $data) {
    $sql = "INSERT INTO images(num_patient, date_img, image) 
            VALUES (:num_patient, :date_img, :image)";
    $ins = $conn->prepare($sql);
    $ins->execute(prepare_data($data));
    return $conn->lastInsertId();
}
function select_img(PDO $conn ,$num_patient){
    $sql = "SELECT * FROM images WHERE num_patient = :num_patient ORDER BY date_img "; 
    $res = $conn->prepare($sql);
    $res->execute([':num_patient' => $num_patient]);
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

function select_img_byid(PDO $conn, $num_image){
    $sql = "SELECT * FROM images WHERE num_image = :num_image"; 
    $res = $conn->prepare($sql);
    $res->execute([':num_image' => $num_image]);
    return $res->fetch(PDO::FETCH_ASSOC);
}