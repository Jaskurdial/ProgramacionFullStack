<?php
function procesarTemperatura($entrada, $salida) {
    $in = fopen($entrada, 'r');
    $out = fopen($salida, 'w');
    fwrite($out, "\xEF\xBB\xBF");

    fgetcsv($in, 0, ';');
    fputcsv($out, ['Fecha', 'Departamento', 'Promedio (°C)', 'Nivel'], ';');

    $datos = [];

    while (($fila = fgetcsv($in, 0, ';')) !== false) {
        if (count($fila) < 3 || empty($fila[0]) || empty($fila[1]) || empty($fila[2])) continue;

        $fechaHora = $fila[0];
        $estacion = trim(preg_replace('/\s*G3$/', '', $fila[1]));
        $valor = floatval(str_replace(',', '.', $fila[2]));
        $fecha = substr($fechaHora, 0, 10);
        $clave = $fecha . '|' . $estacion;

        if (!isset($datos[$clave])) $datos[$clave] = ['suma' => 0, 'cantidad' => 0];
        $datos[$clave]['suma'] += $valor;
        $datos[$clave]['cantidad']++;
    }

    foreach ($datos as $clave => $info) {
        list($fecha, $departamento) = explode('|', $clave);
        $prom = $info['suma'] / $info['cantidad'];
        $nivel = nivelTemperatura($prom);
        fputcsv($out, [$fecha, $departamento, round($prom, 2), $nivel], ';');
    }

    fclose($in);
    fclose($out);
}

function nivelTemperatura($valor) {
    if ($valor < 10) return 'Frío';
    if ($valor <= 25) return 'Templado';
    return 'Caluroso';
}
?>
