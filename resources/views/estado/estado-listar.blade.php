@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet"> 
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
<?php //asset sig que lo va a ir a buscar a la carpeta public donde en css tenemos el datatable ?>
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Cliente</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/estado/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/estados");'><span>Recargar</span></a></li>
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
	var dataTable = $('#grilla').DataTable({
	    "processing": true,
        "serverSide": true,
	    "bFilter": true,
	    "bInfo": true,
	    "bSearchable": true,
        "pageLength": 25,
        "order": [[ 0, "asc" ]],
	    "ajax": "{{ route('estado.cargarGrilla') }}"
	});
</script>
@endsection