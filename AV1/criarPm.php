<?php
$pergunta: "";
$respostaA: "";
$respostaB: "";
$respostaC: "";
$respostaD: "";

if ($_SERVER('REQUEST_METHOD') == $_POST) {
    $pergunta = $_POST["pergunta"];
    $respostaA = $_POST["respostaA"];
    $respostaB = $_POST["respostaB"];
    $respostaC = $_POST["respostaC"];
    $respostaD = $_POST["respostaD"];

    if (!file_exists("PergM.txt")) {
        $arqPergM = fopen("PergM.txt") or die("erro ao criar arquivo");
        $lnha = "pergunta;respostaA:respostaB;respostaC;respostaD";
        fwrite($arqPergM, $linha)
        fclose($arqPergM)
    }

    $arqPergM = fopen("PergM.txt", "a") or die("erro ao criar arquivo");
    $linha = $pergunta . ";" . $respostaA . ";" . $respostaB .";" . $respostaC .";" . $respostaD . "\n";
    fwrite($arqPergM, $linha)
    fclose($arqPergM)
}
?>

<!DOCTYPE html>
<head></head>
<body>
    <h1>Cadrastrar perguntas e respostas</h1>
    <form action="PergM.txt" method="POST">
        Pergunta: <input type="text" name="pergunta">
        Letra a: <input type="text" name="resposaA">
        Letra b: <input type="text" name="respostaB">
        Letra c: <input type="text" name="respostaC">
        Letra d: <input type="text" name="resposta">
        <input type="submit" value="Cadastrar pergunta">
    </form>
</body>
</html>