<?php
$galeria = [];

if (file_exists("galeria.json")) {
    $contenido = file_get_contents("galeria.json");
    $galeria = json_decode($contenido, true);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería de Imágenes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container mt-5">
    <h2 class="mb-4 text-info text-center">Galería de Imágenes</h2>

    <div class="row">
        <?php foreach ($galeria as $foto): ?>
            <div class="col-md-4 mb-4">
                <div class="card bg-dark border border-info text-white h-100 shadow-sm">
                    <img src="<?= htmlspecialchars($foto['archivo']) ?>" class="card-img-top" alt="Imagen" style="object-fit: cover; height: 250px;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($foto['nombre']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($foto['descripcion']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($galeria)): ?>
            <div class="col-12">
                <div class="alert alert-secondary text-center border-info p-4 rounded-4 shadow-sm">
                    No hay imágenes en la galería aún.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="index.html" class="btn btn-outline-info">Subir nueva imagen</a>
    </div>
</div>

</body>
</html>
