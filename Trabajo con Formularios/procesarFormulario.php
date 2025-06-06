<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $email = htmlspecialchars($_POST["email"]);
    $mensaje = htmlspecialchars($_POST["mensaje"]);

    if (!empty($nombre) && !empty($email) && !empty($mensaje)) {
        echo "<h2>Formulario enviado con éxito</h2>";
        echo "<p>Nombre: $nombre</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Mensaje: $mensaje</p>";
    } else {
        echo "<h2>Error: Todos los campos son obligatorios.</h2>";
    }
}
?>