<?php
    $msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    $nome = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $email = $_POST["email"];
    echo "nome: " . $nome . " matricula: " . $matricula . " email: " . $email;
   if (!file_exists("alunos.txt")) {
       $arqAlunos = fopen("alunos.txt","w") or die("erro ao criar arquivo");
       $linha = "nome;matricula;email\n";
       fwrite($arqAlunos,$linha);
       fclose($arqAlunos);
   }
   $arqAlunos = fopen("alunos.txt","a") or die("erro ao criar arquivo");

    $linha = $nome . ";" . $matricula . ";" . $email . "\n";
    fwrite($arqAlunos,$linha);
    fclose($arqAlunos);
    $msg = "Deu tudo certo!!!";
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Cadastrar Novo Aluno</h1>
<form action="alunos.php" method="POST">
    Nome: <input type="text" name="nome">
    <br><br>
    Matrícula: <input type="text" name="matricula">
    <br><br>
    E-mail: <input type="text" name="email">
    <br><br>
    <input type="submit" value="Cadastrar Novo Aluno">
</form>
<p><?php echo $msg ?></p>
<br>
</body>
</html>