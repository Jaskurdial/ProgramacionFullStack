<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Alertas Meteorológicas</title>
</head>
<body>
    <h2>Datos Meteorológicos Procesados</h2>
    <p>El sistema ha analizado los datos meteorológicos proporcionados.</p>
    
    <?php
$temperatura = 25; // Temperatura en °C
$humedad = 80; // Humedad en %
$viento = 50; // Velocidad del viento en km/h
$precipitacion = 30; // Precipitación en %

function generarAlerta($temperatura, $humedad, $viento, $precipitacion) {
    if ($temperatura >= 35) {
        echo "Hace mucho calor. Recomendación: Mantente hidratado e intenta evitar el sol.<br>";
    } elseif ($temperatura <= 0) {
        echo "Hace mucho frío. Recomendación: Usa ropa abrigada y mantente en la comodidad de su casa si es posible.<br>";
    }

    if ($humedad >= 90) {
        echo "Humedad muy alta. Recomendación: Usa ropa ligera y fresca.<br>";
    }

    if ($viento >= 60) {
        echo "Viento muy fuerte. Recomendación: Evita actividades al aire libre.<br>";
    }

    if ($precipitacion >= 50) {
        echo "Lluvia intensa. Recomendación: Lleva paraguas y evita zonas inundadas.<br>";
    }

    if ($temperatura > 0 && $temperatura < 35 && $humedad < 90 && $viento < 60 && $precipitacion < 50) {
        echo "Clima normal. Recomendación: Es un buen día para actividades al aire libre.<br>";
    }
}

generarAlerta($temperatura, $humedad, $viento, $precipitacion);
?>

</body>
</html>