<?php
$pergunta = "";
$respostaA = "";
$respostaB = "";
$respostaC = "";
$respostaD = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');

    $pergunta = isset($_POST["pergunta"]) ? $_POST["pergunta"] : "";
    $respostaA = isset($_POST["respostaA"]) ? $_POST["respostaA"] : "";
    $respostaB = isset($_POST["respostaB"]) ? $_POST["respostaB"] : "";
    $respostaC = isset($_POST["respostaC"]) ? $_POST["respostaC"] : "";
    $respostaD = isset($_POST["respostaD"]) ? $_POST["respostaD"] : "";

    if (empty($pergunta) || empty($respostaA) || empty($respostaB) || empty($respostaC) || empty($respostaD)) {
        echo json_encode(["status" => "erro", "mensagem" => "Preencha todos os campos."]);
        exit;
    }

    if (!file_exists("PergM.txt")) {
        $arqPergM = fopen("PergM.txt", "w") or die(json_encode(["status" => "erro", "mensagem" => "erro ao criar arquivo"]));
        $linha = "pergunta;respostaA;respostaB;respostaC;respostaD\n";
        fwrite($arqPergM, $linha);
        fclose($arqPergM);
    }

    $arqPergM = fopen("PergM.txt", "a") or die(json_encode(["status" => "erro", "mensagem" => "erro ao abrir arquivo"]));
    $linha = $pergunta . ";" . $respostaA . ";" . $respostaB .";" . $respostaC .";" . $respostaD . "\n";
    fwrite($arqPergM, $linha);
    fclose($arqPergM);

    echo json_encode(["status" => "sucesso", "mensagem" => "Cadastro realizado com sucesso."]);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h1>Cadastrar perguntas e respostas</h1>
    
    <form id="formCadastroPm">
        Pergunta: <input type="text" name="pergunta">
        <br><br>
        Letra a: <input type="text" name="respostaA">
        <br><br>
        Letra b: <input type="text" name="respostaB">
        <br><br>
        Letra c: <input type="text" name="respostaC">
        <br><br>
        Letra d: <input type="text" name="respostaD">
        <br><br>
        <input type="submit" value="Cadastrar pergunta">
    </form>

    <div id="mensagemStatus"></div>

<script>
document.getElementById('formCadastroPm').addEventListener('submit', function(event) {

    event.preventDefault();

    const dadosForm = new FormData(this);

    fetch('criarPm.php', {
        method: 'POST',
        body: dadosForm
    })
    .then(response => response.json())
    .then(resposta => {
        const divMensagem = document.getElementById('mensagemStatus');
        
        if (resposta.status === 'sucesso') {
            divMensagem.innerHTML = "<p>" + resposta.mensagem + "</p>";
            this.reset(); 
        } else {
            divMensagem.innerHTML = "<p>Erro: " + resposta.mensagem + "</p>";
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
        alert("Erro ao conectar com o servidor.");
    });
});
</script>
</body>
</html>