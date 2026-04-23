<?php
$msg = "";
$pergunta = "";
$resposta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pergunta = $_POST["pergunta"];
    $novaResposta = $_POST["resposta"];

    $linhas = file("Ptexto.txt");
    $novaInfo = "";

    $primeiraLinha = true;
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
        } else {
            $novaInfo .= $linha . "\n";
        }
    }

    file_put_contents("Ptexto.txt", $novaInfo);
    $msg = "Resposta atualizada com sucesso.";
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
<h1>Editar Aluno</h1>
<form action="editarPtexto.php" method="POST">
    Pergunta: <input type="text" name="pergunta" value="<?php echo $pergunta ?>" readonly>
    <br><br>
    Resposta: <input type="text" name="resposta" value="<?php echo $resposta ?>">
    <input type="submit" value="Salvar Alterações">
</form>
<p><?php echo $msg ?></p>
</body>
</html>