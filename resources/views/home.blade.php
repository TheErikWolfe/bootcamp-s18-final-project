@extends('layouts.app')

@section('content')
    <display-doodles :doodles-data='{{ $doodles->toJSON() }}'></display-doodles>
@endsection
