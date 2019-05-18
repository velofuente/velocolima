<footer>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="footerImg" src="/img/footer/2.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="footerImg" src="/img/footer/3.jpg" alt="Second slide">
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
    </div>
    <div class="footer container-fluid">
        <div class="row info-footer">
            <div class="col-12">
                <h3>Sé un coach vèlo</h3>
                <h5>Mándanos tus datos y nosotros nos ponemos en contacto contigo.</h5>
            </div>
            <div class="col-12 form">
                <div class="row justify-content-center align-items-center text-center">
                        <div class="col-2 pad">
                            <input type="text text-center" class="prospectText" name="prospectName" id="prospectName" placeholder="NOMBRE">
                        </div>
                        <div class="col-2 pad">
<<<<<<< Updated upstream
                            <input type="text" class="prospectText" name="prospectMail" id="prospectMail" placeholder="EMAIL">
                        </div>
                        <div class="col-2 pad">
                            <input type="text" class="prospectText" name="prospectPosition" id="prospectPosition" placeholder="TELEFONO">
=======
                            <input type="text text-center" class="prospectText" name="prospectMail" id="prospectMail" placeholder="EJEMPLO@EMAIL.COM">
                        </div>
                        <div class="col-2 pad">
                            <input type="text text-center" class="prospectText" name="prospectPosition" id="prospectPosition" placeholder="TELÉFONO">
>>>>>>> Stashed changes
                        </div>
                        <div class="col-2 pad">
                            <input type="text text-center" class="prospectText" name="prospectInsta" id="prospectInsta" placeholder="INSTAGRAM">
                        </div>
                </div>
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
                    <div class="col" id="sendCall">
                        <a href="tel:31400000000" target="_top">
                            {{-- <a href =""><img src="/img/iconos/TEL.png" alt="tel" width="110px" height="110px"></a> --}}
                            <img src="/img/iconos/TEL.png" alt="tel" width="110px" height="110px">
                            <h5 class="p-info">CONTÁCTANOS</h5>
                            <h5>312XXXXXXX</h5>
                        </a>
                    </div>
                    <div class="col" id="sendEmail">
                        <a href="mailto:rueda@velocycling.com?Subject=Sé%20véloz%20Contacto" target="_top">
                            {{-- <a href=""><img src="/img/iconos/MAIL.png" alt="mail" width="110px" height="110px"></a> --}}
                            <img src="/img/iconos/MAIL.png" alt="mail" width="110px" height="110px">
                            <h5 class="p-info">E-MAIL</h5>
                            <h5>rueda@velocycling.com</h5>
                        </a>
                    </div>
                    <div class="col">
                        {{-- <a href=""><img src="/img/iconos/UBICACION.png" alt="ubi" width="110px" height="110px"></a> --}}
                        <img src="/img/iconos/UBICACION.png" alt="ubi" width="110px" height="110px">
                        <h5 class="p-info">UBICACIÓN</h5>
                        <h5>Av. Ignacio Sandoval "La Cantera"</h5>
                        <h5>1948 int.A4</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>