@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <nav class="col-md-3 col-sm-12 p-2 h-75 mr-5 m-2 settings-menu-navbar d-none d-md-block sidebar navbar-laravel">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
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
        </nav>
        <div class="settings-card card h-75 p-2 m-2 col-md-7 col-sm-12">
            <div class="card-body">
                @yield('settings-content')
            </div>
        </div>
    </div>
</div>

@endsection