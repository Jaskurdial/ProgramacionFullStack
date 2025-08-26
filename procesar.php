<?php
// Verifica si se hizo una petición POST (es decir, si se envió el formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verifica si se subió un archivo correctamente y si se seleccionó un tipo de procesamiento
    if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== 0 || !isset($_POST['tipo'])) {
        http_response_code(400); // Respuesta HTTP de error
        echo "Archivo no válido o tipo no seleccionado.";
        exit;
    }

    // Crea la carpeta "uploads" si no existe, para guardar archivos subidos
    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    // Crea la carpeta "resultados" si no existe, para guardar los archivos procesados
    if (!is_dir("resultados")) {
        mkdir("resultados", 0777, true);
    }

    // Obtiene el tipo de archivo que se quiere procesar (temperatura, viento, etc.)
    $tipo = $_POST['tipo'];

    // Ruta temporal del archivo subido (donde PHP lo guarda temporalmente)
    $tmp = $_FILES['archivo']['tmp_name'];

    // Nombre original del archivo subido (para validarlo más adelante)
    $nombreOriginal = $_FILES['archivo']['name'];

    // Genera un nombre único para guardar el archivo subido en la carpeta "uploads"
    $nombreGuardado = uniqid("csv_") . ".csv";
    $rutaSubida = "uploads/" . $nombreGuardado;

    // Mueve el archivo desde la carpeta temporal a la carpeta "uploads"
    if (!move_uploaded_file($tmp, $rutaSubida)) {
        http_response_code(500); // Error del servidor
        echo "Error al guardar archivo.";
        exit;
    }

    // Carga el archivo PHP correspondiente según el tipo (ej: funciones/temperatura.php)
    require_once "funciones/$tipo.php";

    // Define el nombre del archivo de salida, incluyendo la fecha y hora para que sea único
    $nombreResultado = "resultado_" . $tipo . "_" . date("Ymd_His") . ".csv";
    $rutaResultado = "resultados/" . $nombreResultado;

    // Según el tipo elegido, llama a la función correspondiente para procesar el archivo
    switch ($tipo) {
        case 'temperatura':
            procesarTemperatura($rutaSubida, $rutaResultado, $nombreOriginal);
            break;
        case 'humedad':
            procesarHumedad($rutaSubida, $rutaResultado, $nombreOriginal);
            break;
        case 'lluvia':
            procesarLluvia($rutaSubida, $rutaResultado, $nombreOriginal);
            break;
        case 'viento':
            procesarViento($rutaSubida, $rutaResultado, $nombreOriginal);
            break;
        default:
            http_response_code(400);
            echo "Tipo no reconocido.";
            exit;
    }

    // Verifica si se creó el archivo de resultado correctamente
    if (!file_exists($rutaResultado)) {
        http_response_code(500);
        echo "Error al procesar el archivo.";
        exit;
    }

    // Envía el archivo CSV procesado al navegador para que el usuario lo descargue
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . basename($rutaResultado) . '"');
    header('Content-Length: ' . filesize($rutaResultado));
    readfile($rutaResultado);
    exit;
}
?>
