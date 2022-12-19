@extends('web.plantilla')
@section('contenido')

<section class="book_section layout_padding">
      <div class="container offsset-sm-3">
            <div class="heading_container">
                  <h2 pb-4>Recuperar clave</h2>
            </div>
            <div class="row">
                  <div class="col-md-6">
                        <div class="form-container">
                              <form action="" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token()}}"></input>
                                    
                                    <div>
                                          <input id="txtCorreo" name="txtCorreo" type="text" class="form-control"placeholder="Correo">
                                    </div>
                                    <div class="btn_box col-12">
                              <button type="submit" id="btnEnviar" name="btnEnviar" href="">Enviar</button>
                        </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
</section>
@endsection