@extends('web.plantilla')
@section('contenido')

<section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Takeaway
        </h2>
      </div>
      <ul class="filters_menu">
        <li class="active" data-filter="*">Todos</li>
        @foreach($aCategorias as $item)
        <li data-filter=".{{$item->nombre}}">{{$item->nombre}}</li>
        @endforeach
</ul>
<div class="fiters-content">
        <div class="row grid">

@foreach($aProductos as $producto)
@foreach($aCategorias as $categoria)
@if($producto->fk_idcategoria == $categoria->idcategoria)
    
          <div class="col-sm-6 col-lg-4 {{$categoria->nombre}} ">
            @endif
            @endforeach
            <div class="box">
              <div>
                <div class="img-box">
                  <img src="images/{{$producto->imagen}}" alt="">
                </div>
                <div class="detail-box">
                  <h5>
                    {{$producto->nombre}}
                  </h5>
                  <p>
                    {{$producto->descripcion}}
                  </p>
                  <div class="options">
                    <h6>
                     {{$producto->precio}}
                    </h6>

                <form action="" method="post">
                  <div class="btn selecCant">
                    <input type="hidden" name="txtIdProducto" value="{{$producto->idproducto}}">
                    <input type="hidden" name="txtNombreCliente" value="Nombre">
                    <input type="number" name="txtCantidadProducto" id="" class="text-center">
                  </div>
                  <button type="submit"></button>
                </form>
            
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </section>


<!-- end food section -->
@endsection
<!-- end food section -->