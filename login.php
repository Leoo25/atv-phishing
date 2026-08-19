<?php
require_once 'banco.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario_teste"] ?? "");

    if (!empty($usuario)) {
        $stmt = $pdo->prepare("INSERT INTO tentativas (usuario_teste) VALUES (:usuario)");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
    }
    
    header("Location: home.php");
    exit;
}