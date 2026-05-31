<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Listar Perguntas de Múltipla Escolha</h1>

<table>
    <tr>
        <th>Pergunta</th>
        <th>Resposta A</th>
        <th>Resposta B</th>
        <th>Resposta C</th>
        <th>Resposta D</th>
        <th>Ações</th>
    </tr>
<?php
    $arqPergM = @fopen("PergM.txt","r");
    
    if ($arqPergM) {
        $primeiraLinha = true;
        $idLinha = 0; 
        
        while(!feof($arqPergM)) {
            $linha = fgets($arqPergM);
            if ($primeiraLinha) { 
                $primeiraLinha = false; 
                continue;
            }
            if (trim($linha) == "") continue;
            $colunaDados = explode(";", $linha);
            
            echo "<tr id='linha-" . $idLinha . "'>
                    <td>" . $colunaDados[0] . "</td>
                    <td>" . $colunaDados[1] . "</td>
                    <td>" . $colunaDados[2] . "</td>
                    <td>" . $colunaDados[3] . "</td>
                    <td>" . $colunaDados[4] . "</td>
                    <td>
                        <a href='editarPm.php?pergunta=" . urlencode($colunaDados[0]) . "'>Editar</a> | 
                        <a href='#' onclick='excluirPerguntaAJAX(\"" . addslashes($colunaDados[0]) . "\", \"linha-" . $idLinha . "\"); return false;'>Excluir</a>
                    </td>
                  </tr>";
            $idLinha++;
        }
        fclose($arqPergM);
    } else {
        echo "<tr><td colspan='6'>Erro ao abrir arquivo ou nenhuma pergunta cadastrada.</td></tr>";
    }
?>
</table>

<script>
function excluirPerguntaAJAX(pergunta, idElementoLinha) {
    if (confirm("Tem certeza que deseja excluir a pergunta: '" + pergunta + "'?")) {
        
        const dadosForm = new FormData();
        dadosForm.append('pergunta', pergunta);

        fetch('excluirPm.php', {
            method: 'POST',
            body: dadosForm
        })
        .then(response => response.json()) 
        .then(resposta => {
            if (resposta.status === 'sucesso') {
                alert(resposta.mensagem);

                document.getElementById(idElementoLinha).remove();
            } else {
                alert("Erro: " + respopsta.mensagem);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            alert("Erro ao conectar com o servidor.");
        });
    }
}
</script>
</body>
</html>