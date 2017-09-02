@extends('./layout/home')

@section('content')
    <employee-index :employees="{{ $employees }}"></employee-index>
@endsection