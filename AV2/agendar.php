<?php
session_start();

header("Content-Type: application/json");
require_once "database.php"; 

$dados = json_decode(file_get_contents("php://input"), true);

$data_hora        = $dados['data_hora'] ?? null;
$categoria        = $dados['categoria'] ?? null;
$especificacao    = $dados['especificacao'] ?? null;
$profissional     = $dados['profissional'] ?? null;
$metodo_pagamento = $dados['metodo_pagamento'] ?? null;
$usuario_id       = $_SESSION['usuario_id'] ?? null;

if (!$usuario_id) {
    echo json_encode(["status" => "erro", "mensagem" => "Você precisa estar logado para realizar um agendamento."]);
    exit;
}

if (!$data_hora || !$categoria || !$especificacao || !$profissional || !$metodo_pagamento) {
    echo json_encode(["status" => "erro", "mensagem" => "Todos os campos do agendamento são obrigatórios."]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO agendamentos (usuario_id, data_hora, categoria, especificacao, profissional, metodo_pagamento) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$usuario_id, $data_hora, $categoria, $especificacao, $profissional, $metodo_pagamento]);

    echo json_encode(["status" => "sucesso", "mensagem" => "Agendamento realizado com sucesso!"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro no banco: " . $e->getMessage()]);
}
?>