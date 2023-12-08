@extends('layout.app')

@section('content')
    <h4>Список новостей:</h4>
    @foreach($news as $item)
        <div style="margin-bottom: 0; font-size: 12px;">{{ $item->formattedDate }}  Комментариев: {{ $item->commentCount }}</div>
            <a href="{{ route('news.show', $item) }}" style="font-size: 18px; margin-bottom: 16px;">{{ $item->title }}</a>
        <p style="margin-bottom: 16px;">{{ $item->content }}</p>


    @endforeach

    <div class="mt-3"> {{ $news->withQueryString()->links() }}</div>
@endsection
