<div>
    <span style="margin-bottom: 0; margin-top: 5px; font-size: 12px; background-color: lightcyan">{{ $item->formattedDate }} |
        <i class="fas fa-eye" style="color: gray;"></i> {{ $item->views }} |
        <i class="fas fa-comment" style="color: gray;"></i> {{ $item->commentCount }} |<span style="margin-left: 5px;"> Рейтинг: {{ $item->rating }}</span>
    </span>
    <div style="margin-bottom: 12px;">
        <a href="{{ route('news.show', $item) }} " class="mr-5 main-link "
           style="font-size: 18px; margin-bottom: 30px;">{{ $item->title }}</a>
    </div>
</div>

