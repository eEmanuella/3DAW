<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Listar Perguntas de Múltipla Escolha</h1>

<table>
    <tr><th>Pergunta </th>
    <th>Resposta A</th>
    <th>Resposta B</th>
    <th>Resposta C</th>
    <th>Resposta D</th>
    <th>Ações</th></tr>
<?php
   $arqPergM = fopen("PergM.txt","r") or die("erro ao abrir arquivo");
 
   $primeiraLinha = true;
   while(!feof($arqPergM)) {
        $linha = fgets($arqPergM);
        if ($primeiraLinha) { 
            $primeiraLinha = false; 
            continue;
        }
        if (trim($linha) == "") continue;
        $colunaDados = explode(";", $linha);
        
        echo "<tr>
               <td>" . $colunaDados[0] . "</td>
               <td>" . $colunaDados[1] . "</td>
               <td>" . $colunaDados[2] . "</td>
               <td>" . $colunaDados[3] . "</td>
               <td>" . $colunaDados[4] . "</td>
               <td><a href='editarPm.php?pergunta=" . $colunaDados[0] . "'>Editar</a></td>
              </tr>";
    }
 
   fclose($arqPergM);
?>
</table>
</body>
</html>