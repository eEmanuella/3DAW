<?php
header("Content-Type: application/json");

require_once 'database.php';

$jsonBruto = file_get_contents("php://input");

$dados = json_decode($jsonBruto, true);

if ($dados) {
    $pergunta = $dados['pergunta'];
    $tipo = $dados['tipo'];
    $alt_a = !empty($dados['alt_a']) ? $dados['alt_a'] : null;
    $alt_b = !empty($dados['alt_b']) ? $dados['alt_b'] : null;
    $alt_c = !empty($dados['alt_c']) ? $dados['alt_c'] : null;
    $alt_d = !empty($dados['alt_d']) ? $dados['alt_d'] : null;

    try {
        $sql = "INSERT INTO perguntas (texto_pergunta, tipo, alt_a, alt_b, alt_c, alt_d) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([$pergunta, $tipo, $alt_a, $alt_b, $alt_c, $alt_d]);
        
        echo json_encode(["status" => "sucesso", "mensagem" => "Inserido com sucesso."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "erro", "mensagem" => "Erro no banco: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Nenhum dado recebido."]);
}
?>