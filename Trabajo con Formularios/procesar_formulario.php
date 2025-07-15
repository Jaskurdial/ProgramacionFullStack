<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    //htmlspecialchars se utiiliza para sanitizar los datos y evitar problemas de seguridad como la inyección de código.
    $nombre = htmlspecialchars($_POST['nombre']);
    $email = htmlspecialchars($_POST['email']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    // Validar y procesar los datos
    if (!empty($nombre) && !empty($email) && !empty($mensaje)) {
        // Aquí puedes agregar código para almacenar los datos en una base de datos, enviar un correo, etc.
        
       // Crear un array con los datos
       $datos = array(
        'nombre' => $nombre,
        'email' => $email,
        'mensaje' => $mensaje,
        'fecha' => date('Y-m-d H:i:s')
    );

    // Definir la ruta del archivo JSON
    $archivo_json = 'datos_formulario.json';

    // Leer el contenido actual del archivo JSON si existe
    if (file_exists($archivo_json)) {
        $contenido_actual = file_get_contents($archivo_json);
        $array_datos = json_decode($contenido_actual, true);
    } else {
        // Si el archivo no existe, inicializar un array vacío
        $array_datos = array();
    }

    // Agregar los nuevos datos al array
    $array_datos[] = $datos;

    // Guardar los datos en el archivo JSON
    file_put_contents($archivo_json, json_encode($array_datos, JSON_PRETTY_PRINT));

    // Confirmar que los datos se han guardado
    echo "<h2>Datos recibidos y guardados correctamente:</h2>";
    echo "Nombre: " . $nombre . "<br>";
    echo "Correo Electrónico: " . $email . "<br>";
    echo "Mensaje: " . $mensaje . "<br>";
} else {
    echo "Todos los campos son obligatorios.";
}
} else {
echo "Método no permitido.";
}
?>