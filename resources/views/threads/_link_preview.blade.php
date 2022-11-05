@if ($preview)
<div class="mt-2 bg-light">
    <a href="{{ $preview['link'] }}" target="_blank">
        <img src="{{ $preview['cover'] }}" class="img-fluid w-100 rounded img-thumbnail" alt="{{ $preview['title'] }}">
    </a>
    <a href="{{ $preview['link'] }}" class="link-dark" id="threadLink" target="_blank">
        <div class="mt-2 mb-2 ml-3">
            <b>{{ \Illuminate\Support\Str::limit($preview['title'], 50, '...') }}</b>
        </div>
    </a>
    <a href="{{ $preview['link'] }}" class="link-secondary" id="threadLink" target="_blank">
        <span class="ml-3"><small>{{ \Illuminate\Support\Str::limit($preview['description'], 120, '...') }}</small></span>
    </a>
</div>
@endif