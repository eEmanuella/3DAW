<?php
$msg = "";
$pergunta = "";
$resposta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');

    $pergunta = isset($_POST["pergunta"]) ? $_POST["pergunta"] : "";
    $resposta = isset($_POST["resposta"]) ? $_POST["resposta"] : "";

    if (empty($pergunta) || empty($resposta)) {
        echo json_encode(["status" => "erro", "mensagem" => "Preencha todos os campos."]);
        exit;
    }

    if (!file_exists("Ptexto.txt")) {
        $arqPtexto = fopen("Ptexto.txt", "w") or die(json_encode(["status" => "erro", "mensagem" => "erro ao criar arquivo"]));
        $linha = "pergunta;resposta\n";
        fwrite($arqPtexto, $linha);
        fclose($arqPtexto);
    }

    $arqPtexto = fopen("Ptexto.txt", "a") or die(json_encode(["status" => "erro", "mensagem" => "erro ao abrir arquivo"]));
    $linha = $pergunta . ";" . $resposta . "\n";
    fwrite($arqPtexto, $linha);
    fclose($arqPtexto);

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
    
    <form id="formCadastroPtexto">
        Pergunta: <input type="text" name="pergunta">
        <br><br>
        Resposta: <input type="text" name="resposta">
        <br><br>
        <input type="submit" value="Cadastrar pergunta">
    </form>

    <div id="mensagemStatus"></div>

<script>
document.getElementById('formCadastroPtexto').addEventListener('submit', function(event) {

    event.preventDefault();

    const dadosForm = new FormData(this);

    fetch('criarPtexto.php', {
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