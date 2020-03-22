<?php
/*
        authors:
        Piotr Bienkowski
        Bartosz Kostarczyk
        Mateusz Mazurczak
    */
$servername = "127.0.0.1";
$username = "";
$password = "";
$dbname = "";


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("SET NAMES 'utf8'");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
