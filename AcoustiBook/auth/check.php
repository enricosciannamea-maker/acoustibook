<?php
session_start();
require "db.php";

$token = $_GET["token"] ?? "";

$stmt = $conn->prepare("SELECT id FROM utenti WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $stmt->close();

    $upd = $conn->prepare("UPDATE utenti SET autenticato = 1, token = NULL WHERE token = ?");
    $upd->bind_param("s", $token);
    $upd->execute();
    $upd->close();

    header("Location: login.php?stato=verificato");
    exit;
}

$stmt->close();
header("Location: register.php?stato=token_invalido");
exit;