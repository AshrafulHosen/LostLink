<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location:index.php");
    exit;
}

if(isset($_GET['id'])) {
    $lostId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    $sql = "BEGIN SP_DELETE_LOST_ITEM(:lost_id, :user_id); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":lost_id", $lostId);
    oci_bind_by_name($stmt, ":user_id", $userId);

    if(oci_execute($stmt)) {
        header("Location:index.php?delete=success");
        exit;
    }

    $e = oci_error($stmt);
    echo $e['message'];
} else {
    header("Location:index.php");
    exit;
}
?>
