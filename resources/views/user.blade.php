@extends('layout')
@section('title')
    Velo | Usuario
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/user-styles.css')}}">
    <style>
        .tabTable {
            color: white !important;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection
@section('content')
    <div class="container main_div">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- <div class="flex-center position-ref full-height"> --}}

            {{-- User Name & Share Code --}}
            <div class="row justify-content-center mb-4 border-bottom border-danger">
                <div class="col-0 col-xs-6 col-sm-6 col-md-5 mb-4">
                    <div class="text-center">
                        <span class="text-center text_gradient"> Hola </span>
                        <span class="text-center user_name"> {{ Auth::user()->name }}</span>
                    </div>
                </div>
                <div class="col-0 col-xs-0 col-sm-0 col-md-2 mb-0">
                    <div>
                    </div>
                </div>
                <div class="col-6 col-xs-6 col-sm-6 col-md-5 mb-4">
                    <div class="text-center text_share_code">
                        <span>Tu código es:  </span>
                        <span class="text-center share_code"> {{ Auth::user()->share_code }} </span>
                    </div>
                </div>
            </div>

            {{-- Available Classes & User Data Buttons --}}
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3 text-center">
                    <div class="text-center" id="clases">
                        <span class="text-center text_my_classes">Mis Clases</span>
                        @if ($classes == null)
                            <p class="available_classes mb-0">0</p>
                        @else
                            <p class="available_classes mb-0">{{$classes}}</p>
                        @endif
                        <span class="classes_message">Clases disponibles en tu cuenta</span>
                        <a href="{{ url('/schedule#packages') }}" class="btn gradient_button mx-auto" id="buyPackages" role="button">Comprar Clases</a>
                    </div>
                    {{-- Change User Data & Password --}}
                    <div id="userGeneralData" class="pt-4 pb-3 bb-3 border-bottom border-danger">
                        <h5 class="text-center mx-auto pt-2 myclss">Mis Datos</h5>
                        <button type="button" class="btn bg-white text-dark text-center mb-3 mt-2 w-75 d-block mx-auto" data-toggle="collapse" data-target="#userData">+ Datos del usuario</button>
                        <div id="userData" class="collapse">
                            <form action="{{ url("/updateData") }}" method="post">
                                {{-- @method('PATCH') --}}
                                @csrf
                                <div class="d-block">
                                    <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" name="name" value="{{ Auth::user()->name }}">
                                    <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" name="last_name" value="{{ Auth::user()->last_name }}">
                                    <input type="date" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" min="1900-01-01" max="2100-12-31" name="birth_date" value="{{ Auth::user()->birth_date }}">
                                    <input type="number" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" name="phone" min="0" value="{{ Auth::user()->phone }}">
                                    <input type="number" step=".1" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" name="shoe_size" value="{{ Auth::user()->shoe_size }}">
                                </div>
                                <button type="submit" class="btn d-block mx-auto mb-4 gradient_button" role="button">Guardar Datos</button>
                            </form>
                        </div>
                        <button type="button" class="btn mb-3 bg-white text-dark text-center w-75 d-block mx-auto" data-toggle="collapse" data-target="#userPassword">+ Cambiar contraseña</button>
                        <div id="userPassword" class="collapse">
                            <form action="{{ route('updatePassword') }}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="d-block">
                                    <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} pl-3 w-75 d-block mx-auto mb-1 input_custom bg-white" placeholder="Contraseña" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control pl-3 w-75 d-block mx-auto input_custom mb-1 bg-white" placeholder="Confirmar contraseña">
                                </div>
                                <button class="btn d-block mx-auto mb-3 gradient_button" type="submit" role="button">Guardar contraseña</button>
                            </form>
                        </div>
                    </div>
                    {{-- My Classes & Buy Packages --}}
                    <div id="Payments" class="pt-4 pb-3 bb-2 border-bottom border-danger">
                        <h5 class="text-center mx-auto pt-2 myclss">Formas de Pago</h5>

                        {{-- Print Card --}}
                        @foreach ($cards as $card)
                            <div class="text-center text-uppercase" style ="color: #FFF">
                                 <a class="deleteUserCard" href="javascript:deleteUserCard({{$card->id}})">{{$card->card_number}} {{$card->brand}}</a>
                            </div>
                        @endforeach
                        {{-- End Print Card --}}
                        <a class="btn bg-white text-dark text-center mb-2 mt-2 w-75 d-block mx-auto" data-toggle="modal" data-target="#addCardModal" role="button"><span>+ Añadir tarjeta</span></a>
                    </div>
                </div>
                {{-- Classes Buttons --}}
                <div class="col-md-8 mb-4">
                    {{-- <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <button type="submit" class="btn regular_button mx-auto" id="incoming_classes_button" data-toggle="collapse" data-target="#divBooked">
                                    {{ __('Próximas Clases') }}
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="submit" class="btn regular_button mx-auto" id="past_classes_button" data-toggle="collapse" data-target="#divPrevious">
                                    {{ __('Clases Pasadas') }}
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="submit" class="btn regular_button mx-auto" id="waitlist_button" data-toggle="collapse" data-target="#divWait">
                                    {{ __('Waitlist') }}
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="submit" class="btn regular_button mx-auto" id="history_button" data-toggle="collapse" data-target="#divHistory">
                                    {{ __('Historial de Compras') }}
                            </button>
                        </div>
                    </div> --}}

                    {{-- Table with Nav Bar --}}
                    <section id="tabs" class="project-tab">
                        {{-- @if (!empty($bookedClasses)) --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-bookedClasses-tab" data-toggle="tab" href="#nav-bookedClasses" role="tab" aria-controls="nav-bookedClasses" aria-selected="true">Próximas Clases</a>
                                            <a class="nav-item nav-link" id="nav-previousClasses-tab" data-toggle="tab" href="#nav-previousClasses" role="tab" aria-controls="nav-previousClasses" aria-selected="false">Clases Pasadas</a>
                                            <a class="nav-item nav-link" id="nav-waitlist-tab" data-toggle="tab" href="#nav-waitlist" role="tab" aria-controls="nav-waitlist" aria-selected="false">Lista de Espera</a>
                                            <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">Historial de Compras</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        {{-- Booked Classes --}}
                                        <div class="tab-pane fade show active" id="nav-bookedClasses" role="tabpanel" aria-labelledby="nav-bookedClasses-tab">
                                            @if (count($bookedClasses) > 0)
                                                <table class="table table-striped table-dark" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Hora</th>
                                                            <th>Asiento</th>
                                                            <th>Estado</th>
                                                            <th>Accción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($bookedClasses as $bookedClass)
                                                            <tr>
                                                                <td>{{ date('d-M-Y', strtotime($bookedClass->schedule->day)) }}</td>
                                                                <td>{{ date('h:i A', strtotime($bookedClass->schedule->hour)) }}</td>
                                                                <td>{{ $bookedClass->bike }}</td>
                                                                @if($bookedClass->status == 'active')
                                                                    <td>Activo</td>
                                                                @endif
                                                                <td><button type="button" id="cancelClass-{{$bookedClass->id}}" class="btn btn-danger cancelClass">Cancelar</button></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <table class="table table-striped table-dark" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">No tienes próximas clases</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                        {{-- Previous Classes --}}
                                        <div class="tab-pane fade" id="nav-previousClasses" role="tabpanel" aria-labelledby="nav-previousClasses-tab">
                                            @if (count($previousClasses) > 0)
                                                <table class="table table-striped table-dark" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Hora</th>
                                                            <th>Instructor</th>
                                                            <th>Asiento</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($previousClasses as $previousClass)
                                                            <tr>
                                                                <td>{{date('d-M-Y', strtotime($previousClass->schedule->day))}}</td>
                                                                <td>{{date('h:i A', strtotime($previousClass->schedule->hour))}}</td>
                                                                <td>{{$previousClass->schedule->instructor->name}}</td>
                                                                <td>{{$previousClass->bike}}</td>
                                                                @switch($previousClass->status)
                                                                    @case('cancelled')
                                                                        <td>Cancelado</td>
                                                                        @break
                                                                    @case('taken')
                                                                        <td>Tomada</td>
                                                                        @break
                                                                    @default
                                                                    <td></td>
                                                                @endswitch
                                                                {{-- @if({{$previousClass->status == 'canceled'}})
                                                                    <td>Cancelado</td>
                                                                @else
                                                                    <td>Tomada</td>
                                                                @endif --}}
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <table class="table table-striped table-dark" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">No tienes clases pasadas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                        {{-- Wait List --}}
                                        <div class="tab-pane fade" id="nav-waitlist" role="tabpanel" aria-labelledby="nav-waitlist-tab">
                                            @if (count($UserWaitLists) > 0)
                                                <table class="table table-striped table-dark" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Instructor</th>
                                                            <th>Día</th>
                                                            <th>Hora</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($UserWaitLists as $userWaitList)
                                                            <tr>
                                                                <td>{{$userWaitList->waitList->schedule->instructor->name}}</td>
                                                                <td>{{date('d-M-Y', strtotime($userWaitList->waitList->schedule->day))}}</td>
                                                                <td>{{date('h:i A', strtotime($userWaitList->waitList->schedule->hour))}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <table class="table table-striped table-dark" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">No te encuentras en lista de espera</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                        {{-- Purchase History --}}
                                        <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
                                            @if (count($purchaseHistory) > 0)
                                                <table class="table table-striped table-dark" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Clases Compradas</th>
                                                            <th>Fecha de Compra</th>
                                                            <th>Vigencia</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($purchaseHistory as $purchase)
                                                            <tr>
                                                                <td>{{$purchase->product->n_classes}}</td>
                                                                <td>{{date('d M Y', strtotime($purchase->created_at))}}</td>
                                                                <td>{{date('d M Y', strtotime($purchase->finalDate))}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <table class="table table-striped table-dark" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">No tienes compras realizadas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- @endif --}}
                    </section>
                </div>

                {{-- User Name & Available Classes: col-md-5
                <div class="col-md-5">
                    <div class="text-center">
                        <span class="text-center hola_gradient"> Hola </span>
                        <span class="text-center user_name"> {{ Auth::user()->name }} {{ Auth::user()->last_name }}</span>
                    </div>
                    <br>
                    <div id="clases" class="text-center">
                        <h4 class="text-center font-weight-bold myclss">Mis Clases</h4>
                        <div class="classesButton">
                            <h1 class="myclss">0{{Auth::user()->classes}}</h1>
                                <span class="font-weight-bold myclss">Clases</span><br>
                                <small class="text-secondary font-weight-bold">* Clases disponibles en tu cuenta</small>
                        </div>
                        <a href="{{ url('/#packages') }}" class="btn text-white mb-4" style="background-color: #26C6CF" role="button">COMPRAR CLASES</a>
                    </div>
                </div> --}}

                {{-- User Data & Change Password: col-md-7
                <div class="col-md-7">
                    <div id="userGeneralData">
                        <button type="button" class="btn btn-secondary text-white mb-2 mt-2 w-50 d-block mx-auto" data-toggle="collapse" data-target="#userData">Datos del usuario</button>
                        <div id="userData" class="collapse">
                            <form method="post" action="{{ route('user.update', Auth::user()->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="d-block">
                                    <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto" name="name" value="{{ Auth::user()->name }}">
                                    <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto" name="last_name" value="{{ Auth::user()->last_name }}">
                                    <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto" name="phone" value="{{ Auth::user()->phone }}">
                                </div>
                                <button type="submit" class="btn text-white d-block mx-auto mb-3" style="background-color: #26C6CF" role="button">Actualizar</button>
                            </form>
                        </div>
                        <button type="button" class="btn mb-2 btn-secondary text-white w-50 d-block mx-auto" data-toggle="collapse" data-target="#userPassword">Cambiar contraseña</button>
                        <div id="userPassword" class="collapse">
                            <form action="{{ route('updatePassword') }}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="d-block">
                                    <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} pl-3 w-75 d-block mx-auto mb-1 input_custom" placeholder="Contraseña" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control pl-3 w-75 d-block mx-auto input_custom mb-1" placeholder="Confirmar contraseña">
                                </div>
                                <button class="btn text-white d-block mx-auto mb-3" style="background-color: #26C6CF" type="submit" role="button">Guardar contraseña</button>
                            </form>
                        </div>
                    </div>
                </div> --}}

                {{-- Share Code & Social Network: col-md-5
                <div class="col-md-5">
                    <div id="shareCode" class="border border-info mx-auto circleDiv">
                        <span class="align-middle invite">
                            <h3 class="text-body invite">Invita, Comparte y GANA.</h3>
                            <h5 class="text-muted">Tu código es: </h5>
                            <h4 class="text-danger">{{ Auth::user()->share_code }}</h4>
                            <i class="fab fa-whatsapp mr-2" id="media_icon" ></i><i class="fab fa-twitter" id="media_icon" ></i>
                            <i class="fab fa-facebook mr-2" id="media_icon" ></i><i class="fas fa-envelope" id="media_icon"></i>
                        </span>
                    </div>
                </div> --}}

                {{-- Add Card, Classes, Waitlist & Payments
                <div class="col-md-7">
                    <div id="Payments" class="mb-4">
                        <h5 class="text-center mx-auto myclss">Formas de Pago</h5>
                        <h5 class="text-center mx-auto mb-2 myclss">Mis tarjetas</h5>
                        <button class="btn btn-dark text-white mb-4 w-50 d-block mx-auto" data-toggle="modal" data-target="#addCardModal" role="button"><span>+ Añadir tarjeta</span></button>
                    </div>
                    <div id="extraInfo">
                        <button type="button" class="btn btn-secondary mb-2 text-white w-50 d-block mx-auto" st>Historial de pagos</button>
                        <button type="button" class="btn btn-secondary mb-2 text-white w-50 d-block mx-auto" st>Lista de espera</button>
                        <button type="button" class="btn btn-secondary mb-2 text-white w-50 d-block mx-auto" st>Clases anteriores</button>
                        <button type="button" class="btn btn-secondary mb-2 text-white w-50 d-block mx-auto" st>Clases expiradas</button>
                    </div>
                </div> --}}
            </div>

            <!-- Add Credit/Debit Card Modal !-->
            {{-- <div class="modal fade" id="addCardModal" tabindex="-1" role="dialog" aria-labelledby="addCardModalTitle" aria-hidden="true">
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
                                Form Add Card
                                <form method="post" id="add-card-form">
                                    @csrf
                                    <input type="hidden" name="token_id" id="token_id">
                                    <input type="hidden" name="device_session_id" id="device_session_id">
                                    <input type="hidden" name="tokenBearer" id="tokenBearer" value="{{ Session::get("tokenBearer")[0]}}">
                                    <div class="col-7">
                                        <div class="data">
                                            <img id="visa" src="/img/visa.png" alt="visa" width="83px" height="40px">
                                            <img src="/img/mastercard.png" alt="mastercard" width="83px" height="40px">
                                            <img src="/img/express.png" alt="express" width="85px" height="50px">
                                        </div>
                                        <input class="data" type="text" id="cardOwner" placeholder="Nombre del tarjetahabiente" value="Juan Perez Ramirez" data-openpay-card="holder_name">
                                        <input class="data" type="text" id="cardNumber" placeholder="Número de la tarjeta" value="4111111111111111" maxlength="16" data-openpay-card="card_number">
                                        <input class="data" type="text" id="monthExpiration" placeholder="Mes de Expiración" value="12" data-openpay-card="expiration_month">
                                        <input class="data" type="text" id="yearExpiration" placeholder="Año de Expiración" value="20" data-openpay-card="expiration_year">
                                        <input class="data" type="text" name="" id="cvv" placeholder="CVV" value="110" data-openpay-card="cvv2">
                                    </div>
                                </form>
                                End Form Add Card
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-dark" id="add-card-button">Agregar</button>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- Add Credit/Debit Card Fancy Modal --}}
            <div class="modal fade" id="addCardModal" tabindex="-1" role="dialog" aria-labelledby="addCardModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Tarjeta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- Form Add Card --}}
                    <div class="modal-body">
                            <form method="post" id="add-card-form" action="/user">
                                    @csrf
                                    <input type="hidden" name="token_id" id="token_id">
                                    <input type="hidden" name="device_session_id" id="device_session_id">
                                    <input type="hidden" name="tokenBearer" id="tokenBearer" value="{{ Session::get("tokenBearer")[0]}}">
                                    <input type="hidden" name="tokenBearer" id="csrfToken" value="{{ csrf_token() }}">
                                <div class="row justify-content-center">
                                    <img class="cards" src="/img/iconos/VISA.png" alt="visa">
                                    <img class="cards" src="/img/iconos/MASTER.png" alt="mastercard" >
                                    <img class="cards" src="/img/iconos/AMERICAN.png" alt="express">
                                </div>
                                <input class="data mx-auto" type="text" name="" id="cardOwner" placeholder="Nombre" maxlength="35" data-openpay-card="holder_name">
                                <input class="data mx-auto" type="text" name="" id="cardNumber" placeholder="Número de tarjeta"  maxlength="16" data-openpay-card="card_number">
                                    <div class="cInfo mx-auto">
                                        <select class="dataRow" name="" id="monthExpiration" data-openpay-card="expiration_month">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        <select class="dataRow" name="" id="yearExpiration" data-openpay-card="expiration_year">
                                            <option value="19">2019</option>
                                            <option value="20">2020</option>
                                            <option value="21">2021</option>
                                            <option value="22">2022</option>
                                            <option value="23">2023</option>
                                            <option value="24">2024</option>
                                            <option value="25">2025</option>
                                            <option value="26">2026</option>
                                            <option value="27">2027</option>
                                            <option value="28">2028</option>
                                            <option value="29">2029</option>
                                        </select>
                                    <input class="dataRow" type="text" name="" id="Code" placeholder="CVV" maxlength="4" data-openpay-card="cvv2">
                                </div>
                            </form>
                    </div>
                    {{-- End Form Add Card --}}
                    <div class="modal-footer">
                        <button type="button" class="closeBtn" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="button addCardButton" id="add-card-button">Agregar Tarjeta</button>
                    </div>
                    </div>
                </div>
            </div>

        {{-- </div> --}}
    </div>
@include('footer')

{{-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

{{-- <script type="text/javascript">
    var deviceSessionId = null;
    var token_id = null;
    var tokenBearer = null;
    var crfsToken = '{{ csrf_token() }}';

    $(document).ready(function() {
        OpenPay.setId('mwykro9vagcgwumpqaxb');
        OpenPay.setApiKey('pk_d72eec48f13042949140a7873ee1b3c2');
        OpenPay.setSandboxMode(true);
        //Se genera el id de dispositivo
        device_session_id = OpenPay.deviceData.setup("add-card-form", "deviceIdHiddenFieldName");
        $('#device_session_id').val(device_session_id);

        $('#add-card-button').on('click', function(event) {
            event.preventDefault();
            $("#add-card-button").prop( "disabled", true);
            OpenPay.token.extractFormAndCreate('add-card-form', sucess_callbak, error_callbak);
            console.log(OpenPay);
        });

        var sucess_callbak = function(response) {
            token_id = response.data.id;
            $('#token_id').val(token_id);
            // Submit Form
            addCard();
            $('#add-card-form').submit();
        };

        var error_callbak = function(response) {
            var desc = response.data.description != undefined ? response.data.description : response.message;
            alert("ERROR [" + response.status + "] " + desc);
            $("#add-card-button").prop("disabled", false);
        };

        function addCard(){
            tokenBearer = $('#tokenBearer').val();
            console.log('si entro');
            $.ajax({
                url: "/api/addCard",
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${tokenBearer}`
                },
                data: {
                    _token: crfsToken,
                    token_id: token_id,
                    device_session_id: device_session_id,
                    customer_id: ''
                },
                success: function(result){
                    console.log(result);
                }
            });
            console.log('token_id: ', token_id);
            console.log('device_session_id: ', device_session_id);
            console.log('Token CRSF: ', crfsToken);
            console.log('Bearer: ', tokenBearer);
        };
    });
</script> --}}
@endsection

@section('extraScripts')
    <script src="{{ asset('/js/user-script.js') }}"></script>
    <script>var crfsToken = '{{ csrf_token() }}';</script>
    <script>
        // // Jquery UI DatePicker (Safari)
        if ( $('[type="date"]').prop('type') != 'date' ) {
            $('[type="date"]').datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1920:2013',
                dateFormat: 'yy-mm-dd',
                // showButtonPanel: true,
            });
        }
    </script>
    <script>
        // Select the Phone Input.
        var phoneInput = document.getElementById('phone');
        var cardNumberInput = document.getElementById('cardNumber');
        var cvvInput = document.getElementById('Code');
        var opId = "{{ env('OPENPAY_ID') }}";
        var opPublicKey = "{{ env('OPENPAY_PUBLIC_KEY') }}";
        var opSandbox = {{ env('OPENPAY_SANDBOX') }};

        // Lock the input only to numbers.
        phoneInput.onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8 || e.keyCode == 9)) {
                return false;
            }
        }
        cardNumberInput.onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8 || e.keyCode == 9)) {
                return false;
            }
        }
        cvvInput.onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8 || e.keyCode == 9)) {
                return false;
            }
        }
    </script>
@endsection