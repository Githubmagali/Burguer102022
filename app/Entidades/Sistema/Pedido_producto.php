<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido_producto extends Model{
      protected $table ='pedido_producto';
      public $timestamps = false;

      protected $fillable = [
            'idpedidoproducto',
            'fk_idpedido',
            'fk_idproducto',
            'cantidad',
            'precio_unitario',
            'total'
      ];

      protected $hidden = [

      ];
      public function cargarDesdeRequest($request)
      {
          $this->idpedido_producto = $request->input('id') != "0" ? $request->input('id') : $this->idpedido_producto;
          $this->fk_idpedido = $request->input('lstPedido');
          $this->producto = $request->input('lstProducto');
          $this->cantidad= $request->input('txtCantidad');
          $this->precio_unitario= $request->input('txtPrecio_unitario');
          $this->total= $request->input('txtTotal');
          
          
      }

      public function insertar ()
{
      $sql = "INSERT INTO $this->table (
          fk_idpedido,
          fk_idproducto,
          cantidad,
          precio_unitario,
          total
            ) VALUES (?,?,?,?,?);";

            $result = DB:: insert ($sql,
            [
                  $this->fk_idpedido,
                  $this->fk_idproducto,
                  $this->cantidad,
                  $this->precio_unitario,
                  $this->total
            ]);
            return $this->idcliente = DB:: getPdo()->lastInstertId();
}
public function guardar() {
      $sql = "UPDATE $this->table SET
         nombre='$this->nombre'
          
          WHERE idpedido_producto=?";
      $affected = DB::update($sql, [$this->idpedido_producto]);
  }
  public function eliminar()
  {
      $sql = "DELETE FROM $this->table WHERE idpedido_producto=?";


      $affected = DB::delete($sql, [$this->idpedido_producto]);
  }
  
  public function obtenerPorId($idpedido_producto)
    {
        $sql = "SELECT
                idpedido_producto,
                nombre
                FROM pedido_productos WHERE idpedido_producto = $idpedido_producto";
        $lstRetorno = DB::select($sql);
  
        if (count($lstRetorno) > 0) {
            $this->idpedido_producto = $lstRetorno[0]->idpedido_producto;
            $this->nombre = $lstRetorno[0]->nombre;
          
            
            return $this;
        }
        return null;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idpedido_producto,
                  A.nombre
                FROM pedido_productos A BY idpedido_producto";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
  

}