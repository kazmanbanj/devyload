@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('common.sessions')
            <div class="card">
                <div class="card-header">Devyload Threads</div>

                <div class="card-body">
                    @forelse ($threads as $thread)
                        <article>
                            <a href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">{{ $thread->title }}</a>

                            <a href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">
                                <strong class="float-end">
                                    {{ $thread->replies_count }}
                                    {{ Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
                                </strong>
                            </a>

                            <div class="body font-weight-light">{{ $thread->body }}</div>
                        </article>
                        <hr>
                    @empty
                        <p>No threads yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-2">
        {!! $threads->links() !!}
    </div>
</div>
@endsection
