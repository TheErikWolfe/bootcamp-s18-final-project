@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="text-align-left">5 images</h3>
    @for ($j = 0; $j < 5; $j++)
    <div class="p-0">
        <img type="button" data-toggle="modal" data-target="#img-modal" src="{{ asset('img/4.jpg') }}"/>
    </div>
    @endfor
    
</div>

@endsection