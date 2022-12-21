<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps = false;

    protected $fillable = [
        'idcliente',
        'nombre',
        'apellido',
        'correo',
        'dni',
        'celular',
        'clave'
    ];

    protected $hidden = [];
    public function cargarDesdeRequest($request)
    {
        $this->idcliente = $request->input('id') != "0" ? $request->input('id') : $this->idcliente;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->correo = $request->input('txtCorreo');
        $this->dni = $request->input('txtDni');
        $this->celular = $request->input('txtCelular');
        $this->clave= password_hash($request->input('txtClave'), PASSWORD_DEFAULT);
    }

    public function insertar()
    {
        $sql = "INSERT INTO $this->table (
          nombre,
          apellido,
          correo,
          dni,
          celular,
          clave
            ) VALUES (?, ?, ?, ?, ?, ?);";

        $result = DB::insert(
            $sql,
            [
                $this->nombre,
                $this->apellido,
                $this->correo,
                $this->dni,
                $this->celular,
                $this->clave
            ]
        );
        return $this->idcliente = DB::getPdo()->lastInstertId();
    }
    public function obtenerPorId($idcliente)
    {
        $sql = "SELECT
                idcliente,
                nombre,
                apellido,
                correo,
                dni,
                celular,
                clave
                FROM clientes WHERE idcliente= $idcliente";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->correo = $lstRetorno[0]->correo;
            $this->dni = $lstRetorno[0]->dni;
            $this->celular = $lstRetorno[0]->celular;
            $this->clave = $lstRetorno[0]->clave;

            return $this;
        }
        return null;
    }
    public function obtenerTodos()
    {
        $sql = "SELECT
                A.idcliente,
                A.nombre,
                A.apellido,
                A.correo,
                A.dni,
                A.celular,
                A.clave
              FROM $this->table A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function guardar()
    {
        $sql = "UPDATE $this->table SET
          nombre='$this->nombre',
          apellido='$this->apellido',
          correo='$this->correo',
          dni='$this->dni',
          celular='$this->celular'
          clave='$this->clave'
          
          WHERE idcliente=?";
        $affected = DB::update($sql, [$this->idcliente]);
    }
    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idcliente=?";

        $affected = DB::delete($sql, [$this->idcliente]); //el id lo saca de this->idcliente que lo carga el cargarDesdeRequest
    }

    

    
    public function obtenerFiltrado()
    { //la llamada de javascript los datos es atraves de 'ajax'
        //se encuentran en 'red' en la parte'cargarGrilla'
        //el json te devuelve la info registrada
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idcliente', //columnas de ordenamiento
            1 => 'A.nombre',
            2 => 'A.dni',
            3 => 'A.correo',
            4 => 'A.celular',
            5 => 'A.clave',
        );
        $sql = "SELECT DISTINCT
                    A.idcliente,
                    A.nombre,
                    A.apellido,
                    A.correo,
                    A.dni,
                    A.celular
                    A.clave
                   
                    FROM clientes A
                    
                WHERE 1=1 
                ";
//WHERE 1=1  contatena si la persona busca algo dice 1=1 nombre=nombre LIKE compara
        //Realiza el filtrado
        if (!empty($request['search']['value'])) { //concatena el filtrado
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' "; //empieza con AND porque
            //concatena con la query, donde 1=1 AND A.nombre sea igual a determinado resultado ej Alan
            $sql .= " OR A.apellido LIKE '%" . $request['search']['value'] . "%' ";
            //LIKE es para que lo contenga
            $sql .= " OR A.correo LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR A.dni LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.celular LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR A.clave LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];
//ORDER BY concatena la parte de ordenamiento, viene por la querystream
        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerPorCorreo($correo)
    {
        $sql = "SELECT
        idcliente,
        correo,
        clave
        FROM clientes WHERE correo = 'correo'";
        $lstRetorno = DB::select($sql, [$correo]);

        if(count($lstRetorno) > 0){
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->correo = $lstRetorno[0]->correo;
            $this->clave= $lstRetorno[0]->clave;
            return $this;
        }
        return null;
    }
}
