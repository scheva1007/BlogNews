@extends('layout.app')

@section('content')
    <div style="display: flex;">
        <div style="width: 60%;">
    @if($news->photo)
        <img src="{{ asset('/storage/' . $news->photo) }}" alt="News Photo"
             style="max-width: 300px; max-height: 300px;">
    @endif
    <div style="margin-top: 20px">Рейтинг: {{ $news->rating }}</div>
    <h5>{{ $news->title }}</h5>
    <p class="news-container">{{ $news->content }}</p>

    <div class="mb-3">

        @php
            $user=auth()->user();
        @endphp
        @if ($user && ($user->isAdmin() || $user->id === $news->user_id))
            <div style="margin-bottom: 10px;">
                <a href="{{ route('news.edit', $news) }}">Редагувати</a>
                <form method="post" action="{{ route('news.destroy', $news) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('news.edit', $news) }}" onclick="return confirm('Вы уверены?')">Видалити</a>
                </form>
            </div>
                @endif

            @if ($news->userRating() !==null )
                <p style="margin-bottom: 1px">Ваша поточна оцінка: {{ $news->userRating() }}</p>
            @endif
            @if($user && $user->id !== $news->user_id)
                <div>
                    <label class="my-grade my-font-weight" for="grade">Оцініть статтю від 1 до 5</label>
                </div>
                <div style="margin-top: 0;">
                    <form method="post" action="{{ route('news.rating', ['news' => $news->id]) }}">
                        @csrf

                        <input type="number" name="grade" min="1" max="5" style="margin-top: 1px;" required>
                        <br>
                        <button type="submit" class="btn btn-primary mb-3 mt-1">Поїхали</button>
                    </form>
                </div>
        @endif
    </div>
    @if ($user && ($user->isAdmin() || $user->isAuthor() || $user->isRegistered()))
            @if ($user->isBlocked())
                <p class="text-danger my-font-weight">Ви заблоковані та не можете залишати коментарі.</p>
            @else
        <form id="comment-form" method="post" data-url="{{ route('comment.store', $news) }}">
            @csrf
            <label for="content" style="display: block; margin-bottom: 8px; font-weight: bold;">Залишити коментар:</label>
            <textarea name="text" required style="width: 300px; margin-bottom: 12px;"></textarea>
            @if ($errors->has('text'))
                <div class="text-danger">{{ $errors->first('text') }}</div>
            @endif
            <br>
            <button type="submit" class="btn btn-success mb-3">Додати</button>
        </form>
            @endif
    @else
        <p class=" my-font-weight my-margin-top">Зареєструйтесь, щоб додати коментарій</p>
    @endif

    @if (count($news->comment) > 0 )
        <h6>Всі коментарі:</h6>
        <div id="comments-container">
            @foreach($news->comment as $comment)
                @if($comment->status != 'blocked')
                @include('news.partials.comment')
                @endif
            @endforeach
        </div>

    @endif
    <div class="rating-buttons">
    </div>
    @if ($news->tags && count($news->tags)>0)
        <ul class="tags-list">
            @foreach($news->tags as $tag)
                <li class="tags-item">
                    <a href="{{ route('news.tag', ['tag' => $tag->name]) }}" class="tag-link"> {{ $tag->name }}</a>
                </li>
            @endforeach
        </ul>
        @endif
        </div>
        <div style="width: 40%; margin-left: 7%;">
            <h5>Схожі новини:</h5>
            @if(count($similarNews) > 0)
                @foreach($similarNews as $item)
                    @include('news.partials.newsList')
                @endforeach
            @else
                <p>Немає схожих новин</p>
            @endif
        </div>
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
