<?php
$msg = "";
$pergunta = "";
$resposta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');

    $pergunta = isset($_POST["pergunta"]) ? $_POST["pergunta"] : "";
    $novaResposta = isset($_POST["resposta"]) ? $_POST["resposta"] : "";

    if (empty($pergunta) || empty($novaResposta)) {
        echo json_encode(["status" => "erro", "mensagem" => "Preencha todos os campos."]);
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

        $colunaDados = explode(";", trim($linha));
        if (count($colunaDados) < 2) continue;

        if ($colunaDados[0] == $pergunta) {
            $novaInfo .= $pergunta . ";" . $novaResposta . "\n";
            $encontrou = true;
        } else {
            $novaInfo .= trim($linha) . "\n";
        }
    }

    if ($encontrou) {
        file_put_contents("Ptexto.txt", $novaInfo);
        echo json_encode(["status" => "sucesso", "mensagem" => "Respostas atualizadas com sucesso."]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Pergunta não encontrada."]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["pergunta"])) {
    $pergunta = $_GET["pergunta"];
    $linhas = file("Ptexto.txt");

    $primeiraLinha = true;
    foreach ($linhas as $linha) {
        if ($primeiraLinha) { $primeiraLinha = false; continue; }
        if (trim($linha) == "") continue;

        $colunaDados = explode(";", trim($linha));

        if ($colunaDados[0] == $pergunta) {
            $resposta = $colunaDados[1];
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Editar Pergunta de Texto </h1>

<form id="formEditarPtexto">
    Pergunta: <input type="text" name="pergunta" value="<?php echo ($pergunta); ?>" readonly>
    <br><br>
    Resposta: <input type="text" name="resposta" value="<?php echo ($resposta); ?>">
    <br><br>
    <input type="submit" value="Salvar Alterações">
</form>

<div id="mensagemStatus"></div>

<script>
document.getElementById('formEditarPtexto').addEventListener('submit', function(event) {
    event.preventDefault();

    const dadosForm = new FormData(this);

    fetch('editarPtexto.php', {
        method: 'POST',
        body: dadosForm
    })
    .then(response => response.json()) 
    .then(resposta => {
        const divMensagem = document.getElementById('mensagemStatus');
        
        if (resposta.status === 'sucesso') {
            divMensagem.innerHTML = "<p>" + resposta.mensagem + "</p>";
        } else {
            divMensagem.innerHTML = "<p>Erro: " + resposta.mensagem + "</p>";
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
        alert("Erro ao se conectar com o servidor.");
    });
});
</script>
</body>
</html>