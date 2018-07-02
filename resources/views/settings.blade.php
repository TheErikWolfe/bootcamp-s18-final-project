@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="card col-4 m-2 float-left">
            <ul class="nav flex-column">
                <li class="nav-item m-auto">
                    <a class="nav-link active" href="#">Profile</a>
                </li>
                <li class="nav-item m-auto">
                    <a class="nav-link active" href="#">Account</a>
                </li>
                <li class="nav-item m-auto">
                    <a class="nav-link active" href="#">Preferences</a>
                </li>
            </ul>
        </div>
        <div class="card m-2 col-7">
            <div class="card-body">
                @yield('settings-content')
            </div>
        </div>
    </div>
</div>

@endsection