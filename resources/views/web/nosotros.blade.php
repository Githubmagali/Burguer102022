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
                We Are Feane
              </h2>
            </div>
            <p>
              There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
              in some form, by injected humour, or randomised words which don't look even slightly believable. If you
              are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in
              the middle of text. All
            </p>
            <a href="">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->
  <!-- client section -->

  <section class="client_section pt-5 ">
    <div class="container">
      <div class="heading_container heading_center psudo_white_primary mb_45">
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
                <p>
                algunas cosas geniales
                </p>
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
                <p>
                  magna aliqua
                </p>
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
      <div class="py-5 txt-center">
        <h2>
         Trabaja con nosotros!
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="" enctype="multipart/form-data"> <!--enctype="multipart/form-data" hace que se envie el archivo-->
              <div>
                <input type="text" class="form-control" placeholder="Nombre"  name="txtNombre"/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Telefono" name="txtTelefono"/>
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Mail"name="txtEmail" /> <!--name hace que se envien los datos-->
              </div>
              <div>
               <label for="TxtMensaje">Mensaje:</label>
               <textarea name="TxtMensaje" id="TxtMensaje" class="form-control" cols="30" rows="10"></textarea>
              </div>
              <div>
              <label for="archivo" class="d-block">Adjunta tu cv:</label>
                <input type="file"name="archivo" id="archivo">
              </div>
              <div class="btn_box">
                <button type="submit">
                  Enviar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section> <!--Lo sacamos de inicio.blade.php-->
@endsection