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
                <p class="my-font-content mt-2">{{ substr($item->text, 0, 100) }}{{ strlen($item->text) > 100 ? '...' : '' }}</p>
            </div>
        </div>
          @endforeach
      </div>
      <div id="main-news" style="margin-left: 7%;">
          <h5>Останні новини:</h5>
          @foreach($latestNews as $item)
              @include('news.partials.newsList')
          @endforeach
          <div class="mt-3">
              <a href="{{ route('news.all') }}" class="btn-link-news">Переглянути всі новини</a>
          </div>
      </div>
  </div>
  <div id="matches-container" style="margin-top: 30px;">
      <h4>Результати матчів на <span id="current-date">{{ $date }}</span></h4>

      <div style="display: flex; align-items: center; gap: 10px;">
          <!-- Кнопка назад -->
          <a href="{{ route('news.index', ['date' => \Carbon\Carbon::parse($date)->subDay()->format('Y-m-d')]) }}"
             class="btn btn-primary">←</a>

          <!-- Поле выбора даты -->
          <input type="date" id="date-picker" value="{{ $date }}" class="form-control">

          <!-- Кнопка вперед -->
          <a href="{{ route('news.index', ['date' => \Carbon\Carbon::parse($date)->addDay()->format('Y-m-d')]) }}"
             class="btn btn-primary">→</a>
      </div>
  </div>

      <div class="container-fluid mt-3">
          <div class="ml-3">
              @foreach ($groupedMatches as $championshipId => $data)
                      <div class="d-flex align-items-center border-bottom pb-1 mb-2">
                          <h6 class="mb-0 text-left">{{ $data['name'] }}</h6>
                          <div class="ml-3">
                              <a href="{{ route('championship.calendar', $championshipId) }}" class=" ml-2">Календар</a>
                              <a href="{{ route('championship.standing', ['championshipId' => $championshipId]) }}" class="ml-3">Таблиця</a>
                          </div>
                      </div>
                  @foreach ($data['rounds'] as $round => $matches)
                      <h6 class="mt-3">Тур {{ $round }}</h6>
                      @foreach ($matches as $match)
                              <div class="d-flex align-items-center py-1 px-2 bg-light rounded mb-2 text-left">
                            <span class="text-muted small">
                                @if ($match->status === 'finished')
                                    FT
                                @else
                                    {{ \Carbon\Carbon::parse($match->match_date)->format('H:i') }}
                                @endif
                            </span>
                                  <span class="font-weight-bold ml-3">
                                {{ $match->homeTeam->name ?? 'Невідомо' }} - {{ $match->awayTeam->name ?? 'Невідомо' }}
                            </span>
                                  <span class="font-weight-bold ml-3">
                                @if ($match->status === 'finished')
                                          {{ $match->home_score }} : {{ $match->away_score }}
                                      @endif
                            </span>
                              </div>
                          @endforeach
                      @endforeach
                  @endforeach
          </div>
      </div>
  </div>
    <script>
        ocument.getElementById('date-picker').addEventListener('change', function () {
            let selectedDate = this.value;
            if (selectedDate) {
                window.location.href = '?date=' + selectedDate;
            }
        });
    </script>
@endsection
