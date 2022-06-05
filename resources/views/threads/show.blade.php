@extends('layouts.app')

@section('header')
<link href="/css/vendor/jquery.atwho.css" rel="stylesheet">
@endsection

@section('content')
<thread-view :initial-replies-count={{ $thread->replies_count }} inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}'s avatar" width="25" height="25" class="mr-1">

                        <a href="{{ route('profile.show', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}

                        <span class="float-end">
                            <form method="post" action="{{ route('threads.destroy', ['channelId' => $channelId, 'thread' => $thread->id]) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this thread?');">Delete thread</button>
                            </form>
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="body">{{ $thread->body }}</div>
                    </div>
                </div>
                <br>
                <b>Replies</b>
                {{-- <a href="{{ route('replies.index', [$channelId, $thread->id]) }}">Fetch replies</a> --}}
                <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                {{-- @foreach ($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }} --}}
                <br>

                {{-- moved into new reply --}}
                {{-- @if (auth()->check())
                    @include('partials.sessions')
                    <form action="{{ route('replies.store', ['channelId' => $channelId, 'threadId' => $thread->id]) }}"
                        method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="" cols="15" rows="5" class="form-control" placeholder="Add new reply"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mt-1">Save</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this
                        discussion</p>
                @endif --}}
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('profile.show', Auth::user()->name) }}">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        <div class="body">
                            This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="{{ route('profile.show', Auth::user()->name) }}">{{ $thread->creator->name }}</a> and currently has <span v-text="repliesCount"></span> {{ Illuminate\Support\Str::plural('comment', $thread->replies_count) }}.
                        </div>

                        <div class="body mt-3">
                            <subscribe-button :active="{{ $thread->isSubscribedTo ? 'true' : 'false' }}"></subscribe-button>
                            {{-- <button class="btn btn-primary">Subscribe</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
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
