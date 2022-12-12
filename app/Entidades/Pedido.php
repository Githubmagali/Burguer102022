<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model{
      protected $table ='pedidos';
      public $timestamps = false;

      protected $fillable = [
            'idpedido',
            'fecha',
            'descripcion',
            'fk_idsucursal',
            'fk_idcliente',
            'fk_idestado',
            'total'
      ];

      protected $hidden = [

      ];
      public function cargarDesdeRequest($request)
      {
          $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
         $this->fecha = $request->input('txtFecha');
          $this->descripcion = $request->input('txtDescripcion');
          $this->fk_idsucursal= $request->input('lstSucursal');
          $this->fk_idcliente= $request->input('lstCliente');
          $this->fk_idestado= $request->input('lstEstado');
          $this->total= $request->input('txtTotal');
          
      }

      public function insertar ()
{
      $sql = "INSERT INTO $this->table (
        fecha,
        descripcion,
        fk_idsucursal,
        fk_idcliente,
        fk_idestado
        total
            ) VALUES (?,?,?,?,?,?);";

            $result = DB:: insert ($sql,
            [
                  $this->fecha,
                  $this->descripcion,
                  $this->fk_idsucursal,
                  $this->fk_idcliente,
                  $this->fk_idestado,
                  $this->total
            ]);
            return $this->idpedido = DB:: getPdo()->lastInstertId();
}
public function obtenerTodos()
  {
      $sql = "SELECT
                A.idpedido,
                A.fecha,
                A.descripcion,
                A.fk_idsucursal,
                A.fk_idcliente,
                A.fk_idestado,
                A.total
              FROM pedidos A ORDER BY A.fecha";
      $lstRetorno = DB::select($sql);
      return $lstRetorno;
  }
  
  public function obtenerPorId($idpedido)
    {
        $sql = "SELECT
                idpedido,
                fecha,
                descripcion,
                fk_idsucursal,
                fk_idcliente,
                fk_idestado,
                total
                FROM pedidos WHERE idpedido = $idpedido";
        $lstRetorno = DB::select($sql);
  
        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->descripcion= $lstRetorno[0]->descripcion;
            $this->fk_idsucursal= $lstRetorno[0]->fk_idsucursal;
            $this->fk_idcliente= $lstRetorno[0]->fk_idcliente;
            $this->fk_idestado= $lstRetorno[0]->fk_idestado;
            $this->total = $lstRetorno[0]->total;
          
            
            return $this;
        }
        return null;
    }
public function guardar() {
      $sql = "UPDATE pedidos SET
        fecha=$this->fecha,
         descripcion='$this->descripcion',
         fk_idsucursal=$this->fk_idsucursal,
         fk_idcliente=$this->fk_idcliente,
         fk_idestado=$this->fk_idestado,
         total='$this->total'
          
          WHERE idpedido=?";
      $affected = DB::update($sql, [$this->idpedido]);
  }
  public function eliminar()
  {
      $sql = "DELETE FROM pedidos WHERE idpedido=?";


      $affected = DB::delete($sql, [$this->idpedido]);
  }
  
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0=> 'A.idpedido',
            1 => 'A.fecha',
            2 => 'B.nombre',
            3 => 'C.nombre',
            4 => 'D.nombre',
            5 => 'A.total'
        );
        $sql = "SELECT DISTINCT
                    A.idpedido,
                    A.fecha,
                    A.descripcion
                    B.nombre AS sucursal,
                    C.nombre AS cliente,
                    D.nombre AS estado,
                    A.fk_idsucursal,
                    A.fk_idcliente,
                    A.fk_idestado,
                    A.total
                   
                    FROM pedidos A 
                    INNER JOIN sucursales B ON A.fk_idcsucursales = B.idsucursal
                    INNER JOIN clientes C ON A.fk_idciente = B.idcliente
                    INNER JOIN estados D ON A.fk_idestado = D.idestado
                    
                WHERE 1=1 
                ";
//WHERE 1=1  contatena si la persona busca algo dice 1=1 nombre=nombre LIKE compara
        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.fecha LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.descripcion LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.fecha LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.fk_idsucursal LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.fk_idcliente LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.fk_idestado LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.total LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

   
}