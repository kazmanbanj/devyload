@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partials.sessions')
                @include('threads._list')
            </div>
        </div>

        <div class="d-flex justify-content-center mt-2">
            {!! $threads->render() !!}
        </div>
    </div>
@endsection
