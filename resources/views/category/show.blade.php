@extends('layout.app')

@section('content')
    @foreach($news as $item)
        <div>
            <a href="{{ route('news.show', $item) }}" class="news-link custom-font-size">{{ $item->title }}</a>
        </div>
    @endforeach
@endsection
