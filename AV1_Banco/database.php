<?php
$host = "localhost";
$banco = "perguntas_db";
$usuario = "root";
$senha = ""; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "erro", "mensagem" => "Falha na conexão: " . $e->getMessage()]);
    exit;
}
?>