@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <nav class="settings-menu-navbar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="/settings">{{ __('Signature') }}</a>
                </li>
            </ul>
        </nav>
        <div class="settings-card">
            <div class="card-body text-light">
                @yield('settings-content')
            </div>
        </div>
    </div>
</div>

@endsection