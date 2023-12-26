@extends('layout.app')

@section('content')

    <h4>Список новостей:</h4>
    @foreach($news as $item)
        <div style="margin-bottom: 0; font-size: 12px;">{{ $item->formattedDate }}  Комментариев: {{ $item->commentCount }}</div>
        <div style="font-size: 18px; margin-bottom: 15px;">
            <a href="{{ route('news.show', $item) }}" >{{ $item->title }}</a>

        </div>
    @endforeach

    <div class="mt-3"> {{ $news->withQueryString()->links() }}</div>
@endsection
