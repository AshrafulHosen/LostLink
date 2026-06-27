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

$sql = "
INSERT INTO FOUND_ITEMS
(
    FOUND_ID,
    USER_ID,
    ITEM_NAME,
    CATEGORY,
    COLOR,
    DESCRIPTION,
    FOUND_LOCATION,
    FOUND_DATE,
    STATUS
)
VALUES
(
    FOUND_ITEMS_SEQ.NEXTVAL,
    :user_id,
    :item_name,
    :category,
    :color,
    :description,
    :location,
    TO_DATE(:found_date,'YYYY-MM-DD'),
    'UNCLAIMED'
)
";

$stmt = oci_parse($conn,$sql);

oci_bind_by_name($stmt,":user_id",$userId);
oci_bind_by_name($stmt,":item_name",$itemName);
oci_bind_by_name($stmt,":category",$category);
oci_bind_by_name($stmt,":color",$color);
oci_bind_by_name($stmt,":description",$description);
oci_bind_by_name($stmt,":location",$location);
oci_bind_by_name($stmt,":found_date",$foundDate);

if(oci_execute($stmt))
{
    $idSql = " SELECT FOUND_ITEMS_SEQ.CURRVAL FROM DUAL
       ";

    $idStmt = oci_parse($conn,$idSql);
    oci_execute($idStmt);

    $foundId = oci_fetch_row($idStmt)[0];

    include 'generate_matches.php';

    header("Location:index.php");
    exit;
}

$e = oci_error($stmt);
echo $e['message'];
?>