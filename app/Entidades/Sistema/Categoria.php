<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model{
      protected $table ='categoria';
      public $timestamps = false;

      protected $fillable = [
            'idcategoria',
            'nombre'
      ];

      protected $hidden = [

      ];

      public function insertar ()
{
      $sql = "INSERT INTO $this->table (
          'nombre'
            ) VALUES (?);";

            $result = DB:: insert ($sql,
            [
                  $this->nombre
            ]);
            return $this->idcategoria = DB:: getPdo()->lastInstertId();
}
public function guardar() {
      $sql = "UPDATE $this->table SET
         nombre='$this->nombre'
          
          WHERE idcategoria=?";
      $affected = DB::update($sql, [$this->idcategoria]);
  }
  public function eliminar()
  {
      $sql = "DELETE FROM $this->table WHERE idcategoria=?";


      $affected = DB::delete($sql, [$this->idcategoria]);
  }
  
  public function obtenerPorId($idcategoria)
    {
        $sql = "SELECT
                idcategoria,
                nombre
                FROM categorias WHERE idcategoria = $idcategoria";
        $lstRetorno = DB::select($sql);
  
        if (count($lstRetorno) > 0) {
            $this->idcategoria = $lstRetorno[0]->idcategoria;
            $this->nombre = $lstRetorno[0]->nombre;
          
            
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idcategoria,
                  A.nombre
                FROM categorias ORDER BY idcategoria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
  

}