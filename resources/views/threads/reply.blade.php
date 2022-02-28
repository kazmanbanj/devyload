<div class="card-header">
    <b>{{ $reply->creator->name }} said {{ $reply->created_at->diffForHumans() }}</b>
</div>

<div class="card-body">
    <div class="body">{{ $reply->body }}</div>
</div>