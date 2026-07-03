<?php
session_start();
header("Content-Type: application/json");
require_once "database.php"; 

$dados = json_decode(file_get_contents("php://input"), true);

$email = $dados['email'] ?? null;
$senha = $dados['senha'] ?? null;

if (!$email || !$senha) {
    echo json_encode(["status" => "erro", "mensagem" => "Por favor, preencha todos os campos."]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && $usuario['senha'] === $senha) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        echo json_encode(["status" => "sucesso"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "E-mail ou senha incorretos. Caso não tenha conta, cadastre-se."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro no banco: " . $e->getMessage()]);
}
?>