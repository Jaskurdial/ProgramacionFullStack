<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== 0 || !isset($_POST['tipo'])) {
        http_response_code(400);
        echo "Archivo no válido o tipo no seleccionado.";
        exit;
    }

    if (!is_dir("uploads")) {
    mkdir("uploads", 0777, true);
    }
    if (!is_dir("resultados")) {
    mkdir("resultados", 0777, true);
    }


    $tipo = $_POST['tipo'];
    $tmp = $_FILES['archivo']['tmp_name'];
    $nombreGuardado = uniqid("csv_") . ".csv";
    $rutaSubida = "uploads/" . $nombreGuardado;

    if (!move_uploaded_file($tmp, $rutaSubida)) {
        http_response_code(500);
        echo "Error al guardar archivo.";
        exit;
    }

    require_once "funciones/$tipo.php";

    $nombreResultado = "resultado_" . $tipo . "_" . date("Ymd_His") . ".csv";
    $rutaResultado = "resultados/" . $nombreResultado;

    switch ($tipo) {
        case 'temperatura':
            procesarTemperatura($rutaSubida, $rutaResultado);
            break;
        case 'humedad':
            procesarHumedad($rutaSubida, $rutaResultado);
            break;
        case 'lluvia':
            procesarLluvia($rutaSubida, $rutaResultado);
            break;
        case 'viento':
            procesarViento($rutaSubida, $rutaResultado);
            break;
        default:
            http_response_code(400);
            echo "Tipo no reconocido.";
            exit;
    }

    if (!file_exists($rutaResultado)) {
        http_response_code(500);
        echo "Error al procesar el archivo.";
        exit;
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . basename($rutaResultado) . '"');
    header('Content-Length: ' . filesize($rutaResultado));
    readfile($rutaResultado);
    exit;
}
?>
