<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "purchase_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>