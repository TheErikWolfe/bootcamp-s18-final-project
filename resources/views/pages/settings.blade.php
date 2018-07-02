@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="card col-md-4 col-sm-12 m-2 float-left">
            <ul class="nav m-auto text-center flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('profile') }}">{{ __('Profile') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('account') }}">{{ __('Account') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('preferences') }}">{{ __('Preferences') }}</a>
                </li>
            </ul>
        </div>
        <div class="card m-2 col-md-7 col-sm-12">
            <div class="card-body">
                @yield('settings-content')
            </div>
        </div>
    </div>
</div>

@endsection