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

      <div style="display: inline-flex; align-items: center; gap: 10px;">
          <!-- Кнопка назад -->
          <button id="prev-date" class="btn btn-primary">←</button>

          <!-- Поле выбора даты -->
          <input type="date" id="date-picker" value="{{ $date }}" class="form-control" style="width: 250px;">

          <!-- Кнопка вперед -->
          <button id="next-date" class="btn btn-primary">→</button>
      </div>
  </div>
  <div id="matches-list">
      @include('news.partials.matches', ['groupedMatches' => $groupedMatches])
  </div>

  <script>
        document.addEventListener("DOMContentLoaded", function () {
            const datePicker = document.getElementById("date-picker");
            const prevDay = document.getElementById("prev-date");
            const nextDay = document.getElementById("next-date");

            function updateMatches(selectedDate) {
                fetch(`{{ route('news.index') }}?date=${selectedDate}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('matches-list').innerHTML = html;
                        document.getElementById('current-date').innerText = selectedDate;
                        datePicker.value = selectedDate;
                    })
                    .catch(error => console.error("Помилка завантаження матчів:", error));
            }
            datePicker.addEventListener("change", function () {
                updateMatches(this.value)
            });

            prevDay.addEventListener("click", function () {
                let currentDate = new Date(datePicker.value);
                currentDate.setDate(currentDate.getDate() - 1);
                updateMatches(currentDate.toISOString().split("T")[0]);
            });

            nextDay.addEventListener("click", function () {
                let currentDate = new Date(datePicker.value);
                currentDate.setDate(currentDate.getDate() + 1);
                updateMatches(currentDate.toISOString().split("T")[0]);
            });
        });
    </script>
@endsection
