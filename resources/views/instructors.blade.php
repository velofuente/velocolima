@extends('layout')

@section('title')
Rolo | Conoce a los Instructores
@endsection

@section('content')
    <body style="background-color: #222222">
        <div class="container-fluid">
            <div class="title">
                <div class="display-4 font-weight-bold text-center pt-3 pb-3">
                    ROLO TRIBE
                </div>
            </div>

            <div class="container mx-auto mt-3" name="instructors" >
                <div class="row">
                    {{-- Instructor 1 --}}
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                                <img src="https://rolo.com.mx/wp-content/uploads/2019/02/Site_Head.png" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="/instructor-info" class="h4" style="text-decoration: none; color: #7FDCE0">Tania</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Instructor 2 --}}
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                                <img src="https://rolo.com.mx/wp-content/uploads/2019/01/38_E-2.png" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="#" class="h4" style="text-decoration: none; color: #7FDCE0">Paola</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Instructor 3 --}}
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                                <img src="https://rolo.com.mx/wp-content/uploads/2019/01/IMG_8554_2SQUARE-2.png" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="/instructor-info" class="h4" style="text-decoration: none; color: #7FDCE0">Dani</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Instructor 4 --}}
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                                <img src="https://rolo.com.mx/wp-content/uploads/2019/01/Mel_37.png" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="/instructor-info" class="h4" style="text-decoration: none; color: #7FDCE0">Mel</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Instructor 5 --}}
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                                <img src="https://rolo.com.mx/wp-content/uploads/2019/01/Gabs_Prof-4.jpg" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="/instructor-info" class="h4" style="text-decoration: none; color: #7FDCE0">Gabi</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Instructor 6 --}}
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                                <img src="https://rolo.com.mx/wp-content/uploads/2019/01/DSC00169_E-5.jpg" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="/instructor-info" class="h4" style="text-decoration: none; color: #7FDCE0">Santi</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Instructor 7 --}}
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                                <img src="https://rolo.com.mx/wp-content/uploads/2019/02/Franz_head2-2.png" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="/instructor-info" class="h4" style="text-decoration: none; color: #7FDCE0">Franz</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Instructor 8 --}}
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                                <img src="https://rolo.com.mx/wp-content/uploads/2019/01/44_E-4.png" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="/instructor-info" class="h4" style="text-decoration: none; color: #7FDCE0">Lili</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- Instructor 9 --}}
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                                <img src="https://rolo.com.mx/wp-content/uploads/2019/01/REG32-1.png" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="/instructor-info" class="h4" style="text-decoration: none; color: #7FDCE0">Regina</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection