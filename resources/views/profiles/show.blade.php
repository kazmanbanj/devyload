@extends('layouts.app')

@section('content')
<div class="container">
    <h5>
        <img src="{{ $profileUser->avatar() }}" alt="{{ $profileUser->name }}'s avatar" width="50" height="50" class="mb-2">

        {{ $profileUser->name }}

        <small>joined since {{ $profileUser->created_at->diffForHumans() }}</small>

        @can('update', $profileUser)
            <form action="{{ route('avatar', $profileUser) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="avatar" id="avatar">

                <button type="submit" class="btn btn-primary btn-sm">Add avatar</button>
            </form>
        @endcan

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
    {{-- {{ $activities->links() }} --}}
</div>
@endsection