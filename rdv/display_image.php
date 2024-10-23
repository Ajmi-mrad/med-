<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: ../cnx/cnx.php");
}

require_once "../db/conn.php";
require_once "../db/image.php";

$row =  select_img_byid($conn, $_GET['num_image']);
?><img src="<?= "data:image/jpg;charset=utf8;base64,". base64_encode(stripslashes($row['image'])) ?>" alt="Image patient">