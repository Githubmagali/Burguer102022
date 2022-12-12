@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Cliente</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/cliente/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/clientes");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display"> 
    <thead>
        <tr>
            <th></th>
            <th>Nombre y apellido</th>
            <th>DNI</th>
            <th>Correo</th>
            <th>Celular</th>
        </tr>
    </thead>
</table> 
<script>
    $(document). ready( function (){
	var dataTable = $('#grilla').DataTable({ //esta linea le da ese aspecto visual
	    "processing": true,
        "serverSide": true, //esta linea se procesa del lado de servidor
	    "bFilter": true,
	    "bInfo": true,
	    "bSearchable": true,
        "pageLength": 25,
        "order": [[ 0, "asc" ]], //va a ordenar la columna 0 ascendente 0 =>'A.nombre'
	    "ajax": "{{ route('cliente.cargarGrilla') }}" //busca los datos para esta grilla
	//habilitamos la ruta con el nombre de la ruta
    });
});
</script>
@endsection
<!--1ro convertimos el table con la funcion de java '.Datatable' a que el table
que tiene in id se convierta en un .Datatable con la linea $('#grilla').DataTable
este Datatable tiene una serie de config
dentro del ControladorCliente def la funcion cargar Grilla -->