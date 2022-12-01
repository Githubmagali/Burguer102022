@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')

<script>
    globalId = '<?php echo isset($cliente->idcliente) && $cliente->idcliente > 0 ? $cliente->idcliente : 0; ?>';
    <?php $globalId = isset($cliente->idcliente) ? $cliente->idcliente : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/clientes">Clientes</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/cliente/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/cliente";
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
<form id="form1" method="POST" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="form-group col-lg-12">
                <label>Nombre: *</label>
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$cliente->nombre}}" required>
                </div>
                    <div class="form-group col-lg-12">
                    <label>Apellido: *</label>
                    <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="{{$cliente->apellido}}" required>
                </div>
                <div class="form-group col-lg-12">
                <label>Correo: *</label>
                    <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="{{$cliente->correo}}" required>
                </div>
</div>
</form>
<div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar registro?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">¿Deseas eliminar el registro actual?</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-primary" onclick="eliminar();">Sí</button>
          </div>
        </div>
      </div>
    </div>

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

    function eliminar() { //funcion de javascript
        $.ajax({
            type: "GET",
            url: "{{ asset('admin/cliente/eliminar') }}", //hace una peticion al servidor via GET
            data: { id:globalId }, //EN USUARIO ENVIA 'admin/cliente/eliminar' y envia 'data' via 'GET', AL ENVIARLA VIA get VIAJA POR QUERY STRIM
            async: true, //es de forma sincronica porque si hago click en eliminar me permite que mientras trabaja en la secuencia de eliminar me permite seguir trabaajando
            dataType: "json", //los datos viajan en json que se comunica bajo difrentes tecnologias en este caso frnt con php
            success: function (data) { //success indica que va  hacer el servidor
                if (data.err = "0") { //si data.err es 0 = 'registro eliminado correctamente'
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide(); //hide oculta botones
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