@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} published <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>
    @endslot

    @slot('time')
        {{ $activity->subject->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent



{{-- to override the slot above --}}
{{-- @include('profiles.activities.activity', [
    'heading' => 'The heading',
    'time' => 'The time',
    'body' => 'The body'
]) --}}
