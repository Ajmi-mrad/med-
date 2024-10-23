<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: index.php");
    die();
}

require "../db/conn.php";
require_once '../db/admin.php';


$id_login = (isset($_GET["id_login"])) ? $_GET["id_login"] : '';

if ($id_login != '' ) {
    $delete = $conn->prepare("DELETE FROM login WHERE id_login =:id_login");
    $delete->execute([':id_login' => $id_login]);
}
header("location: okhra.php");
