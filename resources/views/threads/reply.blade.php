{{-- <reply :attributes="{{ $reply }}" inline-template> --}}
    <div class="card mb-2">
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
        {{-- <div v-if="editing">
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </div> --}}

        <div class="body" v-else>
            {{ $reply->body }}
        </div>
    </div>

    @can('update', $reply)
        <div class="d-flex ml-2 mb-2">
            <button class="btn btn-warning btn-sm" type="submit" @click="editing = true">Edit</button>

            <form method="POST" action="{{ route('reply.delete', $reply->id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm ml-2" type="submit" onclick="return confirm('Are you sure you want to delete this reply?');">
                    Delete
                </button>
            </form>
        </div>
    @endcan
</div>
{{-- </reply> --}}
