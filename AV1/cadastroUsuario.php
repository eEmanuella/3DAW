<?php
$msg = "";
$usuario = "";
$senha = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    if (!file_exists("usuarios.txt")) {
        $arqUsuario = fopen("usuarios.txt", "w") or die("erro ao criar arquivo");
        $linha = "usuario;senha\n";
        fwrite($arqUsuario, $linha);
        fclose($arqUsuario);
    }

    $arqUsuario = fopen("usuarios.txt", "a") or die("erro ao criar arquivo");
    $linha = $usuario . ";" . $senha . "\n";
    fwrite($arqUsuario, $linha);
    fclose($arqUsuario);

    $msg = "Cadastro realizado com sucesso.";
}
?>

<!DOCTYPE html>
<head></head>
<body>
    <h1>Cadastrar usuário</h1>
    <form action="cadastroUsuario.php" method='POST'>
        Usuário: <input type="text" name="usuario">
        <br><br>
        Senha: <input type="password" name="senha">
        <br><br>
        <input type="submit" value="Cadastrar usuário">
    </form>
<p><?php echo $msg ?></p>
</body>
</html>