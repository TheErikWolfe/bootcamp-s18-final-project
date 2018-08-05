@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card signature-card bg-secondary mt-5 text-light text-center">
            <div class="card-header">
                <h3>Almost there! Just sign you name!</h3> 
            </div>
            <div class="card-body d-flex justify-content-center">
                <signature-app></signature-app> 
            </div>
        </div>
    </div>
@endsection