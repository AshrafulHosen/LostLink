<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $found_id = $_POST['found_id'];
    $claimant_id = $_SESSION['user_id'];
    $proof_text = trim($_POST['proof_text']);
    
    if(!empty($_POST['marks'])) {
        $proof_text .= "\nMarks: " . trim($_POST['marks']);
    }

    $sql = "BEGIN SP_FILE_CLAIM(:found_id, :claimant_id, :proof_text); END;";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":found_id", $found_id);
    oci_bind_by_name($stmt, ":claimant_id", $claimant_id);
    oci_bind_by_name($stmt, ":proof_text", $proof_text);

    if(oci_execute($stmt)) {
        header("Location: index.php?claim=success");
        exit;
    } else {
        $e = oci_error($stmt);
        echo $e['message'];
    }
}
?>
