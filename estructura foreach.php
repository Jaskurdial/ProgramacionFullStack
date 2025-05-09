<!DOCTYPE html>
<html lang="e">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foreach</title>
</head>
<body>

    <h1>Ejercicios con Estructura Foreach</h1>
    <hr>

    <h2>Foreach de nombres</h2>
    <?php
        $nombres = ["Ana", "Luis", "Pedro", "María"];

        foreach ($nombres as $nombre) {
            echo "$nombre <br>";
        }
    ?>
    
    <hr>
    <h2>Foreach de productos</h2>

    <?php

        $productos = [ "Pan" => 40, "Leche" => 60, "Queso" => 120 ];
        foreach ($productos as $producto => $precio) {
            echo "El precio de $producto es $precio <br>";
        }
    ?>
</body>
</html>