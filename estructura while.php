<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Ejercicios con Estructura While</h1>
    
    <hr>

    <h2>Contar del 10 al 1</h2>

    <?php
        $i = 10;

        while ($i >= 1) {
            echo "$i ";
            $i--;
        }
    ?>

    <hr>

    <h2>Mostrar todos los múltiplos de 3 menores a 50</h2>

    <?php
        $i = 3;

        while ($i < 50) {
            echo "$i ";
            $i += 3;
        }
    ?>

    <hr>

    <h2>Sumar los números del 1 al 10 y mostrar el total</h2>

    <?php
        $i = 1;
        $suma = 0;

        while ($i <= 10) {
            $suma += $i;
            $i++;
        }

        echo "La suma de los números del 1 al 10 es: $suma";
    ?>

</body>
</html>