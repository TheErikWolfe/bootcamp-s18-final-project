@extends('layouts.app')

@section('content')

@for ($i = 0; $i < 10; $i++)
<div class="row img-row">
    @for ($j = 0; $j < 6; $j++)
    <div class="img-frame">
        <div class="p-0">
            <div class="report-container">
                <a class="report-btn" href="#">report</a>
            </div>
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

@endsection
