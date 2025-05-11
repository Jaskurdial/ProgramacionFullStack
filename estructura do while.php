<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Do while</title>
</head>
<body>
    
    <h1>Ejercicios con Do While</h1>

    <hr>

    <h2>Imprimir los números del 1 al 5 al menos una vez</h2>

    <?php
        $numeros = []; 

        do {
            $dado = rand(1, 6); 

            if ($dado >= 1 && $dado <= 5 && !in_array($dado, $numeros)) {
                $numeros[] = $dado;
                echo "<strong>Resultado dado por primera vez: $dado</strong><br>";
            }
            else {
                echo "Resultado dado: $dado<br>";
            }
        } while (count($numeros) < 5); 

        echo "<br>¡Han salido todos los números del 1 al 5 al menos una vez!";
    ?>

    <hr>

    <h2>Simula solicitar al usuario un número hasta que ingrese un número mayor que 100.</h2>

    <?php
        $numero = 0; 

        echo "¡Bienvenido!<br>";
        echo "Por favor, ingrese un número<br><br>";

        do {
            $dado = rand(1, 150); 

            if ($dado > 100) {
                echo "El número ingresado es: $dado. ¡Número válido!<br>";
            } else {
                echo "El número ingresado es: $dado. ¡Número inválido!<br>";
            }
        } while ($dado < 100);
    ?>

</body>
</html>