@extends('layouts.app')

@section('content')
<div class="container">
            <h5>{{ $profileUser->name }}
                <small>joined since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h5>

        <div class="card">
            @foreach ($profileUser->threads as $thread)
            <div class="card-header">
                <a href="{{ route('profile.show', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                {{ $thread->title }}

                <span class="float-end">
                    {{ $thread->created_at->diffForHumans() }}
                </span>
            </div>

            <div class="card-body">
                <div class="body">{{ $thread->body }}</div>
            </div>
            @endforeach
        </div>

        {{-- {{ $threads->links() }} --}}
</div>
@endsection