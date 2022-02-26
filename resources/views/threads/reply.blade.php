<div class="card-header">
    {{ $reply->creator->name }} said {{ $reply->created_at->diffForHumans() }}
</div>

<div class="card-body">
    <div class="body">{{ $reply->body }}</div>
</div>