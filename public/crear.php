<?php
require_once __DIR__.'/../config/pdo.php';
require_once __DIR__.'/../model/Alerta.php';

$m=new Alerta($pdo);
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $t=$_POST['titulo']??'';$tp=$_POST['tipo']??'';$f=$_POST['fecha']??'';$d=$_POST['descripcion']??'';
  if($t&&$tp&&$f&&$d){$m->crear($t,$tp,$f,$d);header('Location: index.php?msg=creada');exit;}
  else{$err='Faltan datos';}
}
function h($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><title>Nueva alerta</title>
<link rel="stylesheet" href="assets/css/app.css"></head><body>
<div class="container">
  <div class="nav"><a class="btn" href="index.php">Volver</a><h2 style="margin:0">Nueva alerta</h2><div></div></div>
  <?php if($err):?><div class="alert err"><?=h($err)?></div><?php endif;?>
  <form method="post" autocomplete="off">
    <label>Título</label>
    <input type="text" name="titulo" maxlength="120" required>
    <div class="grid">
      <div>
        <label>Tipo</label>
        <select name="tipo" required>
          <option value="tormenta">Tormenta</option>
          <option value="inundacion">Inundación</option>
          <option value="ola_calor">Ola de calor</option>
          <option value="vientos_fuertes">Vientos fuertes</option>
        </select>
      </div>
      <div>
        <label>Fecha</label>
        <input type="date" name="fecha" required>
      </div>
    </div>
    <label>Descripción</label>
    <textarea name="descripcion" required></textarea>
    <div class="nav"><div></div><div><button class="btn primary" type="submit">Guardar</button></div></div>
  </form>
</div>
</body></html>
