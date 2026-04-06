<?php
  $msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sigla = $_POST["sigla"];
    $nome = $_POST["nome"];
    $carga = $_POST["carga"];
    echo "sigla: " . $sigla . " nome: " . $nome . " carga: " . $carga;

    if (!file_exists("disciplinas.txt")) {
      $arqDisciplinas = fopen("disciplinas.txt", "w") or die("erro ao criar arquivo");
      $linha = "sigla;nome;carga\n";
      fwrite($arqDisciplinas, $linha);
      fclose($arqDisciplinas);
    }

    $arqDisciplinas = fopen("disciplinas.txt", "a") or die("erro ao criar arquivo");
    $linha = $sigla . ";" . $nome . ";" . $carga . "\n";
    fwrite($arqDisciplinas, $linha);
    fclose($arqDisciplinas);

    $msg = "Cadastro realizado com sucesso.";
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Cadastrar Nova Disciplina</h1>
<form action="disciplinas.php" method="POST">
    Sigla: <input type="text" name="sigla">
    <br><br>
    Nome: <input type="text" name="nome">
    <br><br>
    Carga: <input type="text" name="carga">
    <br><br>
    <input type="submit" value="Cadastrar Nova Disciplina">
</form>
<p><?php echo $msg ?></p>
<br>
</body> 
</html> 