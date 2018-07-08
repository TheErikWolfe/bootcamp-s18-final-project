@extends('pages.settings')

@section('settings-content')

<div class="container">
<form>
    <div class="form-group">
        <label for="input-email">Email address</label>
        <input type="email" class="form-control" id="input-email" aria-describedby="email-help" placeholder="{{ Auth::user()->email }}">
        <small id="email-help" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="input-password-1">New Password</label>
        <input type="password" class="form-control" id="input-password-1" placeholder="">
    </div>
    <div class="form-group">
        <label for="verify-input-password-1">Verify New Password</label>
        <input type="password" class="form-control" id="verify-inputpassword-1" placeholder="">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection