@extends('layout.app')

@section('content')

    @if($news->photo)
        <img src="{{ asset('/storage/' . $news->photo) }}" alt="News Photo"
             style="max-width: 300px; max-height: 300px;">
    @endif
    <div style="margin-top: 20px">Рейтинг: {{ $rating }}</div>
    <h5>{{ $news->title }}</h5>
    <p>{{ $news->content }}</p>
    <div class="mb-3">

        @php
            $user=auth()->user();
        @endphp
        @if ($user && ($user->isAdmin() || $user->id === $news->user_id))
            <div style="margin-bottom: 10px;">
                <a href="{{ route('news.edit', $news) }}">Редактировать</a>
                <form method="post" action="{{ route('news.destroy', $news) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('news.edit', $news) }}" onclick="return confirm('Вы уверены?')">Удалить</a>
                </form>
                @endif
            </div>
            @if ($userRating !==null )
                <p style="margin-bottom: 1px">Ваша текущая оценка: {{ $userRating }}</p>
            @endif
            @if($user && $user->id !== $news->user_id)
                <div>
                    <label class="my-grade my-font-weight" for="grade">Оцените статью от 1 до 5</label>
                </div>
                <div style="margin-top: 0;">
                    <form method="post" action="{{ route('news.rating', ['news' => $news->id]) }}">
                        @csrf

                        <input type="number" name="grade" min="1" max="5" style="margin-top: 1px;" required>
                        <br>
                        <button type="submit" class="btn btn-primary mb-3 mt-1">Поехали</button>
                    </form>
                </div>
    </div>
    @endif
    @if ($user && ($user->isAdmin() || $user->isAuthor() || $user->isRegistered()))

        <form id="comment-form" method="post" data-url="{{ route('comment.store', $news) }}">
            @csrf
            <label for="content" style="display: block; margin-bottom: 8px; font-weight: bold;">Оставить
                комментарий:</label>
            <textarea name="text" required style="width: 300px; margin-bottom: 12px;"></textarea>
            <br>
            <button type="submit" class="btn btn-success mb-3">Добавить</button>
        </form>
    @else
        <p class=" my-font-weight my-margin-top">Зарегистрируйтесь, чтобы добавить комментарий</p>
    @endif

    @if (count($comments)>0)
        <h6>Все комментарии:</h6>
        <div id="comments-container">
            @foreach($comments as $comment)
        @include('news.partials.comment')
            @endforeach
        </div>
    @endif
    <div class="rating-buttons">
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const commentForm = document.getElementById('comment-form');
            const commentsContainer = document.getElementById('comments-container');
            if (commentForm) {
                commentForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const formData = new FormData(commentForm);
                    const url = commentForm.getAttribute('data-url');
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                    })
                        .then(response => response.text())
                        .then(data => {
                            commentForm.querySelector('textarea[name="text"]').value = '';
                            commentsContainer.insertAdjacentHTML('afterbegin', data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            }
        });
    </script>
@endsection
