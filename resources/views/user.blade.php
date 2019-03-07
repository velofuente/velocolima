{{--{{dd($user)}}--}}
@extends('layout')
@section('title')
    Usuario
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="css/user-styles.css">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="flex-center position-ref full-height">
            <div class="text-white row main">
                <div class="col-md-5">
                    <h1 class="text-center text-info">{{ Auth::user()->name }}</h1>
                    <h1 class="text-center text-info">{{ Auth::user()->last_name }}</h1>
                    <br>
                    <h4 class="text-center">Mis Clases</h4>
                    <div id="clases" class="text-center">
                        <div class="classesButton">
                            <h1 class="text-info">0</h1>
                                <span>Classes</span><br>
                                <small class="text-secondary">* Clases disponibles en tu cuenta</small>
                        </div>
                        <a href="{{ url('/') }} .packages" class="btn btn-info mb-4" role="button">COMPRAR CLASES</a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div id="userGeneralData">
                        <button type="button" class="btn btn-secondary mb-2 mt-2 d-block mx-auto" data-toggle="collapse" data-target="#userData">Datos del usuario</button>
                        <div id="userData" class="collapse">
                            <form {{--method="post" action="{{ route('user.update', $user->id) }}"--}}>
                                @method('PATCH')
                                @csrf
                                <div class="d-block">
                                    <input type="text" class="form-control pl-3" style="background-color:white" name="name" value="{{ Auth::user()->name }}">
                                    <input type="text" class="form-control pl-3" style="background-color:white" name="last_name" value="{{ Auth::user()->last_name }}">
                                    <input type="email" class="form-control pl-3" style="background-color:white" name="email" value="{{ Auth::user()->email }}">
                                    <input type="date" class="form-control pl-3" style="background-color:white" name="birth_date" value="{{ Auth::user()->birth_date }}">
                                    <input type="text" class="form-control pl-3" style="background-color:white" name="phone" value="{{ Auth::user()->phone }}">
                                </div>
                                <button class="btn btn-info" role="button">Actualizar</button>
                            </form>
                        </div>
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto" data-toggle="collapse" data-target="#userPassword">Cambiar contraseña</button>
                        <div id="userPassword" class="collapse">
                            <div class="d-block">
                                <input type="password" class="form-control pl-3 mx-auto" style="background-color:white" placeholder="Contraseña">
                                <input type="password" class="form-control pl-3 mx-auto" style="background-color:white" placeholder="Confirmar contraseña">
                            </div>
                            <button class="btn btn-info mx-auto" type="submit" role="button">Guardar contraseña</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div id="shareCode" class="border border-info mx-auto circleDiv">
                        <h3 class="text-info">Invita, Comparte y GANA.</h3>
                        <h5 class="text-info">Tu código es: </h5>
                        <h4>1f57b5d5</h4>
                        <i class="fab fa-whatsapp mr-2" style="color:crimson;"></i><i class="fab fa-twitter" style="color:crimson;"></i>
                        <i class="fab fa-facebook mr-2" style="color:crimson;"></i><i class="fas fa-envelope" style="color:crimson"></i>
                    </div>
                </div>
                <div class="col-md-7">
                    <div id="Payments mt-2">
                        <h5 class="text-center mx-auto">Formas de Pago</h5>
                        <h5 class="text-center mx-auto">Mis tarjetas</h5>
                        <button class="btn btn-light mb-4 d-block mx-auto" role="button"><small>+ Añadir tarjeta</small></button>
                    </div>
                    <div id="extraInfo">
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Historial de pagos</button>
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Lista de espera</button>
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Clases anteriores</button>
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Clases expiradas</button>
                    </div>
                </div>
            </div>
         </div>
    </div>
@endsection
@section('extraScripts')
@endsection