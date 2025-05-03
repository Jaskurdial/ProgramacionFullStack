<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Contraseña</title>
</head>
<body>

<?php
$contraseña = "aaaa";

function validar_contraseña($contraseña) {
    $fortaleza = 0;

    if (strlen($contraseña) >= 8) {
        $fortaleza++;
    } else {
        echo "La contraseña debe de tener 8 o más caracteres.<br>";
    }

    if (preg_match('/[A-Z]/', $contraseña)) {
        $fortaleza++;
    } else {
        echo "La contraseña debe de contener mayúsculas.<br>";
    }

    if (preg_match('/[0-9]/', $contraseña)) {
        $fortaleza++;
    } else {
        echo "La contraseña debe de tener números.<br>";
    }

    if (preg_match('/[\W_]/', $contraseña)) {
        $fortaleza++;
    } else {
        echo "La contraseña debe tener caracteres especiales.<br>";
    }

    if ($fortaleza === 4) {
        $clasificacion = "La fortaleza de la contraseña es fuerte, cumple con todas las necesidades.";
    } elseif ($fortaleza >= 2) {
        $clasificacion = "La fortaleza de la contraseña es estándar, se recomienda añadir otros requerimientos.";
    } else {
        $clasificacion = "Su contraseña es muy vulnerable, se le recomienda cumplir con los otros requerimientos.";
    }

    echo $clasificacion; 
}

validar_contraseña($contraseña);
?>

</body>
</html>