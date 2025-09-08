<?php
require_once __DIR__.'/../config/pdo.php';
require_once __DIR__.'/../model/Alerta.php';

$m=new Alerta($pdo);
$id=isset($_GET['id'])?(int)$_GET['id']:0;
if($id){$m->eliminar($id);}
header('Location: index.php?msg=borrada');
exit;
