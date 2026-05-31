<?php
$pergunta = "";
$respostaA = "";
$respostaB = "";
$respostaC = "";
$respostaD = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');

    $pergunta = isset($_POST["pergunta"]) ? $_POST["pergunta"] : "";
    $novaA = isset($_POST["respostaA"]) ? $_POST["respostaA"] : "";
    $novaB = isset($_POST["respostaB"]) ? $_POST["respostaB"] : "";
    $novaC = isset($_POST["respostaC"]) ? $_POST["respostaC"] : "";
    $novaD = isset($_POST["respostaD"]) ? $_POST["respostaD"] : "";

    if (empty($pergunta) || empty($novaA) || empty($novaB) || empty($novaC) || empty($novaD)) {
        echo json_encode(["status" => "erro", "mensagem" => "Preencha todos os campos."]);
        exit;
    }

    $linhas = file("PergM.txt");
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
        if (count($colunaDados) < 5) continue;

        if ($colunaDados[0] == $pergunta) {
            $novaInfo .= $pergunta . ";" . $novaA . ";" . $novaB . ";" . $novaC . ";" . $novaD . "\n";
            $encontrou = true;
        } else {
            $novaInfo .= trim($linha) . "\n";
        }
    }

    if ($encontrou) {
        file_put_contents("PergM.txt", $novaInfo);
        echo json_encode(["status" => "sucesso", "mensagem" => "Respostas atualizadas com sucesso."]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Pergunta não encontrada."]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["pergunta"])) {
    $pergunta = $_GET["pergunta"];
    $linhas = file("PergM.txt");

    $primeiraLinha = true;
    foreach ($linhas as $linha) {
        if ($primeiraLinha) { $primeiraLinha = false; continue; }
        if (trim($linha) == "") continue;

        $colunaDados = explode(";", trim($linha));

        if ($colunaDados[0] == $pergunta) {
            $respostaA = $colunaDados[1];
            $respostaB = $colunaDados[2];
            $respostaC = $colunaDados[3];
            $respostaD = $colunaDados[4];
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
<h1>Editar Pergunta de Múltipla Escolha</h1>

<form id="formEditarPm">
    Pergunta: <input type="text" name="pergunta" value="<?php echo ($pergunta); ?>" readonly>
    <br><br>
    Resposta A: <input type="text" name="respostaA" value="<?php echo ($respostaA); ?>">
    <br><br>
    Resposta B: <input type="text" name="respostaB" value="<?php echo ($respostaB); ?>">
    <br><br>
    Resposta C: <input type="text" name="respostaC" value="<?php echo ($respostaC); ?>">
    <br><br>
    Resposta D: <input type="text" name="respostaD" value="<?php echo ($respostaD); ?>">
    <br><br>
    <input type="submit" value="Salvar Alterações">
</form>

<div id="mensagemStatus"></div>

<script>
document.getElementById('formEditarPm').addEventListener('submit', function(event) {
    event.preventDefault();

    const dadosForm = new FormData(this);

    fetch('editarPm.php', {
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