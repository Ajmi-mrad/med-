<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../cnx/cnx.php");
}

require "../db/conn.php";
require_once '../db/rdvs.php';


$num_patient = (isset($_GET["num_patient"])) ? $_GET["num_patient"] : '';
$date_cons = (isset($_GET["date_cons"])) ? $_GET["date_cons"] : '';

if ($num_patient != '' && $date_cons != '') {
    $delete = $conn->prepare("DELETE FROM consultation WHERE date_cons=:date_cons and num_patient=:num_patient");
    $delete->execute([':date_cons' => $date_cons, ':num_patient' => $num_patient]);
}
header("location: liste_rdvs.php");
