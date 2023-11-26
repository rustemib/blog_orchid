@extends('layouts.app')

@section('content')
    @if(session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        <h1>Список Постов</h1>
        <ul>
            @foreach ($posts as $post)
                <li class="my-3">
                    <h2>{{ $post->title }}</h2>
                    @if($post->image)
                        <div class="my-3">
                            <img src="{{ asset($post->image) }}" alt="Image for {{ $post->title }}"
                                 style="max-width: 100px;">
                        </div>
                    @endif
                    <h4 class="my-3">{{ $post->description }}</h4>

                    <p>{{ \Illuminate\Support\Str::words($post->body, 35, '...') }}</p>

                    <a href="{{ route('post.show', $post->id) }}">Читать далее</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="d-flex justify-content-center">
        {{ $posts->links()}}
    </div>
@endsection
