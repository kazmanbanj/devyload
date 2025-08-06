@forelse ($threads as $thread)
<div class="card mt-4">
    <div class="card-header">
        <div class="flex">
            <a href="{{ route('threads.show', [$thread['channel']['slug'], $thread['slug']]) }}">
                {{-- @if (auth()->check() && $thread->hasUpdates(auth()->user())) --}}
                @if (auth()->check())
                    <strong>
                        {{ $thread['subject'] }}
                    </strong>
                @else
                    {{ $thread['subject'] }}
                @endif
            </a>

            <p>
                Posted by:
                <a href="{{ route('profile.show', $thread['creator']['id']) }}">
                    {{ $thread['creator']['name'] }}
                </a>
            </p>
        </div>

        <a href="{{ route('threads.show', [$thread['channel']['slug'], $thread['slug']]) }}">
            <strong class="float-end">
                {{ $thread['replies_count'] }}
                {{ Illuminate\Support\Str::plural('reply', $thread['replies_count']) }}
            </strong>
        </a>
    </div>

    <div class="card-body p-0">
        <article>
            <div class="body p-3 font-weight-light">{!! \Illuminate\Support\Str::limit($thread['body'], 300, '...') !!}</div>

            @if (isset($thread['link']))
                <div class="mt-2 bg-light">
                    <a href="{{ $thread['link'] }}" target="_blank">
                        <img src="{{ $thread['cover'] }}" class="img-fluid w-100 rounded img-thumbnail" alt="{{ $thread['title'] }}">
                    </a>
                    <a href="{{ $thread['link'] }}" class="link-dark" id="threadLink" target="_blank">
                        <div class="mt-2 mb-2 ml-3">
                            <b>{{ \Illuminate\Support\Str::limit($thread['title'], 50, '...') }}</b>
                        </div>
                    </a>
                    <a href="{{ $thread['link'] }}" class="link-secondary" id="threadLink" target="_blank">
                        <span class="ml-3" style="display: block; word-wrap:break-word; width: auto; white-space: normal;"><small>{{ \Illuminate\Support\Str::limit($thread['description'], 100, '...') }}</small></span>
                    </a>
                </div>
            @endif
        </article>
    </div>

    <div class="card-footer">
        <small class="text-muted">{{ $thread['visits'] }} {{ Illuminate\Support\Str::plural('Visit', $thread['visits'] ) }}</small>
    </div>
</div>
@empty
    <p>No threads yet</p>
@endforelse
