<?php
$msg = "";
$pergunta = "";
$resposta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pergunta = $_POST["pergunta"];
    $resposta = $_POST["resposta"];

    if (!file_exists("Ptexto.txt")) {
        $arqPtexto = fopen("Ptexto.txt", "w") or die("erro ao criar arquivo");
        $linha = "pergunta;resposta\n";
        fwrite($arqPtexto, $linha);
        fclose($arqPtexto);
    }

    $arqPtexto = fopen("Ptexto.txt", "a") or die("erro ao criar arquivo");
    $linha = $pergunta . ";" . $resposta . "\n";
    fwrite($arqPtexto, $linha);
    fclose($arqPtexto);

    $msg = "Cadastro realizado com sucesso.";
}
?>

<!DOCTYPE html>
<head></head>
<body>
    <h1>Cadastrar perguntas e repostas</h1>
    <form action="criarPtexto.php" method='POST'>
        Pergunta: <input type="text" name="pergunta">
        <br><br>
        Resposta: <input type="text" name="resposta">
        <br><br>
        <input type="submit" value="Cadastrar pergunta">
    </form>
<p><?php echo $msg ?></p>
</body>
</html>
