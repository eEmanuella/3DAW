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
        } else {
             $resultado = $a / $b;
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