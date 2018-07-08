@extends('layouts.app')

@section('content')

<div class="modal fade mt-5" id="user-img-modal" tabindex="-1" role="dialog" aria-labelledby="user-img-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-transparent border-0">
            <div id="carousel-img-controls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="p-0">
                            <img id="" class="d-block w-75 m-auto" src="{{ asset('img/4.jpg') }}" alt="First slide"/>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-user-img-controls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-user-img-controls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h3 class="text-align-left mt-3">8 images</h3>
    <div class="user-img-wrapper mt-4">
    @for ($j = 0; $j < 8; $j++)
    <div class="user-img-thumbnail">
        <img type="button" class="user-img" data-toggle="modal" data-target="#user-img-modal" src="{{ asset('img/4.jpg') }}"/>
    </div>
    @endfor
    </div>
    
</div>

@endsection