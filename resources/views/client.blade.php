@extends('layout')
@section('title')
    Clients
@endsection
@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <form action="{{ url('/oauth/clients') }}" method="post">
        <p>
            <input type="text" name="name" />
        </p>
        <p>
            <input type="text" name="redirect" />
        </p>
        <p>
            <input type="submit" value="Enviar" name="send" />
        </p>
        {{ csrf_field() }}
    </form>
@endsection