@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')

<script>
    globalId = '<?php echo isset($categoria->idcategoria) && $cliente->idcategoria > 0 ? $categoria->idcategoria : 0; ?>';
    <?php $globalId = isset($categoria->idcategoria) ? $categoria->idcategoria : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/categoria">Categoria</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/categoria/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin";
}
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)){
    echo '<div id="msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '","' . $msg["ESTADO"] . '")</script>';
}

?>
<div class="panel-body"></div>
<div id="msg"></div>
<?php
if (isset($msg)){
    echo '<script>msgShow("' . $msg["MSG"] . '","' . $msg["ESTADO"] . '")</script>';
}
?>
<form id="form1" method="POST">
    <div class="row">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        <input type="hidden" id="id" name="id" class="form-control" value="{{$global"></input>
            <div class="form-group col-lg-6">
                 <label>Nombre:</label>
                 <input type="text" id="txtNombre" name="txtNombre" class="form-control">
            </div> 
            <div class="form-group col-lg-6">
                <label>Men&uacute; padre:</label>
                <select name="lstMenuPadre" id="lstMenuPadre"class="form-control"></select>
                <option selected value=""></option>

                @for ($i =0; $i; < count ($array_menu); $i++)
                @if (isset($menu) and $array_menu[$i]->idmenu == $menu->id_padre)
                <option selected value="{{ $array_menu[$i]">
            </div>
    </div>
</form>
@endsection
