@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')

<script>
    globalId = '<?php echo isset($pedido->idpedido) && $pedido->idpedido > 0 ? $pedido->idpedido : 0; ?>';
    <?php $globalId = isset($pedido->idpedido) ? $pedido->idpedido : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/pedidos">Pedidos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/pedido/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
    function fsalir() {
        location.href = "/admin/pedido";
    }
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id= "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '","' . $msg["ESTADO"] . '")</script>';
}
?>

<div class="panel-body">
    <div id="msg"></div>
    <?php
    if (isset($msg)) {
        echo '<script>msgShow("' . $msg["MSG"] . '""' . $msg["ESTADO"] . '")</script>';
    }
    ?>
    <form id="form1" method="POST"enctype="multipart/form-data">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>

            <div class="form-group col-lg-12">
                <label>Fecha: *</label>
                <input type="date" id="txtFecha" name="txtFecha" class="form-control" value="{{$pedido->fecha}}" required>
            </div>
            <div class="form-group col-lg-12">
                <label>Descripcion: *</label>
                <textarea type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="{{$pedido->descripcion}}" required></textarea>
            </div>

            <div class="form-group col-lg-12">
                <label>Sucursal: *</label>
                <select id="lstSucursal" name="lstSucursal" class="form-control" value="{{$pedido->sucursal}}" required>
                    <option disabled selected>Seleccionar</option>

                    @foreach($aSucursales as $item)
                    @if ($item->idsucursal == $pedido->fk_idsucursal)

                    <option value="{{ $item->idsucursal}}">{{ $item->nombre}}</option>
                    @endif
                   @endforeach
                   
                </select>
            </div>
            <div class="form-group col-lg-12">
                <label>Cliente: *</label>
                <select id="lstCliente" name="lstCliente" class="form-control" value="" required>
                    <option disabled selected>Seleccionar</option>

                    @foreach($aClientes as $item)
                    @if ($item->idcliente == $pedido->fk_idcliente)
                    <option value="{{ $item->idcliente}}">{{ $item->nombre}}{{ $item->apellido}}</option>
                   @else
                   <option value="{{ $item->idcliente}}">{{ $item->nombre}}</option>
                    @endif
                   @endforeach
                </select>
            </div>
            <div class="form-group col-lg-12">
                <label>Estado: *</label>
                <select id="lstEstado" name="lstEstado" class="form-control" value="{{$pedido->estado}}" required>
                    <option disabled selected>Seleccionar</option>

                    @foreach($aEstados as $item)
                    @if ($item->idestado == $pedido->fk_idestado)
                  
                    <option value="{{ $item->idestado}}">{{ $item->nombre}}</option>
                    @endif
                   @endforeach
                   
                </select>
            </div>
             <div class="form-group col-lg-12">
                <label>Total: *</label>
                <input type="number" id="txtTotal" name="txtTotal" class="form-control" value="" required>
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
                url: "{{ asset('admin/pedido/eliminar') }}",
                data: {
                    id: globalId
                },
                async: true,
                dataType: "json",
                success: function(data) {
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