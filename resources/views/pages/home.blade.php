@extends('layouts.app')

@section('content')

<div class="">
    <div class="modal fade" id="img-modal" tabindex="-1" role="dialog" aria-labelledby="img-modal-label" aria-hidden="true">
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
                <a class="carousel-control-prev" href="#carousel-img-controls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-img-controls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
</div>
        </div>
    </div>

    @for ($i = 0; $i < 10; $i++)
    <div class="row img-row">
        @for ($j = 0; $j < 6; $j++)
        <div class="img-frame">
            <div class="p-0">
                <img type="button" data-toggle="modal" data-target="#img-modal" class="img-props" src="{{ asset('img/4.jpg') }}"/>
                <div class="arrow-container">
                    <div class="arrow bg-transparent fa fa-arrow-up upvote-arrow"></div>
                    <div class="arrow bg-transparent fa fa-arrow-down downvote-arrow"></div>
                </div>
            </div>
        </div>
        @endfor
    </div>
    @endfor
</div

@endsection
