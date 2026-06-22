<?php

header("Content-Type: application/json");
require_once "db.php";

$dados = json_encode(file_get_contents("php://input"), true);

$nome = $dados['nome'] ?? $_POST['nome'] ?? null;
$email = $dados['email'] ?? $_POST['email'] ?? null;
$senha = $dados['senha'] ?? $_POST['senha'] ?? null;

if (!noem || !email || !senha) {
    echo json_encode(["status" => "erro", "mensagem" => "Todos os campos são obrigatórios."]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $email, $senha]);

    echo json_encode(["status" => "sucesso", "mensagem" => "Usuário cadastrado com sucesso."]);
} catch {
    if ($e->getCode() == 23000) {
        echo json_encode(["status" => "erro", "mensagem" => "Este e-mail já está cadastrado."]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro no banco: " . $e->getMessage()]);
    }
}
?>