@extends('settings.card')

@section('settings-content')
    <div class="text-center">
        <h4><strong>Current Signature</strong></h4>
    </div>
    <div class="mx-auto rounded-0 mb-4 card settings-signature-card">
        <img width="400" height="100" src="{{ $signature->source }}" >
    </div>
    <div class="text-center">
        <h4><strong>By Clicking 'Save' You Will Be Replacing Your Signature With A New One</strong></h4>
    </div>
    <signature-app :signature-data='{{ $signature->toJSON() }}'></signature-app>
@endsection
