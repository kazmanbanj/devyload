@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('profile.show') }}">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        <div class="body">{{ $thread->body }}</div>
                    </div>
                </div>
                <br>
                <div class="card mb-2">
                    <b>Replies</b>

                    @foreach ($replies as $reply)
                        @include('threads.reply')
                    @endforeach
                </div>
                {{ $replies->links() }}
                <br>

                @if (auth()->check())
                    @include('common.sessions')
                    <form action="{{ route('replies.store', ['channelId' => $channelId, 'threadId' => $thread->id]) }}"
                        method="POST">
                        @csrf
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Add new reply" name="body">
                            {{-- <textarea name="body" id="summernote" class="form-control" placeholder="Add new reply" rows="3"></textarea> --}}
                        </div>

                        <button type="submit" class="btn btn-primary mt-1">Save</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this
                        discussion</p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        <div class="body">
                            This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="#">{{ $thread->creator->name }}</a> and currently has {{ $thread->replies_count }} {{ Illuminate\Support\Str::plural('comment', $thread->replies_count) }}.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#summernote').summernote({
            height: 400
        });
    </script>
@endsection
