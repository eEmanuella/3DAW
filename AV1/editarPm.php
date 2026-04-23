<?php
$msg = "";
$pergunta = "";
$respostaA = "";
$respostaB = "";
$respostaC = "";
$respostaD = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pergunta = $_POST["pergunta"];
    $novaA = $_POST["respostaA"];
    $novaB = $_POST["respostaB"];
    $novaC = $_POST["respostaC"];
    $novaD = $_POST["respostaD"];

    $linhas = file("PergM.txt");
    $novaInfo = "";

    $primeiraLinha = true;
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
        } else {
            $novaInfo .= $linha . "\n";
        }
    }

    file_put_contents("PergM.txt", $novaInfo);
    $msg = "Respostas atualizadas com sucesso.";
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
<h1>Editar Aluno</h1>
<form action="editarPm.php" method="POST">
    Pergunta: <input type="text" name="pergunta" value="<?php echo $pergunta ?>" readonly>
    <br><br>
    Resposta A: <input type="text" name="respostaA" value="<?php echo $respostaA ?>">
    <br><br>
    Resposta B: <input type="text" name="respostaB" value="<?php echo $respostaB ?>">
    <br><br>
    Resposta C: <input type="text" name="respostaC" value="<?php echo $respostaC ?>">
    <br><br>
    Resposta D: <input type="text" name="respostaD" value="<?php echo $respostaD ?>">
    <input type="submit" value="Salvar Alterações">
</form>
<p><?php echo $msg ?></p>
</body>
</html>