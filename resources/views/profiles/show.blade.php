@extends('layouts.app')

@section('content')
<div class="container">
    <h5>{{ $profileUser->name }}
        <small>joined since {{ $profileUser->created_at->diffForHumans() }}</small>
    </h5>

    <div class="card">
        @foreach ($activities as $date => $activity)
            <h3 class="card-header">{{ $date }}</h3>

            @foreach ($activity as $record)
                @if (view()->exists("profiles.activities.{$record->type}"))
                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                @endif
            @endforeach
        @endforeach
    </div>
    <br>
    {{-- {{ $activities->links() }} --}}
</div>
@endsection