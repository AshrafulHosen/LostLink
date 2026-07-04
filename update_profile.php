<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location:index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $fullName = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $department = trim($_POST['department']);

    $sql = "BEGIN SP_UPDATE_USER_PROFILE(:user_id, :full_name, :phone, :department); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":user_id", $userId);
    oci_bind_by_name($stmt, ":full_name", $fullName);
    oci_bind_by_name($stmt, ":phone", $phone);
    oci_bind_by_name($stmt, ":department", $department);

    if(oci_execute($stmt)) {
        $_SESSION['name'] = $fullName; // update session name too
        header("Location:index.php?profile=success");
        exit;
    }

    $e = oci_error($stmt);
    echo $e['message'];
}
?>
