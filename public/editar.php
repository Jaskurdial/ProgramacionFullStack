<?php
require_once __DIR__.'/../config/pdo.php';
require_once __DIR__.'/../model/Alerta.php';

$m=new Alerta($pdo);
$id=isset($_GET['id'])?(int)$_GET['id']:(int)($_POST['id']??0);
if(!$id){header('Location: index.php');exit;}
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $t=$_POST['titulo']??'';$tp=$_POST['tipo']??'';$f=$_POST['fecha']??'';$d=$_POST['descripcion']??'';
  if($t&&$tp&&$f&&$d){$m->actualizar($id,$t,$tp,$f,$d);header('Location: index.php?msg=editada');exit;}
  else{$err='Faltan datos';}
}
$row=$m->obtenerPorId($id); if(!$row){header('Location: index.php');exit;}
function h($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><title>Editar</title>
<link rel="stylesheet" href="assets/css/app.css"></head><body>
<div class="container">
  <div class="nav"><a class="btn" href="index.php">Volver</a><h2 style="margin:0">Editar alerta #<?= (int)$row['id']?></h2><div></div></div>
  <?php if($err):?><div class="alert err"><?=h($err)?></div><?php endif;?>
  <form method="post" autocomplete="off">
    <input type="hidden" name="id" value="<?= (int)$row['id']?>">
    <label>Título</label>
    <input type="text" name="titulo" maxlength="120" value="<?= h($row['titulo'])?>" required>
    <div class="grid">
      <div>
        <label>Tipo</label>
        <select name="tipo" required>
          <?php $opts=['tormenta'=>'Tormenta','inundacion'=>'Inundación','ola_calor'=>'Ola de calor','vientos_fuertes'=>'Vientos fuertes'];
          foreach($opts as $val=>$lab){$sel=$val===$row['tipo']?'selected':'';echo "<option value='".h($val)."' $sel>".h($lab)."</option>";}?>
        </select>
      </div>
      <div>
        <label>Fecha</label>
        <input type="date" name="fecha" value="<?= h($row['fecha'])?>" required>
      </div>
    </div>
    <label>Descripción</label>
    <textarea name="descripcion" required><?= h($row['descripcion'])?></textarea>
    <div class="nav"><div></div><div><button class="btn primary" type="submit">Guardar cambios</button></div></div>
  </form>
</div>
</body></html>
