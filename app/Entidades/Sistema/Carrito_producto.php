<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Carrito_producto extends Model{
      protected $table ='carrito_productos';
      public $timestamps = false;

      protected $fillable = [
            'idcarrito_producto',
            'fk_idproducto',
            'fk_idcarrito',
            'cantidad'
      ];

      protected $hidden = [

      ];
      public function cargarDesdeRequest($request)
    {
        $this->idcarrito_producto = $request->input('id') != "0" ? $request->input('id') : $this->idcarrito_producto;
        $this->fk_idproducto = $request->input('lstProducto');
        $this->fk_idcarrito = $request->input('lstCarrito');
        $this->cantidad= $request->input('txtCantidad');
        
    }

      public function insertar ()
{
      $sql = "INSERT INTO $this->table (
       fk_idproducto,
       fk_idcarrito,
       cantidad
            ) VALUES (?,?,?);";

            $result = DB:: insert ($sql,
            [
                  $this->fk_idproducto,
                  $this->fk_idcarrito,
                  $this->cantidad
            ]);
            return $this->idcliente = DB:: getPdo()->lastInstertId();
}
public function guardar() {
    $sql = "UPDATE $this->table SET
       fk_idproducto=$this->fk_idproducto,
       fk_idcarrito=$this->fk_idcarrito,
       cantidad='$this->cantidad'
        
        WHERE idcliente=?";
    $affected = DB::update($sql, [$this->idcliente]);
}
public function eliminar()
{
    $sql = "DELETE FROM $this->table WHERE idcliente=?";

    $affected = DB::delete($sql, [$this->idcliente]);
}

public function obtenerPorId($idcliente)
  {
      $sql = "SELECT
              idcliente,
              nombre,
              apellido,
              correo,
              dni,
              celular
              FROM $this->table WHERE idcliente = $idcliente";
      $lstRetorno = DB::select($sql);

      if (count($lstRetorno) > 0) {
          $this->idcliente = $lstRetorno[0]->idcliente;
          $this->nombre = $lstRetorno[0]->nombre;
          $this->apellido = $lstRetorno[0]->apellido;
          $this->correo = $lstRetorno[0]->correo;
          $this->dni = $lstRetorno[0]->dni;
          $this->celular = $lstRetorno[0]->celular;
          
          return $this;
      }
      return null;
  }
  public function obtenerTodos()
  {
      $sql = "SELECT
                A.idcarrito_producto,
                A.nombre,
                A.apellido,
                A.correo,
                A.dni,
                A.celular
              FROM carrito_producto A ORDER BY idcarrito_producto";
      $lstRetorno = DB::select($sql);
      return $lstRetorno;
  }

}
