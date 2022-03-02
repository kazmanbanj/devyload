@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partials.sessions')
                @forelse ($threads as $thread)
                    <div class="card mt-4">
                        <div class="card-header">
                            <a href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">
                                {{ $thread->title }}
                            </a>

                            <a href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">
                                <strong class="float-end">
                                    {{ $thread->replies_count }}
                                    {{ Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
                                </strong>
                            </a>
                        </div>

                        <div class="card-body">
                            <article>
                                <div class="body font-weight-light">{{ $thread->body }}</div>
                            </article>
                            {{-- <hr> --}}
                        </div>
                    </div>
                @empty
                    <p>No threads yet</p>
                @endforelse
            </div>
        </div>

        <div class="d-flex justify-content-center mt-2">
            {!! $threads->links() !!}
        </div>
    </div>
@endsection
