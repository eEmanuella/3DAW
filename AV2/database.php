<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "salao";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOxception $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>