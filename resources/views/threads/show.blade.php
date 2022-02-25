@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        <div class="body">{{ $thread->body }}</div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <b>Replies</b>
                    @foreach ($thread->replies as $reply)
                        @include('threads.reply')
                    @endforeach
                </div>
            </div>
        </div>
        <br>
        @if (auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="{{ route('replies.store', $thread->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea id="summernote" class="form-control" placeholder="Add new reply" name="body" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mt-1">Save</button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion</p>
        @endif
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