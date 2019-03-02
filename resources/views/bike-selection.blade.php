@extends('layout')
@section('title')
Reservar Bici
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="css/style-bike.css">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="select">
            <a href=""id="goBack">Regresar al calendario</a>
            <h3 id="selection">SELECCIONA TU BICI</h3>
            <img id="profilePic" src="/img/lili.png" width="100em" height="100em" alt="">
        </div>
        <div class="places">
            <div class="row">
                <div class="col">
                    <p class="bikes">1</p>
                    <p class="bikes">2</p>
                    <p class="bikes">3</p>
                    <p class="bikes">4</p>
                    <p class="bikes">5</p>
                    <p class="bikes">6</p>
                    <p class="bikes">7</p>
                </div>
                <div class="col">
                    <p class="bikes">8</p>
                    <p class="bikes">9</p>
                    <p class="bikes">10</p>
                    <p class="bikes">11</p>
                    <p class="bikes">12</p>
                    <p class="bikes">13</p>
                    <p class="bikes">14</p>
                </div>
                <div class="col">
                    <p class="bikes">15</p>
                    <p class="bikes">16</p>
                    <p class="bikes">17</p>
                    <p class="bikes">18</p>
                    <p class="bikes">19</p>
                    <p class="bikes">20</p>
                    <p class="bikes">21</p>
                </div>
                <div class="col">
                    <p class="bikes">22</p>
                    <p class="bikes">23</p>
                    <p class="bikes">24</p>
                    <p class="bikes">25</p>
                    <p class="bikes">26</p>
                    <p class="bikes">27</p>
                    <p class="bikes">28</p>
                </div>
                <div class="col">
                    <p class="bikes">29</p>
                    <p class="bikes">30</p>
                    <p class="bikes">31</p>
                    <p class="bikes">32</p>
                    <p class="bikes">33</p>
                    <p class="bikes">34</p>
                    <p class="bikes">35</p>
                </div>
                <div class="col">
                    <p class="bikes">36</p>
                    <p class="bikes">37</p>
                    <p class="bikes">38</p>
                    <p class="bikes">39</p>
                    <p class="bikes">40</p>
                    <p class="bikes">41</p>
                    <p class="bikes">42</p>
                </div>
            </div>
        </div>
        <div class="details">
            <div class="row">
                <div class="col">
                    <div>
                        <h5 class="first">UBICACIÓN</h5>
                        <h5>PROVIDENCIA</h5>
                    </div>
                    <div>
                        <h5 class="first">FECHA & HORA</h5>
                        <h5>Miércoles 27 de Febrero / 08:00am</h5>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <h5 class="first">INSTRUCTOR</h5>
                        <h5>Lili</h5>
                    </div>
                    <div>
                        <h5 class="first">NO. DE LUGAR</h5>
                        <h5 id="placeNum">--</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extraScripts')
    <script src="js/bike-selection-script.js"></script>
@endsection