@extends('layouts.main')

@section('title')
    Conoce a los Instructores
@endsection

@section('content')
    <div class="container">
        {{-- Header & Search Bar --}}
        <div class="title">
            <div class="display-4 text-center pt-3 pb-3">INSTRUCTORES</div>
        </div>

        {{-- Instructors --}}
        <div class="container mx-auto mt-4" name="instructors">
            <div class="row">
                @if (count($instructors) > 0)
                    @foreach ($instructors as $instructor)
                        <div class="col-md-4 col-sm-6 col-xs-6">
                        <a href="/instructors/{{ $instructor->id }}" class="h4" style="text-decoration: none">
                            <div class="card border-0 mx-auto my-3">
                                @php
                                    unset($exists);
                                    $originalImage = str_replace('.png', '', $instructor->profile_image);
                                    $originalImage = str_replace('.jpg', '', $originalImage);
                                    $originalImage = str_replace('.jpeg', '', $originalImage);
                                    $existsPng = file_exists(public_path().$originalImage.'.png');
                                    $existsJpg = file_exists(public_path().$originalImage.'.jpg');
                                    $existsJpeg = file_exists(public_path().$originalImage.'.jpeg');
                                    $profilePath = null;
                                    // $exists = ($existsPng && $existsJpg) ? true : false;
                                    if ($existsJpg) {
                                        $profilePath = $originalImage.'.jpg';
                                    } else {
                                        if ($existsJpeg) {
                                            $profilePath = $originalImage.'.jpeg';
                                        } elseif ($existsPng) {
                                            $profilePath = $originalImage.'.png';
                                        }
                                    }
                                @endphp
                                @if ($profilePath)
                                    <img src="{{ $profilePath }}" class="card-img-top instructor-head" alt="{{ $instructor->name }}" onerror="this.src='/img/instructors/instructor-head-tall.png'; this.className='card-img-top'">
                                @else
                                    <img src="/img/instructors/instructor-head-tall.png" class="card-img-top" alt="{{ $instructor->name }}">
                                @endif
                                <div class="card-body">
                                    <p class="card-text text-center" id="instructorName">
                                        {{ $instructor->name }}
                                    </p>
                                </div>
                            </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <h3 class="text-center text-white">Aún no hay instructores agregados</h3>
                @endif
            </div>
        </div>
    </div>
    @include('partials.info_footer')
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/instructors-styles.css') }}">
@endsection