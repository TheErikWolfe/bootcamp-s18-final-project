@extends('layouts.app')

@section('content')
    <display-single-doodle :doodles-data='{{ $doodle->toJSON() }}'></display-single-doodle>
@endsection
