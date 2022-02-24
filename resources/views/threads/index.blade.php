@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Devyload Threads</div>

                <div class="card-body">
                    @foreach ($threads as $thread)
                        <article>
                            <a href="{{ route('threads.show', [$thread->id]) }}">{{ $thread->title }}</a>
                            <div class="body">{{ $thread->body }}</div>
                        </article>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-2">
        {!! $threads->links() !!}
    </div>
</div>
@endsection
