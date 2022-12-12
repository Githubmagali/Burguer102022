<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model{
      protected $table ='sucursales';
      public $timestamps = false;

      protected $fillable = [
            'idsucursal',
            'telefono',
            'direccion',
            'linkmapa'
 ];

      protected $hidden = [

      ];
      public function cargarDesdeRequest($request)
      {
          $this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idsucursal;
          $this->telefono = $request->input('txtTelefono');
          $this->direccion= $request->input('txtDireccion');
          $this->linkmapa= $request->input('txtMapa');
         
         
          
      }
     

      public function insertar ()
{
      $sql = "INSERT INTO sucursales (
            nombre,
         telefono,
         direccion,
         linkmapa
            ) VALUES (?,?,?,?);";

            $result = DB:: insert ($sql,
            [
                  $this->nombre,
                  $this->telefono,
                  $this->direccion,
                  $this->linkmapa
            ]);
            return $this->idsucursal = DB:: getPdo()->lastInstertId();
}
public function guardar() {
    $sql = "UPDATE sucursales SET
       nombre='$this->nombre',
       telefono='$this->telefono',
       direccion=$this->direccion,
       linkmapa=$this->linkmapa
      
        
        WHERE idsucursal=?";
    $affected = DB::update($sql, [$this->idsucursal]);
}
  public function eliminar()
  {
      $sql = "DELETE FROM sucursales  WHERE idsucursal=?";


      $affected = DB::delete($sql, [$this->idsucursal]);
  }
 
 
    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idsucursal,
                  A.nombre,
                  A.telefono,
                  A.direccion,
                  A.linkmapa
                FROM sucursales A ORDER BY A.nombre ";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idsucursal)
    {
        $sql = "SELECT
                idsucursal,
                nombre,
                telefono,
                direccion,
                linkmapa

                FROM sucursales WHERE idsucursal = $idsucursal";
        $lstRetorno = DB::select($sql);
  
        if (count($lstRetorno) > 0) {
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->telefono= $lstRetorno[0]->telefono;
            $this->direccion= $lstRetorno[0]->direccion;
            $this->linkmapa= $lstRetorno[0]->linkmapa;
             return $this;
        }
        return null;
    }
    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idsucursal',
            1 => 'A.nombre',
            2 => 'A.telefono',
            3 => 'A.direccion',
            4 => 'A.linkmapa'
        );
        $sql = "SELECT DISTINCT
                    A.idsucursal,
                    A.nombre,
                    A.telefono,
                    A.direccion,
                    A.linkmapa
                   
                    FROM sucursales A
                    
                WHERE 1=1 
                ";
//WHERE 1=1  contatena si la persona busca algo dice 1=1 nombre=nombre LIKE compara
        //Realiza el filtrado
        if (!empty($request['search']['value'])) { //empieza con AND porque concatena con 1=1 entonces es igual a decir "y igual nombre =daniel OR 
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.telefono LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.direccion LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR A.linkmapa LIKE '%" . $request['search']['value'] . "%' ";
            
           
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    
}