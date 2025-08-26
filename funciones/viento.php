<?php
// Función principal para procesar un archivo CSV de datos de viento
function procesarViento($entrada, $salida, $nombreOriginal) {

    // Verifica si el nombre del archivo contiene "viento" o "wind"
    // Si no es así, se asume que es un archivo incorrecto
    if (
        stripos($nombreOriginal, 'viento') === false &&
        stripos($nombreOriginal, 'wind') === false
    ) {
        echo "Archivo inválido para viento.";
        exit;
    }

    // Abre el archivo de entrada en modo lectura
    $in = fopen($entrada, 'r');

    // Crea el archivo de salida en modo escritura
    $out = fopen($salida, 'w');    

    // Escribe el BOM UTF-8 para evitar errores con tildes en Excel
    fwrite($out, "\xEF\xBB\xBF");

    // Omite la primera línea del CSV original (encabezado)
    fgetcsv($in, 0, ';');

    // Escribe un nuevo encabezado en el archivo procesado
    fputcsv($out, ['Fecha', 'Departamento', 'Promedio (km/h)', 'Nivel'], ';');

    // Arreglo para agrupar datos por fecha y estación
    $datos = [];

    // Recorre cada fila del archivo CSV original
    while (($fila = fgetcsv($in, 0, ';')) !== false) {
        // Salta líneas inválidas o incompletas
        if (count($fila) < 3 || empty($fila[0]) || empty($fila[1]) || empty($fila[2])) continue;

        // Toma la fecha y hora completa
        $fechaHora = $fila[0];

        // Limpia el nombre de la estación y elimina el sufijo "G3" si está presente
        $estacion = trim(preg_replace('/\s*G3$/', '', $fila[1]));

        // Solo se procesan datos de estaciones que contengan "colonia"
        if (stripos($estacion, 'colonia') === false) continue;

        // Convierte el valor de velocidad de viento a formato decimal
        $valor = floatval(str_replace(',', '.', $fila[2]));

        // Extrae solo la fecha sin hora
        $fecha = substr($fechaHora, 0, 10);

        // Crea una clave única con fecha y estación para agrupar
        $clave = $fecha . '|' . $estacion;

        // Si no existe esa clave aún, se inicializa
        if (!isset($datos[$clave])) {
            $datos[$clave] = ['suma' => 0, 'cantidad' => 0];
        }

        // Acumula el valor y cuenta el número de registros
        $datos[$clave]['suma'] += $valor;
        $datos[$clave]['cantidad']++;
    }

    // Recorre los datos agrupados para calcular los promedios
    foreach ($datos as $clave => $info) {
        list($fecha, $departamento) = explode('|', $clave);

        // Calcula el promedio de velocidad de viento
        $prom = $info['suma'] / $info['cantidad'];

        // Determina el nivel cualitativo según el promedio
        $nivel = nivelViento($prom);

        // Escribe la fila procesada en el archivo de salida
        fputcsv($out, [$fecha, $departamento, round($prom, 2), $nivel], ';');
    }

    // Cierra los archivos de entrada y salida
    fclose($in);
    fclose($out);
}

// Función que asigna un nivel de viento en base al valor promedio
function nivelViento($valor) {
    if ($valor < 5) return 'Muy ligero';
    if ($valor < 20) return 'Ligero';
    if ($valor < 40) return 'Moderado';
    if ($valor < 70) return 'Fuerte';
    return 'Muy fuerte';
}
?>
