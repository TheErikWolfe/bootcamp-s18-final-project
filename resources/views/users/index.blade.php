@extends ('layouts.app')

@section ('content')
    <display-user-doodles :doodles-data='{{ $doodles->toJSON() }}'></display-user-doodles>
@endsection