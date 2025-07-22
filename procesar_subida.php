<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $descripcion = htmlspecialchars($_POST['descripcion']);

    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $nombreArchivo = $_FILES['archivo']['name'];
        $tipoArchivo = $_FILES['archivo']['type'];
        $temporal = $_FILES['archivo']['tmp_name'];

        $permitidos = ['image/jpeg', 'image/jpg', 'image/png'];

        if (in_array($tipoArchivo, $permitidos)) {
            $carpeta = "uploads/";
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            $rutaDestino = $carpeta . basename($nombreArchivo);

            if (move_uploaded_file($temporal, $rutaDestino)) {
                $datos = [
                    "nombre" => $nombre,
                    "descripcion" => $descripcion,
                    "archivo" => $rutaDestino
                ];

                $galeria = [];
                $archivoJson = "galeria.json";

                if (file_exists($archivoJson)) {
                    $galeria = json_decode(file_get_contents($archivoJson), true);
                }

                $galeria[] = $datos;
                file_put_contents($archivoJson, json_encode($galeria, JSON_PRETTY_PRINT));

                echo "<h2>Imagen subida con éxito</h2>";
                echo "<a href='index.html'>Subir otra imagen</a><br>";
                echo "<a href='galeria.php'>Ver galería</a>";
            } else {
                echo "Error al guardar el archivo.";
            }
        } else {
            echo "Solo se permiten imágenes JPG o PNG.";
        }
    } else {
        echo "No se ha subido ningún archivo o hubo un error.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
