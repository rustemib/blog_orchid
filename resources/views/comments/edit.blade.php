@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Редактирование комментария</h2>

        <form action="{{ route('post.comment.update', $comment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="body">Комментарий</label>
                <textarea name="body" id="body" class="form-control" rows="3" required>{{ $comment->body }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
