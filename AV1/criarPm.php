<?php
$pergunta = "";
$respostaA = "";
$respostaB = "";
$respostaC = "";
$respostaD = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pergunta = $_POST["pergunta"];
    $respostaA = $_POST["respostaA"];
    $respostaB = $_POST["respostaB"];
    $respostaC = $_POST["respostaC"];
    $respostaD = $_POST["respostaD"];

    if (!file_exists("PergM.txt")) {
        $arqPergM = fopen("PergM.txt", "w") or die("erro ao criar arquivo");
        $linha = "pergunta;respostaA:respostaB;respostaC;respostaD\n";
        fwrite($arqPergM, $linha);
        fclose($arqPergM);
    }

    $arqPergM = fopen("PergM.txt", "a") or die("erro ao criar arquivo");
    $linha = $pergunta . ";" . $respostaA . ";" . $respostaB .";" . $respostaC .";" . $respostaD . "\n";
    fwrite($arqPergM, $linha);
    fclose($arqPergM);
}
?>

<!DOCTYPE html>
<head></head>
<body>
    <h1>Cadrastrar perguntas e respostas</h1>
    <form action="criarPm.php" method='POST'>
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
</body>
</html>