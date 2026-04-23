<?php 
$pergunta = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $excluirPerg = $_POST["pergunta"];

    $linha = file("PergM.txt");
    $novaInfo = "";

    $primeiraLinha = true;

    foreach ($linha as $linha) {

    if ($primeiraLinha) {
        $novaInfo .= $linha;
        $primeiraLinha = false;
        continue;
    }

    $dados = explode(";", trim($linha));

    if ($dados[0] != $excluirPerg) {
        $novaInfo .= $linha;
    }
  }
  
    file_put_contents("PergM.txt", $novaInfo);
    header("Location: listarPm.php");
    exit;

    $msg = "Pergunta excluído com sucesso.";
}

if (isset($_GET["pergunta"])) {
    $pergunta = $_GET["pergunta"];
}

?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Excluir Pergunta</h1>

<p>Tem certeza que deseja excluir esta pergunta?</p>

<form action="excluirPm.php" method="POST">
    <input type="text" name="pergunta" value="<?php echo $pergunta ?>" readonly>
    <br><br>
    <input type="submit" value="Excluir">
</form>
<a href="listarPm.php">Cancelar</a>
</body>
</html>