@extends('layout.app')

@section('content')

    @if (count($news) > 0)
        @foreach($news as $item)
            <div>
                <span style="margin-bottom: 0; margin-top: 5px; font-size: 12px; background-color: lightcyan">{{ $item->formattedDate }} |
                    <i class="fas fa-comment" style="color: gray;"></i> {{ $item->commentCount }} |<span style="margin-left: 5px;"> Рейтинг: {{ $item->rating }}</span>
                </span>
                <div>
                    <a href="{{ route('news.show', $item) }} " class="mr-5 main-link "
                       style="font-size: 18px; margin-bottom: 30px;">{{ $item->title }}</a>
                    @endforeach
    @else
            <p class="news-link custom-font-size"> К сожалению, на данный момент новостей нет</p>
    @endif
@endsection
