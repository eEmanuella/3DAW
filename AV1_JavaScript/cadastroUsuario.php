<?php
$msg = "";
$usuario = "";
$senha = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header('Content-Type: application/json');

    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $senha = isset($_POST["senha"]) ? $_POST["senha"] : "";

    if (empty($usuario) || empty($senha)) {
        echo json_encode(["status" => "erro", "mensagem" => "Preencha todos os campos."]);
        exit;
    }

    if (!file_exists("usuarios.txt")) {
        $arqUsuario = @fopen("usuarios.txt", "w");
        if (!$arqUsuario) {
            echo json_encode(["status" => "erro", "mensagem" => "Erro ao criar o arquivo."]);
            exit;
        }
        $linha = "usuario;senha\n";
        fwrite($arqUsuario, $linha);
        fclose($arqUsuario);
    }

    $arqUsuario = @fopen("usuarios.txt", "a");
    if (!$arqUsuario) {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao abrir o arquivo."]);
        exit;
    }

    $linha = $usuario . ";" . $senha . "\n";
    fwrite($arqUsuario, $linha);
    fclose($arqUsuario);

    echo json_encode(["status" => "sucesso", "mensagem" => "Cadastro realizado com sucesso."]);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h1>Cadastrar usuário</h1>
    
    <form id="formCadastroUsuario">
        Usuário: <input type="text" name="usuario">
        <br><br>
        Senha: <input type="password" name="senha">
        <br><br>
        <input type="submit" value="Cadastrar usuário">
    </form>

    <div id="mensagemStatus"></div>

<script>
document.getElementById('formCadastroUsuario').addEventListener('submit', function(event) {

    event.preventDefault();

    const dadosForm = new FormData(this);

    fetch('cadastroUsuario.php', {
        method: 'POST',
        body: dadosForm
    })
    .then(response => response.json())
    .then(resposta => {
        const divMensagem = document.getElementById('mensagemStatus');
        
        if (resposta.status === 'sucesso') {
            divMensagem.innerHTML = "<p>" + resposta.mensagem + "</p>";
            this.reset();
        } else {
            divMensagem.innerHTML = "<p>Erro: " + resposta.mensagem + "</p>";
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
        alert("Erro ao conectar com o servidor.");
    });
});
</script>
</body>
</html>