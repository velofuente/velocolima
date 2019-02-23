@extends('layout')
@section('title')
Rolo
@endsection
@section('content')
    <div class="content container-fluid">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carouselExampleIndicators" data-slide-to="0"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
                    </ol>
                    <div class="carousel-inner">
                      <div class="carousel-item">
                        <img class="responsive" src="/img/chava.png" height="auto" width="auto" alt="First slide">
                      </div>
                      <div class="carousel-item active">
                        <iframe class="responsive" src="https://www.youtube.com/embed/8u3lxYA-WWI?enablejsapi=1&origin=http%3A%2F%2Frolo.com.mx&theme=dark&wmode=opaque&rel=0&vq=highres&start=0&showinfo=0&modestbranding=1&playsinline=0&controls=0&widgetid=1" 
                        height="auto" width="auto" alt="Second slide">
                            <p>Your browser does not support iframes.</p>
                        </iframe>
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

        </div>
    <div class="packages container-fluid">
      <div class="description">
        <h3>¡Compra tu pack de clases!!</h3>
        <h5>Se parte de nuestra tribu.</h5>
      </div>
      <div class="row classes">
              <div class="content-normal col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div id="content-normal">
                  <i class="fa fa-gift" aria-hidden="true"></i>
                  <h6>PRIMERA</h6>
                  <h5>CLASE</h5>
                  <p class="precio">$100MN</p>
                </div>
              </div>
              <div class="content-normal col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div id="content-normal">
                  <h3>1</h3>
                  <h5>CLASE</h5>
                  <p class="precio">$190MN</p>
                </div>
              </div>
              <div class="content-normal col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div id="content-special">
                  <h3>3</h3>
                  <h5>CLASES</h5>
                  <p class="precio">$400MN</p>
                </div>
              </div>
              <div class="content-normal col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div id="content-normal">
                  <h3>5</h3>
                  <h5>CLASES</h5>
                  <p class="precio">$875MN</p>
                </div>
              </div>
              <div class="content-normal col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div id="content-normal">
                  <h3>10</h3>
                  <h5>CLASES</h5>
                  <p class="precio">$1,590MN</p>
                </div>
              </div>
              <div class="content-normal col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div id="content-normal">
                  <h3>25</h3>
                  <h5>CLASES</h5>
                  <p class="precio">$3,625MN</p>
                </div>
              </div>
              <div class="content-normal col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div id="content-normal">
                  <h3>50</h3>
                  <h5>CLASES</h5>
                  <p class="precio">$5,990MN</p>
                </div>
              </div>
      </div>
    </div>
@endsection
