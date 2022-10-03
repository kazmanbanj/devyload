@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partials.sessions')
                @include('threads._list')
            </div>

            <div class="col-md-4">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Search</h5>
                    </div>
                    <div class="card-body">
                        <form action="/threads/search" method="GET">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." name="q" value="" class="form-control">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- @if (count($trending)) --}}
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5>Trending threads</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @forelse ($trending as $thread)
                                    <li class="list-group-item list-group-item-action">
                                        <a href="{{ $thread->path }}">
                                            {{ $thread->title }}

                                            <span title="{{ Illuminate\Support\Str::plural('reply', $thread->replies) }}" class="badge badge-primary badge-pill mt-1 float-right">{{ $thread->replies }}</span>
                                        </a>
                                    </li>
                                @empty
                                    <p>No trending threads yet.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                {{-- @endif --}}
            </div>
        </div>

        <div class="d-flex justify-content-center mt-2">
            {!! $threads->render() !!}
        </div>
    </div>
@endsection
