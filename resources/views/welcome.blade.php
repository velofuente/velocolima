@extends('layout')
@section('title')
  Home
@endsection

@section('content')
<div class="mainPage" onclick="location.href='/schedule';">
    <img class="mainWelcomeImage" src="img/homepage/main.jpg" alt="principal" width="100%" height="50%">
    <img class="tinyMainWelcomeImage" src="img/homepage/small.jpg" alt="principal" width="100%" height="100%">
    <img class="icon" src="img/iconos/ICONO_O.png" alt="">
    <img class="veloBrand" src="img/iconos/LOGO.png" alt="">
    {{-- <img class="music" src="img/iconos/FRASEMUSICA.png" alt="">
    <img class="imusic" src="img/iconos/ICONO_MUSIC.png" alt=""> --}}
</div>

<!-- Automatically provides/replaces `Promise` if missing or broken. -->
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.js"></script>

<!-- Minified version of `es6-promise-auto` below. -->
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
@if(!Auth::check())
<script>
  $(document).ready(function() {
    Swal.fire({
      title: '¡Obtén tu primera clase gratis!',
      text: "Completa tu registro para recibir una clase gratis",
      type: 'info',
      showCancelButton: true,
      // background: '#131313',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cerrar',
      confirmButtonText: 'Ir al registro'
    }).then(function (result) {
      if (result.value) {
        window.location.replace("/register");
      }
    });
  })
</script>
@endif
@endsection
