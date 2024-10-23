<?php

try {
    $host = "127.0.0.1";
    $dbname = "dt-base";
    $user = "root";
    $pass = "";

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "error is: " . $e->getMessage();
    die();
}


function prepare_data(array $data) {
    $data1 = [];
    foreach ($data as $key => $value) {
        $data1[":".$key] = $value;
    }
    return $data1;
}