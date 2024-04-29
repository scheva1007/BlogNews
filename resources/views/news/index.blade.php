@extends('layout.app')

@section('content')
  <div id="news-container" class="d-flex">
      <div>

    <h4 style="margin-bottom: 25px;">ТОП-5 новости:</h4>

    @foreach($topNews as $item)

        <div  style="display: flex; align-items: flex-start;">
            @if($item->photo)
                <div style="width: 135px; height: 135px; margin-right: 20px;  margin-bottom: 12px;">
                <img src="{{ asset('/storage/' . $item->photo) }}" alt="News Photo"
                     style="max-width: 130px; max-height: 130px; ">
                </div>
            @endif

            <div>
                <span style="margin-bottom: 0; margin-top: 5px; font-size: 12px; background-color: lightcyan">{{ $item->formattedDate }} |
                    <i class="fas fa-eye" style="color: gray;"></i> {{ $item->views }} |
                    <i class="fas fa-comment" style="color: gray;"></i> {{ $item->commentCount }} |<span style="margin-left: 5px;"> Рейтинг: {{ $item->rating }}</span>
                </span>
                <div>
                    <a href="{{ route('news.show', $item) }} " class="mr-5 main-link "
                        style="font-size: 18px; margin-bottom: 30px;">{{ $item->title }}</a>
                </div>
                <p class="my-font-content">{{ substr($item->content, 0, 100) }}{{ strlen($item->content) > 100 ? '...' : '' }}</p>
            </div>
        </div>
          @endforeach
      </div>
      <div id="main-news" style="margin-left: 10%;">
          <h5>Список новостей:</h5>

          @foreach($news as $item)
              @include('news.partials.newsList')
          @endforeach
          <div class="mb-3 align-items-start"> {{ $news->withQueryString()->links() }}</div>
      </div>

  </div>



@endsection
