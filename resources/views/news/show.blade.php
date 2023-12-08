@extends('layout.app')

@section('content')
    <h4>{{ $news->title }}</h4>
    <p>{{ $news->content }}</p>
    <h4>Комментарии:</h4>
    @foreach($comments as $comment)
        <p>{{ $comment->content }}</p>
    @endforeach

    <form method="post" action="{{ route('comment.store', $news) }}">
        @csrf
        <label for="content" style="display: block; margin-bottom: 8px;">Комментарий:</label>
        <textarea name="text" required style="width: 300px; margin-bottom: 12px;"></textarea>
        <br>
        <button type="submit" class="btn btn-success mb-3">Добавить</button>
    </form>
@endsection









