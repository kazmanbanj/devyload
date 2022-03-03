<div class="card-header">
    {{ $profileUser->name }} published <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>

    <span class="float-end">
        {{ $activity->subject->created_at->diffForHumans() }}
    </span>
</div>

<div class="card-body">
    <div class="body">
        {{ $activity->subject->body }}
    </div>
</div>