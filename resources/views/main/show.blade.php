@extends('layouts.app')

@section('content')
    <display-single-doodle :doodle-data='{{ $doodle->toJSON() }}'></display-single-doodle>
@endsection
