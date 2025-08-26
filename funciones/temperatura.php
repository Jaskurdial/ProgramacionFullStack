<?php
// Función que procesa un archivo CSV de temperatura, filtrando por estaciones de Colonia
function procesarTemperatura($entrada, $salida, $nombreOriginal) {

    // Verifica si el nombre del archivo contiene las palabras "temperatura" o "temp"
    // Si no las contiene, se asume que el archivo no es válido para este tipo de dato
    if (
        stripos($nombreOriginal, 'temperatura') === false &&
        stripos($nombreOriginal, 'temp') === false
    ) {
        echo "Archivo inválido para temperatura.";
        exit;
    }

    // Abre el archivo de entrada en modo lectura
    $in = fopen($entrada, 'r');

    // Abre o crea el archivo de salida en modo escritura
    $out = fopen($salida, 'w');

    // Escribe el BOM UTF-8 para evitar errores con tildes y caracteres especiales en Excel
    fwrite($out, "\xEF\xBB\xBF");

    // Lee y descarta la primera línea del archivo (encabezado original)
    fgetcsv($in, 0, ';');

    // Escribe el nuevo encabezado del archivo procesado
    fputcsv($out, ['Fecha', 'Departamento', 'Promedio (°C)', 'Nivel'], ';');

    // Arreglo para agrupar los datos por fecha y estación
    $datos = [];

    // Bucle que recorre cada línea del CSV original
    while (($fila = fgetcsv($in, 0, ';')) !== false) {

        // Se salta la línea si no tiene al menos 3 campos o si alguno está vacío
        if (count($fila) < 3 || empty($fila[0]) || empty($fila[1]) || empty($fila[2])) continue;

        // Guarda la fecha y hora completa
        $fechaHora = $fila[0];

        // Limpia el nombre de la estación y elimina posibles sufijos como " G3"
        $estacion = trim(preg_replace('/\s*G3$/', '', $fila[1]));

        // Filtra solo los datos que contengan "colonia" en el nombre de la estación
        if (stripos($estacion, 'colonia') === false) continue;

        // Convierte el valor a decimal (reemplaza coma por punto si es necesario)
        $valor = floatval(str_replace(',', '.', $fila[2]));

        // Extrae solo la fecha (sin hora)
        $fecha = substr($fechaHora, 0, 10);

        // Crea una clave única con la fecha y estación (para agrupar)
        $clave = $fecha . '|' . $estacion;

        // Si la clave no existe aún en el array, se inicializa
        if (!isset($datos[$clave])) {
            $datos[$clave] = ['suma' => 0, 'cantidad' => 0];
        }

        // Se acumula el valor y se cuenta cuántos registros hay por fecha y estación
        $datos[$clave]['suma'] += $valor;
        $datos[$clave]['cantidad']++;
    }

    // Recorre el arreglo de datos agrupados para calcular promedios
    foreach ($datos as $clave => $info) {
        list($fecha, $departamento) = explode('|', $clave);

        // Calcula el promedio de temperatura para esa fecha y estación
        $prom = $info['suma'] / $info['cantidad'];

        // Determina el nivel cualitativo según el valor del promedio
        $nivel = nivelTemperatura($prom);

        // Escribe la línea procesada en el nuevo archivo CSV
        fputcsv($out, [$fecha, $departamento, round($prom, 2), $nivel], ';');
    }

    // Cierra ambos archivos
    fclose($in);
    fclose($out);
}

// Función que asigna un nivel cualitativo según la temperatura promedio
function nivelTemperatura($valor) {
    if ($valor <= 10) return 'Frío';
    if ($valor <= 15) return 'Fresco';
    if ($valor <= 20) return 'Templado';
    if ($valor <= 25) return 'Cálido';
    return 'Caluroso';
}
?>
