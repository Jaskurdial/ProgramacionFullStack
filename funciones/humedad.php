<?php
// Función principal que procesa un archivo de humedad
// Parámetros:
// $entrada = ruta del archivo CSV subido
// $salida = ruta donde se va a guardar el nuevo CSV generado
// $nombreOriginal = nombre original del archivo subido (para validarlo)
function procesarHumedad($entrada, $salida, $nombreOriginal) {

    // Verifica que el nombre del archivo contenga "humedad" o "hum" (sin importar mayúsculas o minúsculas)
    // Si no los contiene, entonces se considera que el archivo no es válido para humedad y se corta la ejecución
    if (
        stripos($nombreOriginal, 'humedad') === false &&
        stripos($nombreOriginal, 'hum') === false
    ) {
        echo "Archivo inválido para humedad.";
        exit;
    }

    // Abre el archivo de entrada en modo lectura
    $in = fopen($entrada, 'r');

    // Abre (o crea) el archivo de salida en modo escritura
    $out = fopen($salida, 'w');

    // Escribe el BOM UTF-8 al principio del archivo de salida para que Excel muestre correctamente los acentos y eñes
    fwrite($out, "\xEF\xBB\xBF");

    // Lee y descarta la primera línea del archivo original (la cabecera del CSV que subieron)
    fgetcsv($in, 0, ';');

    // Escribe una nueva cabecera personalizada en el archivo de salida
    fputcsv($out, ['Fecha', 'Departamento', 'Promedio (% o mr)', 'Nivel'], ';');

    // Crea un arreglo para guardar la suma y cantidad de valores por cada fecha y departamento
    $datos = [];

    // Recorre cada fila del archivo CSV
    while (($fila = fgetcsv($in, 0, ';')) !== false) {

        // Si la fila tiene menos de 3 columnas, o alguna está vacía, se salta
        if (count($fila) < 3 || empty($fila[0]) || empty($fila[1]) || empty($fila[2])) continue;

        // Extrae la fecha y hora completa (columna 0)
        $fechaHora = $fila[0];

        // Extrae el nombre de la estación (columna 1), quitando el texto " G3" del final si existe y limpiando espacios
        $estacion = trim(preg_replace('/\s*G3$/', '', $fila[1]));

        // Filtra solo los datos que provienen de estaciones que contienen la palabra "colonia"
        // Si no dice "colonia" en el nombre de la estación, se salta esa fila
        if (stripos($estacion, 'colonia') === false) continue;

        // Convierte el valor numérico de la humedad (columna 2) a formato decimal
        // Reemplaza la coma por punto en caso de que venga así (ej: "85,5" => "85.5")
        $valor = floatval(str_replace(',', '.', $fila[2]));

        // Extrae solo la fecha (ej: "2025-08-01") quitando la hora
        $fecha = substr($fechaHora, 0, 10);

        // Genera una clave compuesta por fecha y estación (para agrupar)
        $clave = $fecha . '|' . $estacion;

        // Si no existe esa clave aún, se inicializa
        if (!isset($datos[$clave])) {
            $datos[$clave] = ['suma' => 0, 'cantidad' => 0];
        }

        // Acumula el valor de humedad y cuenta una nueva medición
        $datos[$clave]['suma'] += $valor;
        $datos[$clave]['cantidad']++;
    }

    // Ya con todos los datos agrupados, se recorre cada grupo para calcular el promedio y clasificar el nivel
    foreach ($datos as $clave => $info) {
        // Se separa la clave en fecha y estación (departamento)
        list($fecha, $departamento) = explode('|', $clave);

        // Se calcula el promedio para esa fecha y estación
        $prom = $info['suma'] / $info['cantidad'];

        // Se determina el nivel de humedad según el promedio
        $nivel = nivelHumedad($prom);

        // Se escribe la línea correspondiente al resultado (ya formateado)
        fputcsv($out, [$fecha, $departamento, round($prom, 2), $nivel], ';');
    }

    // Cierra ambos archivos (buena práctica)
    fclose($in);
    fclose($out);
}

// Esta función toma un valor numérico de humedad promedio y devuelve una categoría (nivel)
function nivelHumedad($valor) {
    if ($valor <= 30) return 'Muy Baja';
    if ($valor <= 50) return 'Baja';
    if ($valor <= 70) return 'Moderada';
    if ($valor <= 85) return 'Alta';
    return 'Muy Alta';
}
?>
