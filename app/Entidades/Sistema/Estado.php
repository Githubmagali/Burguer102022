<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model{
      protected $table ='estado';
      public $timestamps = false;

      protected $fillable = [
            'idestado',
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
            return $this->idcliente = DB:: getPdo()->lastInstertId();
}
public function guardar() {
      $sql = "UPDATE $this->table SET
          nombre='$this->nombre'
          
          WHERE idestado=?";
      $affected = DB::update($sql, [$this->idestado]);
  }
  public function eliminar()
  {
      $sql = "DELETE FROM $this->table WHERE idestado=?";


      $affected = DB::delete($sql, [$this->idestado]);
  }

  public function obtenerPorId($idestado)
    {
        $sql = "SELECT
                idestado,
                nombre
                FROM $this->table WHERE idestado = $idestado";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idestado = $lstRetorno[0]->idestado;
            $this->nombre = $lstRetorno[0]->nombre;
            
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idestado,
                  A.nombre
                FROM $this->table ORDER BY idestado";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}