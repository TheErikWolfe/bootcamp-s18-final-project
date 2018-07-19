@extends ('layouts.app')

@section ('content')
    <display-doodles :doodles-data='{{ $userDoodles->toJSON() }}'></display-doodles>
@endsection