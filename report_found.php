<?php

session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id']))
{
    header("Location:index.php");
    exit;
}

$userId     = $_SESSION['user_id'];
$itemName   = trim($_POST['item_name']);
$category   = trim($_POST['category']);
$color      = trim($_POST['color']);
$description= trim($_POST['description']);
$location   = trim($_POST['location']);
$foundDate  = $_POST['found_date'];

$sql = "BEGIN SP_REPORT_FOUND_ITEM(:user_id, :item_name, :category, :color, :description, :location, TO_DATE(:found_date,'YYYY-MM-DD')); END;";

$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt,":user_id",$userId);
oci_bind_by_name($stmt,":item_name",$itemName);
oci_bind_by_name($stmt,":category",$category);
oci_bind_by_name($stmt,":color",$color);
oci_bind_by_name($stmt,":description",$description);
oci_bind_by_name($stmt,":location",$location);
oci_bind_by_name($stmt,":found_date",$foundDate);

if (oci_execute($stmt))
{
    header("Location:index.php");
    exit;
}

$e = oci_error($stmt);
echo $e['message'];
?>