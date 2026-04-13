<?php
$pergunta: "";
$resposta: "";

if ($_SERVER('REQUEST_METOD') == $_POST) {
    $pergunta = $_POST["pergunta"];
    $resposta = $_POST["resposta"];

    if (!file_exists("Ptexto.txt")) {
        $arqPtexto = fopen("Ptexto.txt") or die("erro ao criar arquivo");
        $linha = "pergunta;resposta";
        fwrite($arqPtexto, $linha)
        fclose($arqPtexto)
    }

    $arqPtexto = fopen("Ptexto.txt", "a") or die("erro ao criar arquivo")
    $linha = $pergunta . ";" . $resposta "\n";
    fwrite($arqPtexto, $linha)
    fclose($arqPtexto)
}
?>

<!DOCTYPE html>
<head></head>
<body>
    <h1>Cadastrar perguntas e repostas</h1>
    <form action="Ptexto.txt" method="POST">
        Pergunta: <input type="text" name="pergunta">
        <br><br>
        Resposta: <input type="text" name="resposta">
        <br><br>
        <input type="submit" value="Cadastrar pergunta">
    </form>
</body>
</html>
