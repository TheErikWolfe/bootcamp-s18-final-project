@extends('layouts.app')

@section('content')

<div class="">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content bg-transparent border-0">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="p-0">
                            <img id="" class="d-block w-75 m-auto" src="{{ asset('img/4.jpg') }}" alt="First slide"/>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
</div>
        </div>
    </div>

    @for ($i = 0; $i < 10; $i++)
    <div class="row imgrow">
        @for ($j = 0; $j < 6; $j++)
        <div class="imgframe">
            <div class="p-0">
            <img type="button" data-toggle="modal" data-target="#exampleModal" class="imgprops" src="{{ asset('img/4.jpg') }}"/>
                <div class="arrowcontainer">
                    <div class="arrow bg-transparent fa fa-arrow-up upvotearrow"></div>
                    <div class="arrow bg-transparent fa fa-arrow-down downvotearrow"></div>
                </div>
            </div>
        </div>
        @endfor
    </div>
    @endfor
</div

@endsection
