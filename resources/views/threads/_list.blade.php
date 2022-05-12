@forelse ($threads as $thread)
<div class="card mt-4">
    <div class="card-header">
        <div class="flex">
            <a href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">
                @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                    <strong>
                        {{ $thread->title }}
                    </strong>
                @else
                    {{ $thread->title }}
                @endif
            </a>

            <p class="">
                Posted by:
                <a href="{{ route('profile.show', $thread->creator) }}">
                    {{ $thread->creator->name }}
                </a>
            </p>
        </div>

        <a href="{{ route('threads.show', [$thread->channel->id, $thread->id]) }}">
            <strong class="float-end">
                {{ $thread->replies_count }}
                {{ Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
            </strong>
        </a>

        
    </div>

    <div class="card-body">
        <article>
            <div class="body font-weight-light">{{ $thread->body }}</div>
        </article>
        {{-- <hr> --}}
    </div>
</div>
@empty
<p>No threads yet</p>
@endforelse