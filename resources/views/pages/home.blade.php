@extends('layouts.app')

@section('content')

<div class="">
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- The Close Button -->
        <span class="close">&times;</span>

        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
    </div>

    @for ($i = 0; $i < 10; $i++)
    <div class="row imgrow">
        @for ($j = 0; $j < 6; $j++)
        <div class="imgframe">
            <div class="p-0">
                <img id="myImg" class="imgprops" src="{{ asset('img/4.jpg') }}"/>
                <div class="arrowcontainer">
                    <div class="arrow fa fa-arrow-up upvotearrow"></div>
                    <div class="arrow fa fa-arrow-down downvotearrow"></div>
                </div>
            </div>
        </div>
        @endfor
    </div>
    @endfor
</div

@endsection
