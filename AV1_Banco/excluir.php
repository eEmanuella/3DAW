<?php
header("Content-Type: application/json");
require_once 'database.php';

$jsonBruto = file_get_contents("php://input");
$dados = json_decode($jsonBruto, true);

if (isset($dados['id'])) {
    $id = $dados['id'];

    try {
        $sql = "DELETE FROM perguntas WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        echo json_encode(["status" => "sucesso", "mensagem" => "Pergunta excluída com sucesso."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao excluir: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "erro", "mensagem" => "ID não fornecido."]);
}
?>