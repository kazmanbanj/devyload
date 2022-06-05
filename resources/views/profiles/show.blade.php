@extends('layouts.app')

@section('content')
<div class="container">
    <h5>
        <avatar-form :user="{{ $profileUser }}"></avatar-form>

    </h5>

    <div class="card">
        @forelse ($activities as $date => $activity)
            <h3 class="card-header">{{ $date }}</h3>

            @foreach ($activity as $record)
                @if (view()->exists("profiles.activities.{$record->type}"))
                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                @endif
            @endforeach
        @empty
            <p class="card-body">There is no activity for this user yet.</p>
        @endforelse
    </div>
    <br>
</div>
@endsection
