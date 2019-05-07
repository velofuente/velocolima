<div id="packages" class="packages container-fluid">
    <div class="description">
        <img src="/img/iconos/1.png" width="500px" height="70px" alt="">
    </div>
    <div class="row classes">
        <div class="content-normal col col-sm col-md col-lg" style=" padding: 0;">
            <div id="first-class" data-toggle="modal" data-target="#exampleModalCenter" onclick="classQuantity('primera')">
                <img class="bicImg" src="/img/iconos/BICI.png" alt="">
                <h6 id="amount1">PRIMERA</h6>
                <h5 class="class f-class">CLASE</h5>
                <p class="price">$150</p>
                <p class="exp">Expira: 30 días</p>
            </div>
        </div>
        <div class="content-normal col col-sm col-md col-lg" style=" padding: 0;">
            <div id="content-normal" class="content-n" data-toggle="modal" data-target="#exampleModalCenter" onclick="classQuantity('1')">
                <h3 id="amount2">1</h3>
                <h5 class="class">CLASE</h5>
                <p class="price">$150</p>
                <p class="exp">Expira: 30 días</p>
            </div>
        </div>
        <div class="content-normal col col-sm col-md col-lg" style=" padding: 0;">
            <div id="content-normal" class="content-n" data-toggle="modal" data-target="#exampleModalCenter" onclick="classQuantity('5')">
                <h3 id="amount3">5</h3>
                <h5 class="class">CLASES</h5>
                <p class="price">$150</p>
                <p class="exp">Expira: 60 días</p>
            </div>
        </div>
        <div class="content-normal col col-sm col-md col-lg" style=" padding: 0;">
            <div id="content-normal" class="content-n" data-toggle="modal" data-target="#exampleModalCenter" onclick="classQuantity('10')">
                <h3 id="amount4">10</h3>
                <h5 class="class">CLASES</h5>
                <p class="price">$150</p>
                <p class="exp">Expira: 120 días</p>
            </div>
        </div>
        <div class="content-normal col col-sm col-md col-lg" style=" padding: 0;">
            <div id="content-normal" class="content-n" data-toggle="modal" data-target="#exampleModalCenter" onclick="classQuantity('25')">
                <h3 id="amount5">25</h3>
                <h5 class="class">CLASES</h5>
                <p class="price">$150</p>
                <p class="exp">Expira: 180 días</p>
            </div>
        </div>
        <div class="content-normal col col-sm col-md col-lg" style=" padding: 0;">
            <div id="content-normal" class="content-n" data-toggle="modal" data-target="#exampleModalCenter" onclick="classQuantity('50')">
                <h3 id="amount6">50</h3>
                <h5 class="class">CLASES</h5>
                <p class="price">$150</p>
                <p class="exp">Expira: 365 días</p>
            </div>
        </div>

        <!-- Modal -->
        @guest
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-dark">
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
                        <a id="btnLog" href="{{ route('login') }}" class="btn ">INICIAR SESIÓN</a>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
        @endguest
        @auth
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
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
                    <input class="data" type="text" name="" id="cOwner" placeholder="Nombre del tarjetahabiente" maxlength="35">
                    <input class="data" type="text" name="" id="cNumber" placeholder="Número de la tarjeta"  maxlength="16">
                    <select class="data" name="" id="monthExpiration">
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
                    <select class="data" name="" id="yearExpiration">
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    </select>
                    <input class="data" type="text" name="" id="Code" placeholder="CVV" maxlength="3">
                    <div class="data">
                    <input type="checkbox" name="data" id="data">
                    <label for="data">Guarda datos de mi tarjeta</label>
                    </div>
                    <input class="data" type="text" name="" id="Discount" placeholder="Código de descuento" maxlength="10">
                    <button type="button" class="btn btn-info">Aplicar código</button>
                    <div class="data">
                    <input type="checkbox" name="conditions" id="conditions">
                    <label for="conditions" class="conditions">Acepto términos y condiciones</label>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-secondary">Comprar</button>
            </div>
            </div>
        </div>
        </div>
        @endauth
    </div>
</div>