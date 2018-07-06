@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="text-align-left">5 images</h3>
    @for ($j = 0; $j < 5; $j++)
    <div class="p-0">
    <img type="button" data-toggle="modal" data-target="#exampleModal" class="" src="{{ asset('img/4.jpg') }}"/>
        <div class="arrowcontainer">
            <div class="arrow bg-transparent fa fa-arrow-up upvotearrow"></div>
            <div class="arrow bg-transparent fa fa-arrow-down downvotearrow"></div>
        </div>
    </div>
    @endfor
    
</div>

@endsection