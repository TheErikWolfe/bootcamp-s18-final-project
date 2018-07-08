@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="text-align-left mt-3">8 images</h3>
    <div class="user-img-wrapper mt-4">
        @for ($j = 0; $j < 8; $j++)
        <div class="user-img-thumbnail">
            <img type="button" class="user-img" data-toggle="modal" data-target="#img-modal" src="{{ asset('img/4.jpg') }}"/>
        </div>
        @endfor
    </div>  
</div>

@endsection