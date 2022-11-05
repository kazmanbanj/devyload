@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create a new thread</h1>
    @include('partials.sessions')
    <form action="{{ route('threads.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Subject</label>
            <input spellcheck="true" type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="Add a title" value="{{ old('subject') }}" required>
        </div>
        {{-- <p contenteditable="true" spellcheck="true">splel chkec</p> --}}
        <div class="form-group">
            <label for="exampleFormControlSelect1">Channel</label>
            <select class="form-control" id="exampleFormControlSelect1" name="channel_id" required>
                <option value="">Choose one...</option>
                @foreach ($channels as $channel)
                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Body</label>
            <wysiwyg name="body"></wysiwyg>
            {{-- <textarea class="form-control" name="body" id="exampleFormControlTextarea1" rows="3" required>{{ old('body') }}</textarea> --}}
        </div>

        <div class="form-inline">
            <button type="submit" class="form-control btn btn-primary">Create</button>
        </div>
    </form>
</div>
@endsection