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
    $msg = "Cadastro realizado com sucesso.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <script>
        function validarAlunos() {
            let nome = document.forms["formCadastro"]["nome"].value;
            let matricula = document.forms["formCadastro"]["matricula"].value;
            let email = document.forms["formCadastro"]["email"].value;

            if (nome.trim() == "" || matricula.trim() == "" || email.trim() == "") {
                alert("Preencha todos os campos obrigatórios.");
                return false;
            }

            if (isNaN(matricula)) {
                alert("A matricula deve conter apenas numeros.");
                return false;
            }

            if (!email.includes('@') || !email.endsWith('.com')) {
                alert("O e=mail deve conter '@' e '.com'")
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<h1>Cadastrar Novo Aluno</h1>
<form name="formCadastro" action="alunos_validacao.php" method="POST" onsubmit="return validarAlunos()">
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