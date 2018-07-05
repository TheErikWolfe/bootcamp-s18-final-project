@extends('pages.settings')

@section('settings-content')

<div class="container">
    <form>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="checkbox-notification-emails">
            <label class="form-check-label" for="notification-check">Don't send me notification emails</label>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="promotional-notification-emails">
            <label class="form-check-label" for="promotional-check">Don't send me promotional emails</label>
        </div>
        <button type="submit" class="btn btn-primary">Save Preferences</button>
    </form>
</div>

@endsection