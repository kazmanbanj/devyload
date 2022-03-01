@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>{{ $profileUser->name }}
                <small>joined since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h5>
        </div>

        <div class="card-body">
            body here...
        </div>
    </div>
</div>
@endsection