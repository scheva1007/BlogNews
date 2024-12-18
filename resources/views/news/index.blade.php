@extends('layout.app')

@section('content')
  <div id="news-container" class="d-flex">
      <div>

    <h4 style="margin-bottom: 25px;">Популярні новини:</h4>

    @foreach($topNews as $item)

        <div  style="display: flex; align-items: flex-start;">
            @if($item->photo)
                <div style="width: 170px; height: 130px; margin-right: 20px;  margin-bottom: 10px;">
                <img src="{{ asset('/storage/' . $item->photo) }}" alt="News Photo"
                     style="max-width: 170px; max-height: 130px; ">
                </div>
            @endif

            <div>
                <span style="margin-bottom: 0; margin-top: 5px; font-size: 12px; background-color: lightcyan; padding: 2px 5px">{{ $item->formattedDate }} |
                    <i class="fas fa-eye" style="color: gray;"></i> {{ $item->views }} |
                    <i class="fas fa-comment" style="color: gray;"></i> {{ $item->comment_count }} |
                    <span style="margin-left: 5px;"> Рейтинг: {{ $item->rating }}</span>
                </span>
                <div>
                    <a href="{{ route('news.show', $item) }} " class="mr-5 main-link "
                        style="font-size: 20px; margin-bottom: 30px;">{{ $item->title }}</a>
                </div>
                <p class="my-font-content mt-2">{{ substr($item->content, 0, 100) }}{{ strlen($item->content) > 100 ? '...' : '' }}</p>
            </div>
        </div>
          @endforeach
      </div>
      <div id="main-news" style="margin-left: 7%;">
          <h5>Останні новини:</h5>
          @foreach($news as $item)
              @include('news.partials.newsList')
          @endforeach
          <div class="mt-3">
              <a href="{{ route('news.all') }}" class="btn-link-news">Переглянути всі новини</a>
          </div>
      </div>
  </div>
@endsection
