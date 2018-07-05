@extends('pages.settings')

@section('settings-content')

<div class="container">
    <form>
        <div class="form-group">
            <label for="signature">Signature</label>
            <div class="card">
                <div class="card-body">
                    <img class="signature" src="{{ asset('img/signature.png') }}" />
                </div>
            </div>
            <small id="edit-button" class="text-right"><a class="text-right" href='#'>edit</a></small>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="email" style="background-color: #FFEFCB" class="form-control" id="username-input" aria-describedby="emailHelp" placeholder="">
        </div>
        <button type="submit" class="btn btn-primary">Save Profile Settings</button>
    </form>
</div>

@endsection