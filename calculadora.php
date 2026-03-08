<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $a = $_POST["a"];
        $b = $_POST["b"];
        $o = $_POST["operacao"];

        if ($o == "soma") {
            $resultado = $a + $b;
        } elseif ($o == "subtracao") {
             $resultado = $a - $b;
        } elseif ($o == "multiplicacao") {
             $resultado = $a * $b;
        } elseif ($o == "divisao") {
            if ($b != 0) {
                 $resultado = $a / $b;
            } else {
                $resultado = "Erro.";
            }
        } elseif ($o == "potenciacao") {
            $resultado = pow($a, $b);
        } elseif ($o == "radiciacao") {
            if ($b !=0 && $b > 0) {
                $resultado = pow($a, 1/$b);
            } else {
                $resultado = "Erro.";
            }
        }

}


?>
<!DOCTYPE html>
<html>
<body>
<h1><?php echo 'Minha Calculadora!';?></h1>

<form method='POST' action='calculadora.php'>
    a:<input type=text name='a'><br>
    b:<input type=text name='b'>
    <select name="operacao">
        <option value="soma">Somar</option>
        <option value="subtracao">Subtrair</option>
        <option value="multiplicacao">Multiplicar</option>
        <option value="divisao">Dividir</option>
        <option value="potenciacao">Potencia</option>
        <option value="radiciacao">Raiz</option>
    </select>
    <br><br>
    <input type="submit" value="Calcular">
</form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<h3>Resultado: $resultado</h3>"; 
}
?>
    
</body>
</html>