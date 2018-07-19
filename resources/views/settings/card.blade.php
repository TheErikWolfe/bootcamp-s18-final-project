@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <nav class="settings-menu-navbar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="">{{ __('Profile') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">{{ __('Account') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">{{ __('Preferences') }}</a>
                </li>
            </ul>
        </nav>
        <div class="settings-card">
            <div class="card-body">
                @yield('settings-content')
            </div>
        </div>
    </div>
</div>

@endsection