<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model{
      protected $table ='carritos';
      public $timestamps = false;

      protected $fillable = [
            'idcarrito',
            'fk_idcliente'
      ];

      protected $hidden = [

      ];
      public function cargarDesdeRequest($request)
      {
          $this->idcarrito = $request->input('id') != "0" ? $request->input('id') : $this->idcarrito;
          $this->fk_idcliente= $request->input('lstCliente');
         
          
      }

      public function insertar ()
{
      $sql = "INSERT INTO $this->table (
         fk_idcliente
            ) VALUES (?);";

            $result = DB:: insert ($sql,
            [
                  $this->fk_idcliente
            ]);
            return $this->idcliente = DB:: getPdo()->lastInstertId();
}
public function obtenerPorId($idcarrito)
    {
        $sql = "SELECT
                fk_idcliente

                FROM carritos WHERE idcarrito = $idcarrito";
        $lstRetorno = DB::select($sql);
  
        if (count($lstRetorno) > 0) {
            $this->idcarrito = $lstRetorno[0]->idcarrito;
            $this->fk_idcliente= $lstRetorno[0]->fk_idcliente;
            
          
            
            return $this;
        }
        return null;
    }
    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idcarrito,
                  A.fk_idcliente
                FROM carritos A ORDER BY idcarrito";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
public function guardar() {
      $sql = "UPDATE $this->table SET
         fk_idcliente=$this->fk_idcliente,
        
          
          WHERE idcarrito=?";
      $affected = DB::update($sql, [$this->idcarrito]);
  }
  public function eliminar()
  {
      $sql = "DELETE FROM $this->table WHERE idcarrito=?";


      $affected = DB::delete($sql, [$this->idcarrito]);
  }
  
  
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idcarrito',
            1=>  'B.nombre' 
        );
        $sql = "SELECT DISTINCT
                    A.idcategoria,
                    B.nombre AS cliente,
                    A.fk_idcliente
                
                   
                    FROM carritos A
                    INNER JOIN clientes B ON A.fk_idcliente = B.idcliente
                    
                WHERE 1=1 
                ";
//WHERE 1=1  contatena si la persona busca algo dice 1=1 nombre=nombre LIKE compara
        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.fk_idcliente LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
  
}