@extends('layouts.app')

@section('content')
    <display-single-doodles :doodles-data='{{ $doodles->toJSON() }}'></display-single-doodles>
@endsection
