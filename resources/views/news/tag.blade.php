@extends('layout.app')

@section('content')
<div>
<h5 class="mb-4 mt-3">Всі новини за тегом: <span class="color-tag"> {{ $tag->name }} </span></h5>
    @if($news->isEmpty())
        <p>За цим тегом новин не знайдено</p>
    @else
@foreach($news as $item)
    <div style="display:flex; align-items:flex-start; margin-bottom: 5px;">
        @if($item->photo)
            <div style="width: 170px; height: 130px; margin-right: 20px;  margin-bottom: 10px;">
                <img src="{{ asset('/storage/' . $item->photo) }}" alt="News Photo"
                     style="max-width: 170px; max-height: 130px; ">
            </div>
        @endif
        <div>
            @include('news.partials.newsList')
            <p class="my-font-content">{{ substr($item->content, 0, 100) }}{{ strlen($item->content) > 100 ? '...' : '' }}</p>

            <ul class="tags-list">
                @foreach($item->tags as $tag)
                    <li class="tags-item">
                        <a href="{{ route('news.tag', ['tag' => $tag->name]) }}" class="tag-link">{{ $tag->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach
<div class="mt-3 mb-3 align-items-start">{{ $news->withQueryString() }}</div>
        @endif
</div>


@endsection
