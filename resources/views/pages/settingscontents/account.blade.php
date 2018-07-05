@extends('pages.settings')

@section('settings-content')

<div class="container">
<form>
    <div class="form-group">
        <label for="InputEmail1">Email address</label>
        <input type="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp" placeholder="{{ Auth::user()->email }}">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="InputPassword1">New Password</label>
        <input type="password" class="form-control" id="InputPassword1" placeholder="">
    </div>
    <div class="form-group">
        <label for="VerifyInputPassword1">Verify New Password</label>
        <input type="password" class="form-control" id="VerifyInputPassword1" placeholder="">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection