@extends('web.plantilla')
@section('contenido')
    <!-- slider section -->
 <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Dejanos tu mensaje
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="">
              <div>
                <input type="text" class="form-control" placeholder="Nombre" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Celular" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" />
              </div>
              <div>
                <input type="mensaje" class="form-control" placeholder="Mensaje" />
              </div>
             
              <div class="btn_box">
                <button>
                  Enviar
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3277.815377563778!2d-58.39820738504695!3d-34.76024327330324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcd29538d97bd1%3A0x4e7af16239b047f0!2sMostaza!5e0!3m2!1ses-419!2sar!4v1670892179582!5m2!1ses-419!2sar" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

@endsection
 