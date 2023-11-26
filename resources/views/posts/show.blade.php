@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>

        @if($post->image)
            <div class="my-3">
                <img src="{{ asset($post->image) }}" alt="Image for {{ $post->title }}"
                     style="max-width: 400px;">
            </div>
        @endif

        <h3 class="my-3">
            {{ $post->description }}
        </h3>
        <div class="my-3">
            {!! $post->body !!}
        </div>

        <div class="d-flex justify-content-end">
            <p>Автор поста: <b>{{ $post->user->name }}</b></p>
        </div>
        @foreach($post->comments as $comment)
            <div class="container mt-3">
                Комментарий от: <strong>{{ $comment->user->name }}</strong>
                <p>"{{ $comment->body }}"</p>
            </div>

            @can('update', $comment)
                <a class="btn btn-success" href="{{ route('post.comment.edit', $comment) }}">Редактировать</a>
            @endcan

            @can('delete', $comment)
                <form action="{{ route('post.comment.delete', $comment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            @endcan
        @endforeach


        @auth
            <form method="POST" action="{{ route('post.comments.store', $post) }}">
                @csrf
                <div class="form-group">
                    <textarea name="body" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Добавить комментарий</button>
            </form>
        @else
            <p><a href="{{ route('login') }}">Войдите</a> для комментирования.</p>
        @endauth

        <a href="{{ route('posts.index') }}">Вернуться к списку постов</a>
    </div>
@endsection
