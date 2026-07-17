<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$action = $_POST["action"] ?? "";
$matchId = $_POST["match_id"] ?? 0;
$userId = $_SESSION["user_id"];

if ($action === "send") {
    $text = trim($_POST["message"] ?? "");
    if ($text !== "" && $matchId > 0) {
        $sql = "BEGIN SP_ADD_MESSAGE(:match_id, :sender_id, :text); END;";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":match_id", $matchId);
        oci_bind_by_name($stmt, ":sender_id", $userId);
        oci_bind_by_name($stmt, ":text", $text);
        
        if (oci_execute($stmt)) {
            echo json_encode(["status" => "success"]);
            exit;
        }
    }
    echo json_encode(["status" => "error"]);
    exit;
}

if ($action === "fetch") {
    $sql = "BEGIN :cursor := FN_GET_MESSAGES(:match_id); END;";
    $stmt = oci_parse($conn, $sql);
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_bind_by_name($stmt, ":match_id", $matchId);
    oci_execute($stmt);
    oci_execute($cursor);
    
    $messages = [];
    while ($row = oci_fetch_assoc($cursor)) {
        $row["IS_MINE"] = ($row["SENDER_ID"] == $userId) ? true : false;
        $messages[] = $row;
    }
    
    echo json_encode(["status" => "success", "messages" => $messages]);
    exit;
}

echo json_encode(["status" => "invalid_action"]);
?>
