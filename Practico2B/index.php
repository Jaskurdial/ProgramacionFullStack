<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Uruguayo 1° División - TABLA APERTURA</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<?php
$equipos = [
    ["sigla" => "DEF", "escudo" => "defensores.png", "PG" => 2, "PE" => 0, "PP" => 0, "GF" => 7, "GC" => 1],
    ["sigla" => "PEÑ", "escudo" => "penarol.png", "PG" => 2, "PE" => 0, "PP" => 0, "GF" => 6, "GC" => 1],
    ["sigla" => "PRO", "escudo" => "progreso.png", "PG" => 2, "PE" => 0, "PP" => 0, "GF" => 4, "GC" => 2],
    ["sigla" => "NAC", "escudo" => "nacional.png", "PG" => 1, "PE" => 1, "PP" => 0, "GF" => 3, "GC" => 1],
    ["sigla" => "BRI", "escudo" => "bostonriver.png", "PG" => 1, "PE" => 1, "PP" => 0, "GF" => 2, "GC" => 1],
    ["sigla" => "DAN", "escudo" => "danubio.png", "PG" => 1, "PE" => 1, "PP" => 0, "GF" => 3, "GC" => 2],
    ["sigla" => "RAC", "escudo" => "racing.png", "PG" => 1, "PE" => 0, "PP" => 1, "GF" => 4, "GC" => 4],
    ["sigla" => "RIV", "escudo" => "riverplate.png", "PG" => 1, "PE" => 0, "PP" => 1, "GF" => 3, "GC" => 3],
    ["sigla" => "LIV", "escudo" => "liverpool.png", "PG" => 0, "PE" => 2, "PP" => 0, "GF" => 2, "GC" => 2],
    ["sigla" => "CRL", "escudo" => "cerroLargo.png", "PG" => 0, "PE" => 2, "PP" => 0, "GF" => 2, "GC" => 3],
    ["sigla" => "WAN", "escudo" => "wanderers.png", "PG" => 0, "PE" => 2, "PP" => 0, "GF" => 1, "GC" => 2],
    ["sigla" => "FEN", "escudo" => "fenix.png", "PG" => 0, "PE" => 1, "PP" => 1, "GF" => 1, "GC" => 2],
    ["sigla" => "CRR", "escudo" => "cerro.png", "PG" => 0, "PE" => 1, "PP" => 1, "GF" => 0, "GC" => 6],
    ["sigla" => "RAM", "escudo" => "rampla.png", "PG" => 0, "PE" => 0, "PP" => 2, "GF" => 2, "GC" => 5],
    ["sigla" => "MMI", "escudo" => "miramar.png", "PG" => 0, "PE" => 0, "PP" => 2, "GF" => 0, "GC" => 3],
    ["sigla" => "CDM", "escudo" => "carmelo.png", "PG" => 0, "PE" => 0, "PP" => 2, "GF" => 0, "GC" => 3]
];

for ($i = 0; $i < count($equipos); $i++) {
    $equipos[$i]["PTS"] = $equipos[$i]["PG"] * 3 + $equipos[$i]["PE"];
    $equipos[$i]["PJ"] = $equipos[$i]["PG"] + $equipos[$i]["PE"] + $equipos[$i]["PP"];
    $equipos[$i]["DIF"] = $equipos[$i]["GF"] - $equipos[$i]["GC"];
}

function ordenarPorPuntos($a, $b) {
    if ($a["PTS"] < $b["PTS"]) {
        return 1;
    } elseif ($a["PTS"] > $b["PTS"]) {
        return -1;
    } else {
        if ($a["DIF"] < $b["DIF"]) {
            return 1;
        } elseif ($a["DIF"] > $b["DIF"]) {
            return -1;
        } else {
            return 0;
        }
    }
}

usort($equipos, "ordenarPorPuntos");
?>

<h2 class="titulo">Uruguayo 1° División - TABLA APERTURA</h2>

<table>
    <tr>
        <th>POSICIONES</th>
        <th>PTS</th>
        <th>PJ</th>
        <th>PG</th>
        <th>PE</th>
        <th>PP</th>
        <th>GF</th>
        <th>GC</th>
        <th>DIF</th>
    </tr>

    <?php for ($i = 0; $i < count($equipos); $i++): ?>
        <tr class="<?= $i % 2 == 0 ? 'par' : '' ?>">
            <td><img src="<?= $equipos[$i]["escudo"] ?>" class="icono"> <?= $equipos[$i]["sigla"] ?></td>
            <td><?= $equipos[$i]["PTS"] ?></td>
            <td><?= $equipos[$i]["PJ"] ?></td>
            <td><?= $equipos[$i]["PG"] ?></td>
            <td><?= $equipos[$i]["PE"] ?></td>
            <td><?= $equipos[$i]["PP"] ?></td>
            <td><?= $equipos[$i]["GF"] ?></td>
            <td><?= $equipos[$i]["GC"] ?></td>
            <td><?= $equipos[$i]["DIF"] ?></td>
        </tr>
    <?php endfor; ?>
</table>

</body>
</html>
