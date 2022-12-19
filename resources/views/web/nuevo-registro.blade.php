@extends('web.plantilla')
@section('contenido')

<section class="book_section layout_padding">
      <div class="container offsset-sm-3">
            <div class="heading_container">
                  <h2 pb-4>Registrarse</h2>
            </div>
            <div class="row">
                  <div class="col-md-6">
                        <div class="form-container">
                              <form action="" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token()}}"></input>
                                    <div>
                                          <input id="txtNombre" name="txtNombre"type="text" class="form-control">
                                    </div>
                                    <div>
                                          <input id="txtApellido" name="txtApellido"type="text" class="form-control">
                                    </div>
                                    <div>
                                          <input id="txtCorreo" name="txtCorreo"type="text" class="form-control">
                                    </div>
                                    <div>
                                          <input id="txtDni" name="txtDni"type="text" class="form-control">
                                    </div>
                                    <div>
                                          <input id="txtCelular" name="txtCelular"type="text" class="form-control">
                                    </div>
                                    <div>
                                          <input id="txtClave" name="txtClave"type="text" class="form-control">
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
</section>
@endsection