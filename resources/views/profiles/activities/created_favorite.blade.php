@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} favorited a <a href="{{ $activity->subject->favorited->path() }}">reply</a>
    @endslot

    @slot('time')
        {{ $activity->subject->favorited->created_at->diffForHumans() }}
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent