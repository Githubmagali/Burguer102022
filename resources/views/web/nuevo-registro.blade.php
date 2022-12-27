@extends('web.plantilla')
@section('contenido')

<section class="book_section layout_padding">
      <div class="container offsset-sm-3">
            <div class="heading_container">
                  <h2 pb-4 class="text-white">Registrarse</h2>
            </div>
            
              
                              <form action="" method="POST">
                              <div class="container">
              <div class="row">
                                    <input type="hidden" name="_token" value="{{ csrf_token()}}"></input>
                                    <div class="col-12 text-white "> Nombre:*
                                          <input id="txtNombre" name="txtNombre"type="text" class="form-control">
                                    </div>
                                    <div class="col-12 text-white">Apellido:*
                                          <input id="txtApellido" name="txtApellido"type="text" class="form-control">
                                    </div>
                                    <div class="col-12 text-white">Correo:*
                                          <input id="txtCorreo" name="txtCorreo"type="text" class="form-control">
                                    </div>
                                    <div class="col-12 text-white "> DNI: *
                                          <input id="txtDni" name="txtDni"type="text" class="form-control">
                                    </div>
                                    <div class="col-12 text-white "> Celular: *
                                          <input id="txtCelular" name="txtCelular"type="text" class="form-control">
                                    </div>
                                    <div class="col-12 text-white">Clave:*
                                          <input id="txtClave" name="txtClave"type="password"  class="form-control">
                                    </div>
                              </form>
                        </div>
                        </div>
            </div>
      </div>
</section>
@endsection