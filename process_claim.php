<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $claim_id = $_POST['claim_id'];
    $action = $_POST['action']; // "APPROVED" or "REJECTED"

    if(in_array($action, ['APPROVED', 'REJECTED'])) {
        $sql = "BEGIN SP_PROCESS_CLAIM(:claim_id, :status); END;";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":claim_id", $claim_id);
        oci_bind_by_name($stmt, ":status", $action);

        if(oci_execute($stmt)) {
            header("Location: index.php?admin_action=success");
            exit;
        } else {
            $e = oci_error($stmt);
            die("Error: " . $e['message']);
        }
    }
}
?>
