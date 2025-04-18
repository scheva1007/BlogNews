@extends('layout.app')

@section('content')
    <div style="display: flex;">
        <div style="width: 60%;">
    @if($news->photo)
        <img src="{{ asset('/storage/' . $news->photo) }}" alt="News Photo"
             style="max-width: 300px; max-height: 300px;">
    @endif
    <div style="margin-top: 20px; margin-bottom: 20px;">Рейтинг: {{ $news->rating }}</div>
    <h5>{{ $news->title }}</h5>
    <p class="news-container">{{ $news->text }}</p>
        <div style="margin-top: 10px; margin-bottom: 5px;">
            Автор:<strong> {{ $news->author->name }}</strong>
            @if($subscribed)
                <form action="{{ route('subscribe.unsubscribe', $news->author) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="margin-top: 10px;">Відписатися</button>
                </form>
            @else
                <form action="{{ route('subscribe.subscribe', $news->author) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Підписатися</button>
                </form>
                @endif
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="mb-3">
        @php
            $user=auth()->user();
        @endphp
        @if ($user && ($user->isAdmin() || $user->id === $news->user_id))
            <div style="margin-bottom: 10px;">
                <a href="{{ route('news.edit', $news) }}" class="edit-link">Редагувати</a>
                <form method="post" action="{{ route('news.destroy', $news) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Ви впевнені?')" style="background: none; color: inherit; border: none; padding: 0; cursor: pointer;">Видалити</button>
                </form>
            </div>
                @endif

            @if ($news->userRating() !==null )
                <p style="margin-top: 15px; margin-bottom: 5px;">Ваша поточна оцінка: {{ $news->userRating() }}</p>
            @endif
            @if($user && $user->id !== $news->user_id)
                <div >
                    <label class="my-grade my-font-weight" for="grade" style="margin-top: 1px;">Оцініть статтю від 1 до 5</label>
                </div>
                <div style="margin-top: 0;">
                    <form method="post" action="{{ route('news.rating', ['news' => $news->id]) }}">
                        @csrf
                        <input type="number" name="grade" min="1" max="5" style="margin-top: 2px;" required>
                        <br>
                        <button type="submit" class="btn btn-primary mb-3" style="margin-top: 10px;">Поїхали</button>
                    </form>
                </div>
        @endif
    </div>

        @if ($news->tags && count($news->tags)>0)
            <ul class="tags-list">
                @foreach($news->tags as $tag)
                    <li class="tags-item">
                        <a href="{{ route('news.tag', ['tag' => $tag->id]) }}" class="tag-link"> {{ $tag->name }}</a>
                    </li>
                @endforeach
            </ul>
        @endif

    @if ($user && ($user->isAdmin() || $user->isAuthor() || $user->isRegistered()))
            @if ($user->isBlocked())
                <p class="text-danger my-font-weight">Ви заблоковані та не можете залишати коментарі.</p>
            @else
        <form id="comment-form" action="{{ route('comment.store', $news) }}" method="post">
            @csrf
            @method('POST')
            <label for="content" style="display: block; margin-bottom: 8px; font-weight: bold;">Залишити коментар:</label>
            <textarea name="text" required style="width: 300px; margin-bottom: 5px;"></textarea>
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

        @if (count($comments) > 0 )
        <h6>Всі коментарі:</h6>
        <div id="comments-container">
            @foreach($comments as $comment)
                @if($comment->status != 'blocked')
                @include('news.partials.comment', ['comment' => $comment])
                @endif
            @endforeach
        </div>
        @endif
    <div class="rating-buttons">
    </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
    </script>

@endsection
