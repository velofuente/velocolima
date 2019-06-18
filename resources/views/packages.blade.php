<div id="packages" class="packages container-fluid">
    <div class="description">
        {{-- <img class="buyClass" src="/img/iconos/1.png" alt="Comprar Clases"> --}}
        <span class="text-center text_gradient"> Comprar Clases </span>
    </div>
    <div class="row justify-content-center classes">
        @php
            $firstClassId = 1;
        @endphp
        {{-- <div class="content-normal col col-sm col-md col-lg pickClass" style=" padding: 0;" id="prod-{{$firstClassId}}">
            <div id="first-class" data-toggle="modal" data-target="#newCardChargeModal">
            <div id="first-class" data-toggle="modal" data-target="#newCardChargeModal" onclick="classQuantity('primera')" class="pickClass">
                <img class="bicImg" src="/img/iconos/BICI.png" alt="">
                <h6 id="amount1">PRIMERA</h6>
                <p class="class f-class">CLASE</p>
                <p class="price">$150</p>
                <p class="exp">Expira: 30 días</p>
            </div>
        </div> --}}
        @php
            $amount=2;
            $flag=true;
        @endphp
        @foreach ($products as $product)
            @if ($product != $products{0} && $product->type != "Deals" && $product->status == 1)
                {{-- {{dd($product)}} --}}
                {{-- <div class="content-normal pickClass" style=" margin-left: 10px; min-width: 190px !important; min-height: 280px !important;" id="prod-{{$product->id}}"> --}}
                <div class="content-normal pickClass mx-2" id="prod-{{$product->id}}">
                    @guest
                        <div id="content-normal" class="px-4 content-n" data-toggle="modal" data-target="#loginModal">
                    @endguest
                    @auth
                        @if (count($cards) > 0)
                            <div id="content-normal" class="px-4 content-n" data-toggle="modal" data-target="#savedCardsModal">
                        @else
                            <div id="content-normal" class="px-4 content-n" data-toggle="modal" data-target="#newCardChargeModal">
                        @endif
                    @endauth
                    {{-- <div id="content-normal" class="content-n" data-toggle="modal" data-target="#savedCardsModal" onclick="classQuantity('{{ $product->n_classes }}')" class="pickClass"> --}}
                        <h3 id="amount{{$amount}}">{{$product->n_classes}}</h3>
                        @if ($flag)
                            <h4 class="class">CLASE</h4>
                            {{$flag=false}}
                        @else
                            <h4 class="class">CLASES</h4>
                        @endif
                        <p class="precio" style="font-size: 17px; font-family: 'Avenir Next Condensed'; font-weight: 300;">${{$product->price}}</p>
                        <p class="exp" style="font-size: 17px;">Expira: {{$product->expiration_days}} días</p>
                        {{-- <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}"> --}}
                    </div>
                </div>
                @php
                    $amount++;
                @endphp
            @endif
        @endforeach
        <!-- LogIn Modal -->
        @guest
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-5">
                        <p id="oName">Ingresa a tu Cuenta</p>
                    </div>
                    <div class="col-7">
                        <a id="btnLog" href="{{ route('login') }}" class="button">Acceder</a>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="closeBtn" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
        @endguest
        @auth
            {{-- Use a Saved Card Modal--}}
                <div class="modal" id="savedCardsModal" tabindex="-1" role="dialog" aria-labelledby="savedCardsModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="payment-form-unsaved-card">
                                        @csrf
                                        <input type="hidden" name="token_id" id="token_id">
                                        <input type="hidden" name="device_session_id" id="device_session_id">
                                        <input type="hidden" name="tokenBearer" id="tokenBearer" value="{{ Session::get("tokenBearer")[0]}}">
                                    <div class="">
                                        <img class="cards" src="/img/iconos/VISA.png" alt="Visa">
                                        <img class="cards" src="/img/iconos/MASTER.png" alt="Mastercard" >
                                        <img class="cards" src="/img/iconos/AMERICAN.png" alt="Express">
                                    </div>
                                    <div class="cInfo mx-auto mt-3">
                                        <select class="dataRow" name="savedCard" id="selectSavedCard">
                                            @foreach ($cards as $card)
                                                <option class="text-center mx-auto" value="{{$card->id}}">Tarjeta con Terminación {{substr($card->card_number, -4)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="">
                                        <button type="button" class="button" id="use-new-card-button">Usar Nueva Tarjeta</button>
                                    </div>
                                    <div class="">
                                        <input type="checkbox" name="conditions" id="conditions" required>
                                        <label for="conditions" class="conditions">Acepto <a href="/legales" target="_blank">términos y condiciones</a></label>
                                    </div>

                                    <div class="OpenpayAdvice">
                                        <img style="width: 30%; height: 30%" name="Openpay" src="/img/iconos/OPENPAY_oscuro.png" alt="Openpay"><br />
                                        <label for="Openpay" style="font-size: 14px;">Transacciones realizadas vía Openpay</label>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="closeBtn" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="button" id="pay-selected-card-button">Comprar</button>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- Make Charge With An Unsaved Card Modal--}}
                <div class="modal" id="newCardChargeModal" tabindex="-1" role="dialog" aria-labelledby="newCardChargeModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content ">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form method="post" id="payment-form">
                                        @csrf
                                        <input type="hidden" name="token_id" id="token_id">
                                        <input type="hidden" name="device_session_id" id="device_session_id">
                                        <input type="hidden" name="tokenBearer" id="tokenBearer" value="{{ Session::get("tokenBearer")[0]}}">
                                    <div class="">
                                        <img class="cards" src="/img/iconos/VISA.png" alt="Visa">
                                        <img class="cards" src="/img/iconos/MASTER.png" alt="Mastercard" >
                                        <img class="cards" src="/img/iconos/AMERICAN.png" alt="Express">
                                    </div>
                                <input class="data mx-auto" type="text" name="" id="cardOwner" placeholder="Nombre" maxlength="35" data-openpay-card="holder_name" >
                                    <input class="data mx-auto" type="text" name="" id="cardNumber" placeholder="Número de tarjeta"  maxlength="16" data-openpay-card="card_number">
                                        <div class="cInfo mx-auto">
                                            <select class="dataRow" name="" id="monthExpiration" data-openpay-card="expiration_month">
                                                <option value="01">1</option>
                                                <option value="02">2</option>
                                                <option value="03">3</option>
                                                <option value="04">4</option>
                                                <option value="05">5</option>
                                                <option value="06">6</option>
                                                <option value="07">7</option>
                                                <option value="08">8</option>
                                                <option value="09">9</option>
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
                                    <div class="">
                                        <input type="checkbox" name="data" id="dataCard">
                                        <label for="data">Guarda datos de mi tarjeta</label>
                                    </div>

                                    <input class="data mx-auto" type="text" name="" id="Discount" placeholder="Código de descuento" maxlength="10">
                                    <button type="button" class="button">Aplicar código</button>

                                    <div class="">
                                        <input type="checkbox" name="conditions" id="conditions" required>
                                        <label for="conditions" class="conditions">Acepto <a href="/legales" target="_blank">términos y condiciones</a></label>
                                    </div>

                                    <div class="OpenpayAdvice">
                                        <img style="width: 30%; height: 30%" name="Openpay" src="/img/iconos/OPENPAY_oscuro.png" alt="Openpay"><br />
                                        <label for="Openpay" style="font-size: 14px;">Transacciones realizadas vía Openpay</label>
                                    </div>

                                </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="closeBtn" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="button" id="pay-button">Comprar</button>
                        </div>
                        </div>
                    </div>
                </div>
        @endauth
    </div>
    <script>
        var cardNumberInput = document.getElementById('cardNumber');
        var cvvInput = document.getElementById('Code');

        // Lock the input only to numbers.
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
</div>