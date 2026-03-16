<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Listar Alunos</h1>

<table>
    <tr><th>Nome</th><th>Matrícula</th><th>E-mail</th><th>Ações</th></tr>
<?php
   $arqAluno = fopen("alunos.txt","r") or die("erro ao abrir arquivo");
 
   $primeiraLinha = true;
   while(!feof($arqAluno)) {
        $linha = fgets($arqAluno);
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
            <td><a href='editarAluno.php?matricula=" . $colunaDados[1] . "'>Editar</a></td>
              </tr>";
    }
 
   fclose($arqAluno);
?>
</table>
</body>
</html>