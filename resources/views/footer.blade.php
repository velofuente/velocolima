<footer>
    {{-- Carousel (Not Responsive) --}}
    {{-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 footerImg" src="{{asset('/img/footer/2.jpg')}}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 footerImg" src="{{asset('/img/footer/3.jpg')}}" alt="Second slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div> --}}

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{asset('/img/footer/2.jpg')}}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('/img/footer/lateral.jpg')}}" alt="Second slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
      </div>

    <div class="footer container-fluid">
        <div class="row info-footer">
            <div class="col-12">
                <h3>Se un coach Vèlo</h3>
                <h5>Mándanos tus datos y nosotros nos ponemos en contacto contigo.</h5>
            </div>
            <div class="col-12 form">
                {{-- <form action="{{ url("/sendMail") }}" method="post"> --}}
                <form>
                    <div class="row mx-4 justify-content-center align-items-center text-center">
                        @csrf
                        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 pad">
                            <input type="text text-center" class="prospectText" name="name" id="name" placeholder="NOMBRE" required>
                        </div>
                        <input type="hidden" name="csrf" value="">
                        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 pad">
                            <input type="email" class="prospectText" name="email" id="email" placeholder="EMAIL" required>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 pad">
                            <input type="number" class="prospectText" name="phone" id="phone" placeholder="TELEFONO" required>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 pad">
                            <input type="text text-center" class="prospectText" name="instagram" id="instagram" placeholder="INSTAGRAM" required>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 pad">
                            <button class="btn btn-outline-secondary" id="buttonFormResponse">ENVIAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="footer container-fluid">
        <div class="row info-footer2">
            <div class="col-12 description info-top">
                <a class="navbar-brand" href="{{ url('/') }}"><img src="/img/iconos/LOGO.png" alt="logo" width="120px" height="65px"></a>
            </div>
            <div class="col-12 description">
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" id="sendEmail">
                        <a href="mailto:rueda@velocycling.mx?Subject=Sé%20véloz%20Contacto" target="_top">
                            {{-- <a href=""><img src="/img/iconos/MAIL.png" alt="mail" width="110px" height="110px"></a> --}}
                            <img src="/img/iconos/MAIL.png" alt="mail" width="110px" height="110px">
                            <h5 class="p-info">E-MAIL</h5>
                            <h5>rueda@velocycling.mx</h5>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-12 col-md-4 col-lg-4">
                        {{-- <a href=""><img src="/img/iconos/UBICACION.png" alt="ubi" width="110px" height="110px"></a> --}}
                        <img src="/img/iconos/UBICACION.png" alt="ubi" width="110px" height="110px">
                        <h5 class="p-info">UBICACIÓN</h5>
                        <h5>V. Carranza 1450 Local 26</h5>
                        <h5>Sta Bárbara, 28017 Colima, Col.</h5>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center" style="font-size: 13px;">
                Sistema desarrollado por <a class="witann" href="http://witann.com/" target="blank"> Witann Technologies.</a>
            </div>
        </div>
    </div>
    {{-- <script>

    </script> --}}
</footer>