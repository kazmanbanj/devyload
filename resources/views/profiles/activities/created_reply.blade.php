@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} replied to <a href="{{ $activity->subject->thread->path() ?? '-' }}">{{ $activity->subject->thread->title ?? '-' }}</a>
    @endslot

    @slot('time')
        {{ $activity->subject->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent