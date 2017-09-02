@extends('./layout/mobile')

@section('content')
    <purchase :materials="{{ $materials }}"></purchase>
@endsection
