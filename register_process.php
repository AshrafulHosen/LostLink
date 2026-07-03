<?php

session_start();
include 'includes/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = trim($_POST['fullname']);
    $student = trim($_POST['studentid']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $sql = "BEGIN SP_REGISTER_USER(:name, :student, :email, :hash); END;";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":name", $name);
    oci_bind_by_name($stmt, ":student", $student);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":hash", $hash);

    if(oci_execute($stmt))
    {
        header("Location:index.php?register=success");
        exit;
    }

    echo "Registration Failed";
}
?>