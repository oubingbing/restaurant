@extends('./layout/home')

@section('content')
    <activate-account email="{{ $user->email }}" token="{{ $user->activate_token }}"></activate-account>
@endsection