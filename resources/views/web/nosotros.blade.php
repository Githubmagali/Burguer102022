@extends('web.plantilla')
@section('contenido')

<section class="about_section layout_padding">
  <div class="container  ">
     <div class="row">
      <div class="col-md-6 ">
        <div class="img-box">
        <img src="web/images/about-img.png" alt="">
        </div>
      </div>
      <div class="col-md-6">
        <div class="detail-box">
          <div class="heading_container">
            <h2>
              Hamburguesas Gourmet
            </h2>
          </div>
         <p>Amplia variedad de comidas, las hamburguesas son la especialidad de la casa</p>
         <div class="btn-box">
                      <a href="/reserva-mesa" class="btn1">
                        Reserva
                      </a>
                    </div>
        </div>
</div>
  
</section>


<!-- end about section -->
<!-- client section -->

<section class="client_section pt-5 ">
  <div class="container">
    <div class="heading_container text_center psudo_white_primary mb_45">
      <h2>
        Lo que dicen nuestros clientes
      </h2>
    </div>
    <div class="carousel-wrap row ">
      <div class="owl-carousel client_owl-carousel">
        <div class="item">
          <div class="box">
            <div class="detail-box">
              <p>
                La comida muy buena, abundante y el personal muy atento
              </p>
              <h6>
                Moana Michell
              </h6>
          

            </div>
            <div class="img-box">
              <img src="web/images/client1.jpg" alt="" class="box-img">
            </div>
          </div>
        </div>
        <div class="item">
          <div class="box">
            <div class="detail-box">
              <p>
                Excelente lugar la comida exquisita, muy bien decoradoo
              </p>
              <h6>
                Mike Hamell
              </h6>
            </div>
            <div class="img-box">
              <img src="web/images/client2.jpg" alt="" class="box-img">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>
<section class="book_section layout_padding-bottom">
  <div class="container">
    <div class="py-5 txt-center heading_container text_center">
 <h2>
        Trabaja con nosotros!
      </h2>
    </div>
    <div class="row">
      <div class="col-md-6 ">
        <div class="form_container">
          <input type="hidden" name="_token" value="{{ csrf_token()}}"></input>
          <!--hace que el formulario sea seguro-->
          <form method="POST" action="" enctype="multipart/form-data">
            <!--enctype="multipart/form-data" hace que se envie el archivo-->
            <div>

              <label>Nombre: *</label>
              <input type="text" id="txtNombre" name="txtNombre" class="form-control" required>
            </div>
            <div>
              <label>Apellido: *</label>
              <input type="text" id="txtApellido" name="txtApellido" class="form-control" required>
            </div>
            <div>
              <label>Celular: *</label>
              <input type="text" id="txtCelular" name="txtCelular" class="form-control" required>
            </div>
            <div>
              <label>Correo: *</label>
              <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" required>
            </div>
            <label>CV:</label>
            <input type="file" id="archivo" name="archivo" class="">

            <div class="btn_box txt_center">
              <button type="submit" href="/gracias-postulacion">
                Enviar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Lo sacamos de inicio.blade.php-->
@endsection