<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Listar Perguntas de Texto</h1>

<table>
    <tr><th>Pergunta</th>
    <th>Resposta</th>
    <th>Ações</th></tr>
<?php
   $arqPtexto = fopen("Ptexto.txt","r") or die("erro ao abrir arquivo");
 
   $primeiraLinha = true;
   while(!feof($arqPtexto)) {
        $linha = fgets($arqPtexto);
        if ($primeiraLinha) { 
            $primeiraLinha = false; 
            continue;
        }
        if (trim($linha) == "") continue;
        $colunaDados = explode(";", $linha);
        
        echo "<tr>
               <td>" . $colunaDados[0] . "</td>
               <td>" . $colunaDados[1] . "</td>
               <td><a href='editarPtexto.php?pergunta=" . $colunaDados[0] . "'>Editar</a></td>
              </tr>";
    }
 
   fclose($arqPtexto);
?>
</table>
</body>
</html>