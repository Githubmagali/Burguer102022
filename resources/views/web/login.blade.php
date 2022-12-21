@extends('web.plantilla')
@section('contenido')


<section class="book_section layout_padding">
      <div class="container offset-sm-3">
            <div class="heading_container">
                  <h2 class="pb-4 text-white">Ingreso</h2>
            </div>
      </div>
      <div class="row">
            <div class="col-md-6">
                  <div class="form_container">
                        <form action="" method="POST">-->
                      <!--que contiene controles interactivos que permiten a un usuario enviar información a un servidor web.-->
                     @if(isset($msg))
                      <div class="alert alert-secondary" role="alert">
                        {{$msg}}
                     </div>
                     @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                        <div class="col-12">
                              <input id="txtCorreo" name="txtCorreo" type="email" class="form-control" placeholder="Correo">
                        </div>
                        <div class="col-12">
                              <input id="txtClave" name="txtClave" type="text" class="form-control" placeholder="Contraseña">
                        </div>
                        <div class="btn_box col-12">
                              <button type="submit" id="btnIngresar" name="btnIngresar" href="/mi-cuenta">Ingresar</button>
                        </div>
                        <div class="mt-4 col-12">
                              <a href="/nuevo-registro">Registrarme</a>
                        </div>
                        <div class="mt-4 col-12">
                              <a href="/recuperar-clave">Olvide la contraseña</a>
                        </div>
                        </form>
                  </div>
            </div>
      </div>


      </div>
</section>
@endsection