<div class="news-list-wrapper">
@foreach($allNews as $item)
    <div style="display:flex; align-items:flex-start; margin-bottom: 5px;">
        @if($item->photo)
            <div style="width: 170px; height: 130px; margin-right: 20px;  margin-bottom: 10px;">
                <img src="{{ asset('/storage/' . $item->photo) }}" alt="News Photo"
                     style="max-width: 170px; max-height: 130px; ">
            </div>
        @endif
        <div>
            @include('news.partials.newsList')
            <p class="my-font-content">{{ substr($item->text, 0, 100) }}{{ strlen($item->text) > 100 ? '...' : '' }}</p>
        </div>
    </div>
@endforeach
    <div class="mt-3 mb-3 align-items-start">
        {{ $allNews->withQueryString() }}
    </div>
</div>
