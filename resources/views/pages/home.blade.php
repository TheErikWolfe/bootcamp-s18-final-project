@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="card mx-3 p-0 rounded-0 col">
            <div class="p-0 card-body">
                <img class="imgprops" src="{{ asset('img/1.jpg') }}" />
                <div class="arrow text-right m-3 fa fa-arrow-up text-success"></div>
                <div class="arrow text-right m-3 fa fa-arrow-up text-danger"></div>
            </div>
        </div>
        <div class="card mx-3 p-0 rounded-0 col">
            <div class="p-0 card-body">
                <img class="imgprops" src="{{ asset('img/2.jpg') }}" />
            </div>
        </div>
        <div class="card mx-3 p-0 rounded-0 col">
            <div class="p-0 card-body">
                <img class="imgprops" src="{{ asset('img/3.jpg') }}" />
            </div>
        </div>
    </div>

</div>

@endsection
