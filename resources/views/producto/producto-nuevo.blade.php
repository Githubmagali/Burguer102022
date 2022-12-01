@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')

<script>
    globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
    <?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/productos">Productos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/producto";
}
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)){
    echo '<div id= "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '","' . $msg["ESTADO"] . '")</script>';
    }
    ?>

<div class="panel-body">
    <div id="msg"></div>
    <?php
    if (isset($msg)){
        echo '<script>msgShow("' . $msg["MSG"] . '""' . $msg["ESTADO"] .'")</script>';
    }
    ?>
<form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-12">
                <label>Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
                </div>
                    <div class="form-group col-lg-12">
                    <label>Cantidad: *</label>
                    <input type="text" id="txtCantidad" name="txtCantidad" class="form-control" value="" required>
                </div>
                <div class="form-group col-lg-12">
                <label>Precio: *</label>
                    <input type="text" id="txtPrecio" name="txtPrecio" class="form-control" value="" required>
                </div>
                <div class="form-group col-lg-12">
                <label>Categoria: *</label>
                    <select type="lst" id="lstCategoria" name="lstCategoria" class="form-control selectpicker" data-live-search="true" value="" required>
                <option value="" disabled selected>Seleccionar</option>
                
                @foreach($aCategorias as $item)
                <option value="{{ $item->idcategoria}}">{{$item->nombre}}</option>
                @endforeach
            </select>
                </div>
                <div class="form-group col-lg-12">
                    <label>Imagen: </label>
                    <input type="file" id="imagen" name="imagen" class="form-control-file">
                    <img src="" alt="">
                </div>
                <div class="form-group col-lg-12">
                    <label for="txtDescripcion">Descripcion: </label>
                    <textarea type="text"name="txtDescripcion" id="txtDescripcion" class="form-control"></textarea>
                </div>
               
</div>
</form>
<script>

    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('admin/producto/eliminar') }}",
            data: { id:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
                if (data.err = "0") {
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow("Error al eliminar", "success");
                }
            }
        });
    }

</script>
@endsection