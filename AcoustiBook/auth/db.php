<?php
$host = "localhost";
$user = "acoustibook";
$pass = "";
$db   = "my_acoustibook";

$conn = new mysqli($host, $user, $pass, $db);
//$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
