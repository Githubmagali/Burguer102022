<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model{
      protected $table ='sucursal';
      public $timestamps = false;

      protected $fillable = [
            'idsucursal',
            'telefono',
            'direccion',
            'linkmapa'
 ];

      protected $hidden = [

      ];

      public function insertar ()
{
      $sql = "INSERT INTO $this->table (
            'nombre',
         'telefono',
         'direccion',
         'linkmapa'
            ) VALUES (?,?,?,?);";

            $result = DB:: insert ($sql,
            [
                  $this->fk_idsucursal
            ]);
            return $this->idsucursal = DB:: getPdo()->lastInstertId();
}
public function guardar() {
      $sql = "UPDATE $this->table SET
         nombre='$this->nombre',
         telefono='$this->telefono',
         direccion='$this->direccion',
         linkmapa='$this->linkmapa'
        
          
          WHERE idsucursal=?";
      $affected = DB::update($sql, [$this->idsucursal]);
  }
  public function eliminar()
  {
      $sql = "DELETE FROM $this->table WHERE idsucursal=?";
      $affected = DB::delete($sql, [$this->idsucursal]);
  }
  
  public function obtenerPorId($idsucursal)
    {
        $sql = "SELECT
                nombre,
                telefono,
                direccion,
                linkmapa

                FROM $this->table WHERE idsucursal = $idsucursal";
        $lstRetorno = DB::select($sql);
  
        if (count($lstRetorno) > 0) {
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->telefono= $lstRetorno[0]->telefono;
            $this->linkmapa= $lstRetorno[0]->linkmapa;
            
          
            
            return $this;
        }
        return null;
    }
    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idsucursal,
                  A.nombre,
                  A.telefono,
                  A.sucursal,
                  A.linkmapa
                FROM $this->table ORDER BY A.nombre DESC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}