@extends('layout.app')

@section('content')

    @if (count($news) > 0)
        @foreach($news as $item)
            @include('news.partials.newsList')
        @endforeach
    @else
            <p class="news-link custom-font-size"> К сожалению, на данный момент новостей нет</p>
    @endif
@endsection
