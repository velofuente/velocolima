@extends('layout')
@section('title')
    Usuario
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/user-styles.css')}}">
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
                        <a href="{{ url('/#packages') }}" class="btn btn-info mb-4" role="button">COMPRAR CLASES</a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div id="userGeneralData">
                        <button type="button" class="btn btn-secondary mb-2 mt-2 d-block mx-auto" data-toggle="collapse" data-target="#userData">Datos del usuario</button>
                        <div id="userData" class="collapse">
                            <form method="post" action="{{ route('user.update', Auth::user()->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="d-block">
                                    {{--<input type="hidden" value="{{ Auth::user()->id }}">--}}
                                    <input type="text" class="form-control pl-3 input_custom" name="name" value="{{ Auth::user()->name }}">
                                    <input type="text" class="form-control pl-3 input_custom" name="last_name" value="{{ Auth::user()->last_name }}">
                                    <input type="text" class="form-control pl-3 input_custom" name="phone" value="{{ Auth::user()->phone }}">
                                </div>
                                <button type="submit" class="btn btn-info" role="button">Actualizar</button>
                            </form>
                        </div>
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto" data-toggle="collapse" data-target="#userPassword">Cambiar contraseña</button>
                        <div id="userPassword" class="collapse">
                            <form action="{{ route('updatePassword') }}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="d-block">
                                    <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} pl-3 mx-auto input_custom" placeholder="Contraseña" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control pl-3 mx-auto input_custom" placeholder="Confirmar contraseña">
                                </div>
                                <button class="btn btn-info mx-auto" type="submit" role="button">Guardar contraseña</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div id="shareCode" class="border border-info mx-auto circleDiv">
                        <h3 class="text-info">Invita, Comparte y GANA.</h3>
                        <h5 class="text-info">Tu código es: </h5>
                        <h4>{{ Auth::user()->share_code }}</h4>
                        <i class="fab fa-whatsapp mr-2" id="media_icon" ></i><i class="fab fa-twitter" id="media_icon" ></i>
                        <i class="fab fa-facebook mr-2" id="media_icon" ></i><i class="fas fa-envelope" id="media_icon"></i>
                    </div>
                </div>
                <div class="col-md-7">
                    <div id="Payments mt-2">
                        <h5 class="text-center mx-auto">Formas de Pago</h5>
                        <h5 class="text-center mx-auto">Mis tarjetas</h5>
                        <button class="btn btn-light mb-4 d-block mx-auto" data-toggle="modal" data-target="#addCardModal" role="button"><small>+ Añadir tarjeta</small></button>
                    </div>
                    <div id="extraInfo">
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Historial de pagos</button>
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Lista de espera</button>
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Clases anteriores</button>
                        <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Clases expiradas</button>
                    </div>
                </div>
            </div>
            <!-- Add Credit/Debit Card Modal !-->
            <div class="modal fade" id="addCardModal" tabindex="-1" role="dialog" aria-labelledby="addCardModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCardModalTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-5">
                                    <p id="oName">{{ Auth::user()->name }} {{ Auth::user()->last_name}}</p>
                                </div>
                                <div class="col-7">
                                    <div class="data">
                                        <img id="visa" src="/img/visa.png" alt="visa" width="83px" height="40px">
                                        <img src="/img/mastercard.png" alt="mastercard" width="83px" height="40px">
                                        <img src="/img/express.png" alt="express" width="85px" height="50px">
                                    </div>
                                    <input class="data" type="text" name="" id="cOwner" placeholder="Nombre del tarjetahabiente">
                                    <input class="data" type="text" name="" id="cNumber" placeholder="Número de la tarjeta">
                                    <select class="data" name="" id="monthExpiration">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select class="data" name="" id="yearExpiration">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{ now()->format('Y') }}">{{ now()->modify('+'. $i .' year')->format('Y') }}</option>
                                        @endfor
                                    </select>
                                    <input class="data" type="text" name="" id="Code" placeholder="CVV">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-secondary">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extraScripts')
@endsection