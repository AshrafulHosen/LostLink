<?php

session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id']))
{
    header("Location:index.php");
    exit;
}

$userId = $_SESSION['user_id'];

$itemName = trim($_POST['item_name']);
$category = trim($_POST['category']);
$color = trim($_POST['color']);
$description = trim($_POST['description']);
$location = trim($_POST['location']);
$lostDate = $_POST['lost_date'];

$sql = "
INSERT INTO LOST_ITEMS
(
    USER_ID,
    ITEM_NAME,
    CATEGORY,
    COLOR,
    DESCRIPTION,
    LOST_LOCATION,
    LOST_DATE,
    STATUS
)
VALUES
(
    :user_id,
    :item_name,
    :category,
    :color,
    :description,
    :location,
    TO_DATE(:lost_date,'YYYY-MM-DD'),
    'ACTIVE'
)
";

$stmt = oci_parse($conn,$sql);

oci_bind_by_name($stmt,":user_id",$userId);
oci_bind_by_name($stmt,":item_name",$itemName);
oci_bind_by_name($stmt,":category",$category);
oci_bind_by_name($stmt,":color",$color);
oci_bind_by_name($stmt,":description",$description);
oci_bind_by_name($stmt,":location",$location);
oci_bind_by_name($stmt,":lost_date",$lostDate);

if(oci_execute($stmt))
{
    header("Location:index.php?report=success");
    exit;
}

$e = oci_error($stmt);
echo $e['message'];
?>