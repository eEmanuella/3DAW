<?php
$msg = "";
$nome = "";
$email = "";
$matricula = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novoNome = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $novoEmail = $_POST["email"];

    $linhas = file("alunos.txt");
    $novaInfo = "";

    $primeiraLinha = true;
    foreach ($linhas as $linha) {
        if ($primeiraLinha) {
            $novaInfo .= $linha;
            $primeiraLinha = false;
            continue;
        }
        $colunaDados = explode(";", trim($linha));
        if (count($colunaDados) < 3) continue;

        if ($colunaDados[1] == $matricula) {
            $novaInfo .= $novoNome . ";" . $matricula . ";" . $novoEmail . "\n";
        } else {
            $novaInfo .= $linha . "\n";
        }
    }

    file_put_contents("alunos.txt", $novaInfo);
    $msg = "Aluno atualizado com sucesso.";
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["matricula"])) {
    $matricula = $_GET["matricula"];
    $linhas = file("alunos.txt");

    $primeiraLinha = true;
    foreach ($linhas as $linha) {
        if ($primeiraLinha) { $primeiraLinha = false; continue; }
        if (trim($linha) == "") continue;

        $colunaDados = explode(";", trim($linha));

        if ($colunaDados[1] == $matricula) {
            $nome = $colunaDados[0];
            $email = $colunaDados[2];
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
<form action="editarAluno.php" method="POST">
    Nome: <input type="text" name="nome" value="<?php echo $nome ?>">
    <br><br>
    Matrícula: <input type="text" name="matricula" value="<?php echo $matricula ?>" readonly>
    <br><br>
    E-mail: <input type="text" name="email" value="<?php echo $email ?>">
    <br><br>
    <input type="submit" value="Salvar Alterações">
</form>
</body>
</html>