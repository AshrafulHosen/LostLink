<?php

session_start();

include 'includes/db.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "BEGIN :cursor := FN_GET_USER_BY_EMAIL(:email); END;";

    $stmt = oci_parse($conn, $sql);

    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);
    oci_bind_by_name($stmt, ":email", $email);

    oci_execute($stmt);
    oci_execute($cursor);

    $user = oci_fetch_assoc($cursor);

    if($user &&
       password_verify(
           $password,
           $user['PASSWORD_HASH']
       ))
    {
        $_SESSION['user_id']
            = $user['USER_ID'];

        $_SESSION['name']
            = $user['FULL_NAME'];

        $_SESSION['role']
            = $user['ROLE'];

        header("Location:index.php");
        exit;
    }

    header("Location:index.php?login=failed");
}
?>