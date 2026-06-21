<?php
header("Content-Type: application/json");

require_once 'database.php';

try {
    $sql = "SELECT * FROM perguntas ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($perguntas);

} catch (PDOException $e) {
    echo json_encode(["status" => "erro", "mensagem" => $e->getMessage()]);
}
?>