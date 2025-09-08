<?php
class Alerta{
    private PDO $db;
    public function __construct(PDO $pdo){$this->db=$pdo;}
    public function crear(string $titulo,string $tipo,string $fecha,string $descripcion):int{
        $st=$this->db->prepare("INSERT INTO alertas (titulo,tipo,fecha,descripcion) VALUES (:t,:tp,:f,:d)");
        $st->execute([':t'=>trim($titulo),':tp'=>$tipo,':f'=>$fecha,':d'=>trim($descripcion)]);
        return (int)$this->db->lastInsertId();
    }
    public function actualizar(int $id,string $titulo,string $tipo,string $fecha,string $descripcion):bool{
        $st=$this->db->prepare("UPDATE alertas SET titulo=:t,tipo=:tp,fecha=:f,descripcion=:d WHERE id=:id");
        $st->execute([':t'=>trim($titulo),':tp'=>$tipo,':f'=>$fecha,':d'=>trim($descripcion),':id'=>$id]);
        return $st->rowCount()>0;
    }
    public function eliminar(int $id):bool{
        $st=$this->db->prepare("DELETE FROM alertas WHERE id=:id");
        $st->execute([':id'=>$id]);
        return $st->rowCount()>0;
    }
    public function obtenerPorId(int $id):?array{
        $st=$this->db->prepare("SELECT * FROM alertas WHERE id=:id");
        $st->execute([':id'=>$id]);
        $r=$st->fetch();
        return $r?:null;
    }
    public function obtenerTodas():array{
        $st=$this->db->query("SELECT * FROM alertas ORDER BY fecha DESC,id DESC");
        return $st->fetchAll();
    }
}
