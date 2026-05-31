<?php 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $excluirPtexto = isset($_POST["pergunta"]) ? $_POST["pergunta"] : "";

    if (empty($excluirPtexto)) {
        echo json_encode(["status" => "erro", "mensagem" => "Pergunta não informada."]);
        exit;
    }

    $linhas = file("Ptexto.txt");
    $novaInfo = "";
    $primeiraLinha = true;
    $encontrou = false;

    foreach ($linhas as $linha) {
        if ($primeiraLinha) {
            $novaInfo .= $linha;
            $primeiraLinha = false;
            continue;
        }

        $dados = explode(";", trim($linha));

        if ($dados[0] != $excluirPtexto) {
            $novaInfo .= $linha;
        } else {
            $encontrou = true;
        }
    }
  
    file_put_contents("Ptexto.txt", $novaInfo);

    if ($encontrou) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Pergunta excluída com sucesso."]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Pergunta não encontrada."]);
    }
    exit;
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Método inválido."]);
    exit;
}
?>