<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model{
      protected $table ='pedidos';
      public $timestamps = false;

      protected $fillable = [
            'idpedido',
            'descripcion',
            'fecha',
            'total',
            'fk_idsucursal',
            'fk_idcliente',
            'fk_idestado'
      ];

      protected $hidden = [

      ];

      public function insertar ()
{
      $sql = "INSERT INTO $this->table (
        'descripcion',
        'fecha',
        'total',
        fk_idsucursal,
        fk_idcliente,
        fk_idestado
            ) VALUES (?,?,?,?,?,?);";

            $result = DB:: insert ($sql,
            [
                  $this->descripcion,
                  $this->fecha,
                  $this->total,
                  $this->fk_idsucursal,
                  $this->fk_idcliente,
                  $this->fk_idestado
            ]);
            return $this->idpedido = DB:: getPdo()->lastInstertId();
}
public function guardar() {
      $sql = "UPDATE pedidos SET
         descripcion='$this->descripcion',
         fecha='$this->fecha',
         total='$this->total',
         fk_idsucursal=$this->fk_idsucursal,
         fk_idcliente=$this->fk_idcliente,
         fk_idestado=$this->fk_idestado
          
          WHERE idpedido=?";
      $affected = DB::update($sql, [$this->idpedido]);
  }
  public function eliminar()
  {
      $sql = "DELETE FROM pedidos WHERE idpedido=?";


      $affected = DB::delete($sql, [$this->idpedido]);
  }
  
  public function obtenerPorId($idpedido)
    {
        $sql = "SELECT
                idpedido,
                fecha,
                descripcion,
                fecha,
                total,
                fk_idsucursal,
                fk_idcliente,
                fk_idestado
                FROM pedidos WHERE idpedido = $idpedido";
        $lstRetorno = DB::select($sql);
  
        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->descripcion= $lstRetorno[0]->descripcion;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->total = $lstRetorno[0]->total;
            $this->fk_idsucursal= $lstRetorno[0]->fk_idsucursal;
            $this->fk_idcliente= $lstRetorno[0]->fk_idcliente;
            $this->fk_idestado= $lstRetorno[0]->fk_idestado;
          
            
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idpedido,
                  A.descripcion,
                  A.fecha,
                  A.total,
                  A.fk_idsucursal,
                  A.fk_idcliente,
                  A.fk_idestado
                FROM pedidos ORDER BY idpedido";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}