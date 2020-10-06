@extends('layouts.main')

@section('title')
    {{ $instructor->name }}
@endsection

@section('content')
    {{-- Content --}}
    <div class="container">
        <!-- Section for the General Info of the Instructor -->
        <div class="row">
            <!-- Image -->
            <div id="instructorImage" class="col-md-5">
                @if ($instructor->full_body_image)
                    <img src="{{ $instructor->full_body_image }}" class="card-img-top" alt="{{ $instructor->name }}" onerror="this.src='/img/instructors/Instructor-Body.png'; this.className='img-fluid instructorBodyImage'">
                @else
                    <img src="/img/instructors/Instructor-Body.png" class="img-fluid instructorBodyImage" alt="Instructor image">
                @endif
            </div>
            <!-- Name, Description and Phrase -->
            <div class="info col-md-7">
                <h1 id="instructorName" class="mt-0">{{ $instructor->name }}</h1>
                <div id="instructorDescription" class="text-justify mt-3">
                    {{ $instructor->bio }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraStyles')
    <link rel="stylesheet" href="{{ asset('css/instructor-info.css') }}">
    <style>
        img:before {
            content: ' ';
            display: block;
            position: absolute;
            height: 50px;
            width: 50px;
            background-image: url('/img/instructors/Instructor-Body.png');
        }

        .container {
            margin-top: 1em;
        }
    </style>
@endsection