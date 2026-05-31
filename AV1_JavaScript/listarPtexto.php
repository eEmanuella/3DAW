<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Listar Perguntas de Texto</h1>

<table>
    <tr>
        <th>Pergunta</th>
        <th>Resposta</th>
        <th>Ações</th>
    </tr>
<?php
    $arqPtexto = @fopen("Ptexto.txt","r");
    
    if ($arqPtexto) {
        $primeiraLinha = true;
        $idLinha = 0; 
        
        while(!feof($arqPtexto)) {
            $linha = fgets($arqPtexto);
            if ($primeiraLinha) { 
                $primeiraLinha = false; 
                continue;
            }
            if (trim($linha) == "") continue;
            $colunaDados = explode(";", $linha);

            $idTexto = "linha-" . $idLinha;
            
            echo "<tr id='" . $idTexto . "'>
                    <td>" . $colunaDados[0] . "</td>
                    <td>" . $colunaDados[1] . "</td>
                    <td>
                        <a href='editarPtexto.php?pergunta=" . urlencode($colunaDados[0]) . "'>Editar</a> | 
                        <button onclick=\"excluirPerguntaAJAX('" . addslashes($colunaDados[0]) . "', '" . $idTexto . "')\">Excluir</button>
                    </td>
                  </tr>";
            $idLinha++;
        }
        fclose($arqPtexto);
    } else {
        echo "<tr><td colspan='3'>Erro ao abrir arquivo ou nenhuma pergunta cadastrada.</td></tr>";
    }
?>
</table>

<script>
function excluirPerguntaAJAX(pergunta, idElementoLinha) {
    if (confirm("Tem certeza que deseja excluir a pergunta: '" + pergunta + "'?")) {
        
        const dadosForm = new FormData();
        dadosForm.append('pergunta', pergunta);

        fetch('excluirPtexto.php', {
            method: 'POST',
            body: dadosForm
        })
        .then(response => response.json()) 
        .then(resposta => {
            if (resposta.status === 'sucesso') {
                alert(resposta.mensagem);

                document.getElementById(idElementoLinha).remove();
            } else {
                alert("Erro: " + resposta.mensagem);
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