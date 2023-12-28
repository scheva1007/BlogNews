@extends('layout.app')

@section('content')
    @if($news->photo)
        <img src="{{ asset('/storage/' . $news->photo) }}" alt="News Photo" style="max-width: 300px; max-height: 300px;">
    @endif
    <h5>{{ $news->title }}</h5>
    <p>{{ $news->content }}</p>
    <div class="mb-3">

        @php
            $user=auth()->user();
         @endphp
        @if ($user && ($user->isAdmin() || $user->id === $news->user_id))
        <a href="{{ route('news.edit', $news) }}"  >Редактировать</a>
        <form method="post" action="{{ route('news.destroy', $news) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <a href="{{ route('news.edit', $news) }}" onclick="return confirm('Вы уверены?')">Удалить</a>
        </form>
        @endif
    </div>
    @if (count($comments)>0)
    <h6>Все комментарии:</h6>

    @foreach($comments as $comment)
        <div style="margin-bottom: 10px; ">
            <span  class="news-link my-font-size my-margin-right background-data">Добавил(-a): {{ $comment->user_name }} </span>
            <span class="news-link my-font-size background-data">{{ $comment->formattedDate }}</span>
        <div> *{{ $comment->content }} </div>
        </div>
    @endforeach
    @endif
    @if ($user && ($user->isAdmin() || $user->isAuthor() || $user->isRegistered()))

    <form method="post" action="{{ route('comment.store', $news) }}">
        @csrf
        <label for="content" style="display: block; margin-bottom: 8px; font-weight: bold;">Оставить комментарий:</label>
        <textarea name="text" required style="width: 300px; margin-bottom: 12px;"></textarea>
        <br>
        <button type="submit" class="btn btn-success mb-3">Добавить</button>
    </form>

    @else
         <p class="my-font-weight my-margin-top">Зарегистрируйтесь, чтобы добавить комментарий</p>
    @endif
@endsection









