<?php
require_once __DIR__.'/../config/pdo.php';
require_once __DIR__.'/../model/Alerta.php';

$m=new Alerta($pdo);
$rows=$m->obtenerTodas();
$msg=$_GET['msg']??'';
function h($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><title>Alertas</title>
<link rel="stylesheet" href="assets/css/app.css"></head><body>
<div class="container">
  <div class="nav">
    <h2 style="margin:0">Alertas</h2>
    <div><a class="btn primary" href="crear.php">Nueva</a></div>
  </div>
  <?php if($msg):?><div class="alert ok"><?=h($msg)?></div><?php endif;?>
  <?php if(!$rows):?>
    <p>No hay alertas.</p>
  <?php else:?>
  <table><thead><tr><th>#</th><th>Título</th><th>Tipo</th><th>Fecha</th><th>Descripción</th><th>Acciones</th></tr></thead><tbody>
  <?php foreach($rows as $r):?>
    <tr>
      <td><?= (int)$r['id']?></td>
      <td><?= h($r['titulo'])?></td>
      <td><?= h($r['tipo'])?></td>
      <td><?= h($r['fecha'])?></td>
      <td><?= nl2br(h($r['descripcion']))?></td>
      <td>
        <a class="btn" href="editar.php?id=<?= (int)$r['id']?>">Editar</a>
        <a class="btn danger" href="borrar.php?id=<?= (int)$r['id']?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
      </td>
    </tr>
  <?php endforeach;?>
  </tbody></table>
  <?php endif;?>
</div>
</body></html>
