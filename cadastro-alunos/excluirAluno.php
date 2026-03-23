<?php 
$msg = "";
$matricula = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $excluirMat = $_POST["matricula"];

    $linha = file("alunos.txt");
    $novaInfo = "";

    $primeiraLinha = true;

    foreach ($linha as $linha) {

    if ($primeiraLinha) {
        $novaInfo .= $linha;
        $primeiraLinha = false;
        continue;
    }

    $dados = explode(";", trim($linha));

    if ($dados[1] != $excluirMat) {
        $novaInfo .= $linha;
    }
  }
  
    file_put_contents("alunos.txt", $novaInfo);
    header("Location: listarAlunos.php");
    exit;

    $msg = "Aluno excluído com sucesso.";
}

if (isset($_GET["matricula"])) {
    $matricula = $_GET["matricula"];
}

?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Excluir Aluno</h1>

<p>Tem certeza que deseja excluir este aluno?</p>

<form action="excluirAluno.php" method="POST">
    <input type="text" name="matricula" value="<?php echo $matricula ?>" readonly>
    <br><br>
    <input type="submit" value="Excluir">
</form>

<a href="listarAluno.php">Cancelar</a>

</body>
</html>