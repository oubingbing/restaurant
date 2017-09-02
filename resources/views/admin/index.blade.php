@extends('./layout/home')

@section('content')
    <admin-index :restaurants="{{ $restaurants }}"></admin-index>
@endsection