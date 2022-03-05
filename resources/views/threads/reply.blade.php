<div id="reply-{{ $reply->id }}" class="card-header d-block">
    <p class="">
        <b>
            <a href="{{ route('profile.show', Auth::user()->name) }}">
                {{ $reply->creator->name }}
            </a>
        </b> said {{ $reply->created_at->diffForHumans() }}
    </p>

    <form method="POST" action="{{ route('favorites', $reply->id) }}" class="float-end">
        @csrf
        <button class="btn btn-info" type="submit" {{ $reply->isFavorited() ? 'disabled' : '' }}>
            {{ $reply->favorites_count }} {{ Illuminate\Support\Str::plural('favorite', $reply->favorites_count) }}
        </button>
    </form>
</div>

<div class="card-body">
    <div class="body">{{ $reply->body }}</div>
</div>