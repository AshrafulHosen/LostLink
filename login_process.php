<?php

session_start();

include 'includes/db.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "
    SELECT *
    FROM USERS
    WHERE EMAIL=:email";

    $stmt = oci_parse($conn,$sql);

    oci_bind_by_name($stmt,":email",$email);

    oci_execute($stmt);

    $user = oci_fetch_assoc($stmt);

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