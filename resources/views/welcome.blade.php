@extends('layout')
@section('title')
  Home
@endsection
@section('content')
<div class="mainPage" onclick="location.href='/schedule';">
    <img class="mainWelcomeImage" src="img/homepage/1.jpg" alt="principal" width="100%" height="50%">
    <img class="tinyMainWelcomeImage" src="img/homepage/1Vertical.png" alt="principal" width="100%" height="100%">
    <img class="icon" src="img/iconos/ICONO_O.png" alt="">
    <img class="veloBrand" src="img/iconos/LOGO.png" alt="">
    {{-- <img class="music" src="img/iconos/FRASEMUSICA.png" alt="">
    <img class="imusic" src="img/iconos/ICONO_MUSIC.png" alt=""> --}}
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
  $(document).ready(function() {
    Swal.fire({
      title: '¡Obtén tu primera clase gratis!',
      text: "Completa tu registro para recibir una clase gratis",
      type: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cerrar',
      confirmButtonText: 'Ir al registro'
    }).then((result) => {
      if (result.value) {
        window.location.replace("/register");
      }
    });
  })
</script>
@endsection
