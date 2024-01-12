@extends('layout.app')

@section('content')

    <h4>Список новостей:</h4>

    @foreach($news as $item)
        <div style="display: flex; align-items: flex-start;">
            @if($item->photo)
                <div style="width: 100px; height: 100px; margin-right: 20px;  margin-bottom: 12px;">
                <img src="{{ asset('/storage/' . $item->photo) }}" alt="News Photo"
                     style="max-width: 100px; max-height: 100px; ">
                </div>
            @endif

            <div>
                <span style="margin-bottom: 0; margin-top: 5px; font-size: 12px; background-color: lightcyan">{{ $item->formattedDate }} | <i
                        class="fas fa-comment" style="color: gray;"></i> {{ $item->commentCount }}</span>
                <div>
                    <a href="{{ route('news.show', $item) }} " class="mr-5 main-link "
                        style="font-size: 18px; margin-bottom: 30px;">{{ $item->title }}</a>
                </div>
                <p class="my-font-content main-link">{{ substr($item->content, 0, 100) }}{{ strlen($item->content) > 100 ? '...' : '' }}</p>
            </div>

        </div>
    @endforeach

    <div class="mt-3"> {{ $news->withQueryString()->links() }}</div>
@endsection
