<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For</title>
</head>
<body>

    <h1>Ejercicios con Estructura For</h1>
    
    <hr>

    <h2>Numeros del 1 al 100</h2>

    <?php
        for ($i = 1; $i <= 100; $i++) {
            echo $i .  " ";

            if ($i % 15 == 0) {
                echo "<br>";
                }
        }
    ?>

    <hr>

    <h2>Tabla del 5</h2>

    <?php
        for ($i = 1; $i <= 10; $i++) {
        $resultado = 5 * $i;
        echo "5 × $i = $resultado<br>";
        }
    ?>

    <hr>

    <h2>Suma de los primeros 50 números pares</h2>

    <?php
        $suma = 0;
        for ($i = 2; $i <= 100; $i += 2) {
            $suma += $i;
        }
        echo "El resultado de la suma es: $suma";
    ?>
    
</body>
</html>