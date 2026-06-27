<?php

$conn = oci_connect(
    "llink",
    "1234",
    "localhost/XE"
);

if (!$conn) {
    $e = oci_error();
    die("Oracle Connection Failed: " . $e['message']);
}
?>