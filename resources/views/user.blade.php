@extends('layouts.main')

@section('title')
    Velo | Usuario
@endsection

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                    <span class="text-center text_my_classes">Mis clases</span>
                    @if ($classes == null)
                        <p class="available_classes mb-0">0</p>
                    @else
                        <p class="available_classes mb-0">{{$classes}}</p>
                    @endif
                    <span class="classes_message">Clases disponibles en tu cuenta</span>
                    <a href="{{ url('/schedule') }}" class="btn gradient_button" id="bookClass" role="button" style="width: 275px; height: 45px;">Reservar</a>
                    <a href="{{ url('/schedule#packages') }}" class="btn gradient_button" id="buyPackages" role="button" style="width: 275px; height: 45px;">Comprar clases</a>
                </div>
                {{-- Change User Data & Password --}}
                <div id="userGeneralData" class="pt-4 pb-3 bb-3 border-bottom border-danger">
                    <h5 class="text-center mx-auto pt-2 myclss">Mis datos</h5>
                    <button type="button" class="btn bg-white text-dark text-center mb-3 mt-2 w-75 d-block mx-auto" data-toggle="collapse" data-target="#userData">+ Datos del usuario</button>
                    <div id="userData" class="collapse">
                        <form action="{{ url("/updateData") }}" method="post">
                            {{-- @method('PATCH') --}}
                            @csrf
                            <div class="d-block">
                                <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" name="name" value="{{ Auth::user()->name }}">
                                <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" name="last_name" value="{{ Auth::user()->last_name }}">
                                <input disabled readonly type="date" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" min="1900-01-01" max="2100-12-31" name="birth_date" value="{{ Auth::user()->birth_date }}">
                                <input type="number" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" name="phone" min="0" value="{{ Auth::user()->phone }}">
                                <input type="number" step=".1" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto bg-white" name="shoe_size" value="{{ Auth::user()->shoe_size }}">
                                {{-- {{dd(Auth::user())}} --}}
                            </div>
                            <button type="submit" class="btn d-block mx-auto mb-4 gradient_button" role="button">Guardar datos</button>
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
                    <h5 class="text-center mx-auto pt-2 myclss">Formas de pago</h5>

                    {{-- Print Card --}}
                    <div class="text-center text-uppercase">
                        @foreach ($cards as $card)
                            @if ($card->brand == "visa")
                                <a class="deleteUserCard" href="javascript:deleteUserCard({{$card->id}})">
                                    <div class="userCards">
                                        <img class="brandSavedCards" src="/img/iconos/VISA.png" alt="visa">
                                        <span style="margin-left: 3%">{{ substr($card->card_number, -4) }}</span>
                                    </div>
                                </a>
                            @elseif ($card->brand == "american_express")
                                <a class="deleteUserCard" href="javascript:deleteUserCard({{$card->id}})">
                                    <div class="userCards">
                                        <img class="brandSavedCards" src="/img/iconos/AMERICAN.png" alt="express">
                                        <span style="margin-left: 3%">{{ substr($card->card_number, -4) }}</span>
                                    </div>
                                </a>
                            @elseif ($card->brand == "mastercard")
                                <a class="deleteUserCard" href="javascript:deleteUserCard({{$card->id}})">
                                    <div class="userCards">
                                        <img class="brandSavedCards" src="/img/iconos/MASTER.png" alt="mastercard" >
                                        <span style="margin-left: 3%">{{ substr($card->card_number, -4) }}</span>
                                    </div>
                                </a>
                            @elseif ($card->brand == "carnet")
                                <a class="deleteUserCard" href="javascript:deleteUserCard({{$card->id}})">
                                    <div class="userCards">
                                        <img class="brandSavedCards" src="/img/iconos/CARNET.png" alt="carnet" >
                                        <span style="margin-left: 3%">{{ substr($card->card_number, -4) }}</span>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                    {{-- End Print Card --}}
                    <a class="btn bg-white text-dark text-center mb-2 mt-3 w-75 d-block mx-auto" data-toggle="modal" data-target="#addCardModal" role="button"><span>+ Añadir tarjeta</span></a>
                </div>
            </div>
            {{-- Classes Buttons --}}
            <div class="col-md-8 mb-4">
                {{-- Table with Nav Bar --}}
                <section id="tabs" class="project-tab">
                    {{-- @if (!empty($bookedClasses)) --}}
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-bookedClasses-tab" data-toggle="tab" href="#nav-bookedClasses" role="tab" aria-controls="nav-bookedClasses" aria-selected="true">Próximas clases</a>
                                        <a class="nav-item nav-link" id="nav-previousClasses-tab" data-toggle="tab" href="#nav-previousClasses" role="tab" aria-controls="nav-previousClasses" aria-selected="false">Clases pasadas</a>
                                        <a class="nav-item nav-link" id="nav-waitlist-tab" data-toggle="tab" href="#nav-waitlist" role="tab" aria-controls="nav-waitlist" aria-selected="false">Lista de espera</a>
                                        <a class="nav-item nav-link" id="nav-history-tab" data-toggle="tab" href="#nav-history" role="tab" aria-controls="nav-history" aria-selected="false">Historial de compras</a>
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
                                                        {{-- @if( date('Y',strtotime($bookedClass->schedule->day)) >= date('Y', strtotime(now())) )
                                                            @if( date('m',strtotime($bookedClass->schedule->day)) >= date('m', strtotime(now())) ) --}}
                                                                {{-- @if( \Carbon\Carbon::parse($bookedClass->schedule->day)->gte( now()->format('Y-m-d')) ) --}}
                                                                    {{-- @if (  \Carbon\Carbon::parse($bookedClass->schedule->hour)->gte( now()->format('H:i:s'))  ) --}}
                                                                    @php
                                                                        $scheduleFullDate = $bookedClass->schedule->day . ' ' . $bookedClass->schedule->hour
                                                                    @endphp
                                                                    @if ( \Carbon\Carbon::parse($scheduleFullDate)->gte( now()->format('Y-m-d H:i:s')) )
                                                                        <tr>
                                                                            <td>{{ date('d-M-Y', strtotime($bookedClass->schedule->day)) }}</td>
                                                                            <td>{{ date('h:i A', strtotime($bookedClass->schedule->hour)) }}</td>
                                                                            @switch($bookedClass->bike)
                                                                                @case(2)
                                                                                    <td>1</td>
                                                                                    @break
                                                                                @case(9)
                                                                                    <td>2</td>
                                                                                    @break
                                                                                @case(13)
                                                                                    <td>3</td>
                                                                                    @break
                                                                                @case(20)
                                                                                    <td>4</td>
                                                                                    @break
                                                                                @case(26)
                                                                                    <td>5</td>
                                                                                    @break
                                                                                @case(27)
                                                                                    <td>6</td>
                                                                                    @break
                                                                                @case(28)
                                                                                    <td>7</td>
                                                                                    @break
                                                                                @case(29)
                                                                                    <td>8</td>
                                                                                    @break
                                                                                @case(30)
                                                                                    <td>9</td>
                                                                                    @break
                                                                                @case(35)
                                                                                    <td>10</td>
                                                                                    @break
                                                                                @case(36)
                                                                                    <td>11</td>
                                                                                    @break
                                                                                @case(39)
                                                                                    <td>12</td>
                                                                                    @break
                                                                                @case(40)
                                                                                    <td>13</td>
                                                                                    @break
                                                                                @case(41)
                                                                                    <td>14</td>
                                                                                    @break
                                                                                @default
                                                                                    <td>14</td>
                                                                            @endswitch
                                                                            {{-- <td>{{ $bookedClass->bike }}</td> --}}
                                                                            @if($bookedClass->status == 'active')
                                                                                <td>Activo</td>
                                                                            @endif
                                                                            <td><button type="button" id="cancelClass-{{$bookedClass->id}}" class="btn btn-danger cancelClass" value="{{$bookedClass->schedule->hour}}_{{$bookedClass->schedule->day}}">Cancelar</button></td>
                                                                        </tr>
                                                                    @endif
                                                                {{-- @endif --}}
                                                            {{-- @endif
                                                        @endif --}}
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
                                                            <td>{{date('d-M-Y', strtotime($previousClass->scheduleWithTrashed->day))}}</td>
                                                            <td>{{date('h:i A', strtotime($previousClass->scheduleWithTrashed->hour))}}</td>
                                                            <td>{{$previousClass->scheduleWithTrashed->instructorWithTrashed->name}}</td>
                                                            {{-- <td>{{$previousClass->bike}}</td> --}}
                                                            @switch($previousClass->bike)
                                                                @case(2)
                                                                    <td>1</td>
                                                                    @break
                                                                @case(9)
                                                                    <td>2</td>
                                                                    @break
                                                                @case(13)
                                                                    <td>3</td>
                                                                    @break
                                                                @case(20)
                                                                    <td>4</td>
                                                                    @break
                                                                @case(26)
                                                                    <td>5</td>
                                                                    @break
                                                                @case(27)
                                                                    <td>6</td>
                                                                    @break
                                                                @case(28)
                                                                    <td>7</td>
                                                                    @break
                                                                @case(29)
                                                                    <td>8</td>
                                                                    @break
                                                                @case(30)
                                                                    <td>9</td>
                                                                    @break
                                                                @case(35)
                                                                    <td>10</td>
                                                                    @break
                                                                @case(36)
                                                                    <td>11</td>
                                                                    @break
                                                                @case(39)
                                                                    <td>12</td>
                                                                    @break
                                                                @case(40)
                                                                    <td>13</td>
                                                                    @break
                                                                @case(41)
                                                                    <td>14</td>
                                                                    @break
                                                                @default
                                                                    <td>14</td>
                                                            @endswitch
                                                            @switch($previousClass->status)
                                                                @case('cancelled')
                                                                    <td>Cancelado</td>
                                                                    @break
                                                                @case('absent')
                                                                    <td>Ausente</td>
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
                                                        <th>Clases</th>
                                                        <th width="30%">Descripción</th>
                                                        <th>Fecha de compra</th>
                                                        <th>Vigencia</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($purchaseHistory as $purchase)
                                                        @if($purchase->productWithTrashed->type != "Souvenir")
                                                            <tr>
                                                                <td>{{$purchase->productWithTrashed->n_classes}}</td>
                                                                <td>{{$purchase->productWithTrashed->description}}</td>
                                                                <td>{{date('d-M-Y', strtotime($purchase->created_at))}}</td>
                                                                <td>{{date('d-M-Y', strtotime($purchase->finalDate))}}</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td>N/A</td>
                                                                <td>{{$purchase->productWithTrashed->description}}</td>
                                                                <td>{{date('d-M-Y', strtotime($purchase->created_at))}}</td>
                                                                <td>N/A</td>
                                                            </tr>
                                                        @endif
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
        </div>

        {{-- Add Credit/Debit Card Fancy Modal --}}
        <div class="modal fade" id="addCardModal" tabindex="-1" role="dialog" aria-labelledby="addCardModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Agregar tarjeta</h5>
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
                                {{-- <input type="hidden" name="tokenBearer" id="tokenBearer" value="{{ Session::get("tokenBearer")[0]}}"> --}}
                                {{-- <input type="hidden" name="tokenBearer" id="csrfToken" value="{{ csrf_token() }}"> --}}
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
                    <button type="button" class="button addCardButton" id="add-card-button">Agregar tarjeta</button>
                </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
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

@section('extraScripts')
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <script src="{{ asset('/js/user-script.js') }}?{{ time() }}"></script>
    <script>
        // Jquery UI DatePicker (Safari)
        if ( $('[type="date"]').prop('type') != 'date' ) {
            $('[type="date"]').datepicker({
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
                dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                currentText: "Hoy",
                changeMonth: true,
                changeYear: true,
                yearRange: '-110:+0',
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateText, inst) {
                    $(inst).val(dateText); // Write the value in the input
                }
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
        var opSandbox = "{{ env('OPENPAY_SANDBOX') }}";
        var crfsToken = '{{ csrf_token() }}';

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