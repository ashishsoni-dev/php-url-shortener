<?php

$conn = mysqli_connect("localhost", "root", "", "url_shortener");

if (!$conn) {
    die("Connection Failed");
}
mysqli_set_charset($conn, "utf8mb4");
?>