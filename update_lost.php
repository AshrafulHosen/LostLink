<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location:index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lostId = $_POST['lost_id'];
    $userId = $_SESSION['user_id'];
    $itemName = trim($_POST['item_name']);
    $category = trim($_POST['category']);
    $color = trim($_POST['color']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);

    $sql = "BEGIN SP_UPDATE_LOST_ITEM(:lost_id, :user_id, :item_name, :category, :color, :description, :location); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":lost_id", $lostId);
    oci_bind_by_name($stmt, ":user_id", $userId);
    oci_bind_by_name($stmt, ":item_name", $itemName);
    oci_bind_by_name($stmt, ":category", $category);
    oci_bind_by_name($stmt, ":color", $color);
    oci_bind_by_name($stmt, ":description", $description);
    oci_bind_by_name($stmt, ":location", $location);

    if(oci_execute($stmt)) {
        header("Location:index.php?update=success");
        exit;
    }

    $e = oci_error($stmt);
    echo $e['message'];
}
?>
