<div class="card-header">
    {{ $profileUser->name }} replied to <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
    
    <span class="float-end">
        {{ $activity->subject->created_at->diffForHumans() }}
    </span>
</div>

<div class="card-body">
    <div class="body">
        {{ $activity->subject->body }}
    </div>
</div>