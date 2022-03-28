<div id="packages" class="packages container-fluid hidden">
    <div class="description">
        <span class="text-center text_gradient"> Comprar Clases </span>
    </div>
    <div class="row justify-content-center classes">
        @php
            $firstClassId = 1;
        @endphp
        {{-- <div class="content-normal col col-sm col-md col-lg pickClass" style=" padding: 0;" id="prod-{{ $firstClassId}}">
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
            $amount = 2;
            $flag = true;
        @endphp

        @foreach ($products as $product)
        {{-- Products == Deals --}}
            @if ($product->type == "Deals" && $product->status == 1)
                <div class="content-normal pickClass mx-2" id="prod-{{ $product->id }}">
                    @guest
                        <div id="content-normal-deal" class="px-4 content-n" data-toggle="modal" data-target="#loginModal">
                    @endguest
                    @auth
                        @if (count($cards) > 0)
                            <div id="content-normal-deal" class="px-4 content-n" data-toggle="modal" data-target="#savedCardsModal">
                        @else
                            <div id="content-normal-deal" class="px-4 content-n" data-toggle="modal" data-target="#newCardChargeModal">
                        @endif
                    @endauth
                        <h5 id="package-description" class="mt-0 text-center mx-auto">Promoción <br><span id="DBDescription" class="text-center mx-auto">{{ $product->description }}<span></h5>
                        <h3 id="amountDeal">{{ $product->n_classes }}</h3>
                        @if ($product->n_classes > 1)
                            <h4 class="class">CLASES</h4>
                        @else
                            <h4 class="class">CLASE</h4>
                        @endif
                        <p class="precio" style="font-size: 17px; font-family: 'Avenir Next Condensed'; font-weight: 300;">${{ $product->price }}</p>
                        <p class="exp" style="font-size: 17px;">Expira: {{ $product->expiration_days }} días</p>
                        </div>
                </div>
                @php
                    $amount++;
                @endphp
            @endif
        @endforeach

        @foreach ($products as $product)
            @if ($product->type != "Deals" && $product->type != "Souvenir" && $product->type != "Free" && $product->status == 1)
                <div class="content-normal pickClass mx-2" id="prod-{{ $product->id }}">
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
                        <h3 id="amount6">{{ $product->n_classes }}</h3>
                        @if ($flag)
                            <h4 class="class">CLASE</h4>
                            {{ $flag=false }}
                        @else
                            <h4 class="class">CLASES</h4>
                        @endif
                        <p class="precio" style="font-size: 17px; font-family: 'Avenir Next Condensed'; font-weight: 300;">${{ $product->price }}</p>
                        <p class="exp" style="font-size: 17px;">Expira: {{ $product->expiration_days }} días</p>
                    </div>
                </div>
                @php
                    $amount++;
                @endphp
            @endif
        @endforeach
    </div>

    <div class="row justify-content-center">
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
                            <p id="oName">Ingresa a tu cuenta</p>
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
                                    {{-- <input type="hidden" name="tokenBearer" id="tokenBearer" value="{{ Session::get("tokenBearer")[0] }}"> --}}
                                <div class="">
                                    <img class="cards" src="/img/iconos/VISA.png" alt="Visa">
                                    <img class="cards" src="/img/iconos/MASTER.png" alt="Mastercard" >
                                    <img class="cards" src="/img/iconos/AMERICAN.png" alt="Express">
                                </div>
                                <div class="cInfo mx-auto mt-3">
                                    <select class="dataRow" name="savedCard" id="selectSavedCard">
                                        @foreach ($cards as $card)
                                            <option class="text-center mx-auto" value="{{ $card->id }}">Tarjeta con Terminación {{substr($card->card_number, -4) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="">
                                    <button type="button" class="button" id="use-new-card-button">Usar nueva tarjeta</button>
                                </div>
                                <div class="">
                                    <label for="conditions" class="conditions">AL dar click en "Comprar" acepta nuestros <a href="/legales" target="_blank">términos y condiciones</a></label>
                                </div>

                                <div class="OpenpayAdvice">
                                    <img style="width: 30%; height: 30%" name="Openpay" src="/img/iconos/conekta-logo-fondo-negro.png" alt="Openpay"><br />
                                    <label for="Openpay" style="font-size: 14px;">Transacciones realizadas vía Conekta</label>
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
                            <form method="POST" id="card-form">
                                @csrf
                                <div class="">
                                    <img class="cards" src="/img/iconos/VISA.png" alt="Visa">
                                    <img class="cards" src="/img/iconos/MASTER.png" alt="Mastercard" >
                                    <img class="cards" src="/img/iconos/AMERICAN.png" alt="Express">
                                </div>
                                <span class="card-errors text-danger"></span>
                                <input class="data mx-auto" type="text" name="name" id="cardOwner" placeholder="Nombre" maxlength="35" data-conekta="card[name]" required>
                                <input class="data mx-auto" type="text" name="number" id="cardNumber" placeholder="Número de tarjeta"  maxlength="20" data-conekta="card[number]" required>
                                <div class="cInfo mx-auto">
                                    <input class="dataRow" type="text" name="" id="Code" name="cvc" placeholder="CVV" maxlength="4"  data-conekta="card[cvc]" required>
                                    <select class="dataRow" name="" id="monthExpiration" name="exp_month" data-conekta="card[exp_month]" required>
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
                                    <select class="dataRow" name="" id="yearExpiration" name="exp_year" data-conekta="card[exp_year]" required>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                        <option value="2031">2031</option>
                                    </select>
                                </div>
{{--                                 <div class="">
                                    <input type="checkbox" name="data" id="dataCard">
                                    <label for="data">Guarda datos de mi tarjeta</label>
                                </div> --}}

                                <div class="">
                                    <label for="conditions" class="conditions">AL dar click en "Comprar" acepta nuestros <a href="/legales" target="_blank">términos y condiciones</a></label>
                                </div>

                                <div class="OpenpayAdvice">
                                    <img style="width: 30%; height: 30%" name="CONEKTA" src="/img/iconos/conekta-logo-fondo-negro.png" alt="Openpay"><br />
                                    <label for="Openpay" style="font-size: 14px;">Transacciones realizadas vía Conekta</label>
                                </div>
                            </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="closeBtn" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="button" id="payment-button">Comprar</button>
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