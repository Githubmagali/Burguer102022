@extends('plantilla')
@section('titulo', "$titulo")
<!--Blade es un motor de plantillas de Laravel.  
Blade no te impide utilizar codigo PHP plano en ñas vistas.-->
@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet"> <!--asset signif que lo va a ir a buscar a a carpeta public-->
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Categoria</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/categoria/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/categorias");'><span>Recargar</span></a></li>
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
            <th>Nombre y apellido</th>
            <th>DNI</th>
            <th>Correo</th>
            <th>Celular</th>
        </tr>
    </thead>
</table> 
<script>
    $(document). ready( function (){
	var dataTable = $('#grilla').DataTable({ //funcion de javascript que permite que la 
        //funcion table que tiene un id="grilla" se convierta en un query datatable poniendo '$('#grilla').DataTable'
        //este  va a tener una serie de configuraciones 
	    "processing": true, //configuraciones donde se procesa por el lado del procesador 
        "serverSide": true,//tiene un filtrado que es la busqueda
	    "bFilter": true,
	    "bInfo": true,
	    "bSearchable": true,
        "pageLength": 25, //cant de registros por pag '25'
        "order": [[ 0, "asc" ]],//ordenamiento de la primera columna de manera ascendente
	    "ajax": "{{ route('categoria.cargarGrilla') }}"//busca los datos en la grilla para ello necesitamos la ruta
	// Route::get('/admin/categoria/cargarGrilla', 'ControladorCategoria@cargarGrilla')->name('categoria.cargarGrilla');
    //route('categoria.cargarGrilla') es cuando lo queremos imprimir desde el blade
});
});
</script>
@endsection