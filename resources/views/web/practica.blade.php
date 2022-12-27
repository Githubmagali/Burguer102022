@extends('web.plantilla')
@section('contenido')

<footer class="footer_section">
      <div class="container">
        <div class="row">
          @foreach($aClientes as $cliente)
          <div class="col-3 footer-col">
            <div class="footer_contact">
              <h4>
                {{$cliente->nombre}}
              </h4>
              <div class="contact_link_box">
                <a target="_blank" href="">
                  <i class="fa fa-phone" aria-hidden="true"></i>
                  <span>
                    {{$cliente->apellido}}
                  </span>
                </a>
                <a href="">

                  <span>
                    {{$cliente->correo}}
                  </span>
                </a>
                <a target="_blank" href="">
                  <span>
                    {{$cliente->celular}}
                  </span>
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="footer-info">
          <p>
            &copy; <span id="displayYear"></span>All right reserved By
            <a href="https://html.desing/">Free html Templates</a><br>
            &copy; <span id="displayYear"></span>Distributed By
            <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
          </p>
        </div>
      </div>
    </footer>

    @endsection