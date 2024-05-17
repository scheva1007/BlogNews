
        <div style="margin-bottom: 10px; ">
            <span
                class="news-link my-font-size my-margin-right background-data">Добавил(-a): {{ $comment->user->name }} </span>
            <span class="news-link my-font-size background-data">{{ $comment->formattedDate }}</span>
            <div> *{{ $comment->content }}
                <div class="rating-buttons">
                    @auth
                        @if($comment->user_id != auth()->id())
                            <a href="{{ route('comment.setLikeStatus', ['comment' => $comment->id, 'like_status' => true]) }}"><i
                                    class="fas fa-thumbs-up"></i></a>
                        @else
                            <i class="fas fa-thumbs-up"></i>
                        @endif
                    @endauth
                    <span>{{ $comment->countLikes ?: 0 }}</span>
                        @auth
                            @if($comment->user_id != auth()->id())
                                <a href="{{ route('comment.setLikeStatus', ['comment' => $comment->id, 'like_status' => false]) }}"><i
                                        class="fas fa-thumbs-down"></i></a>
                            @else
                                <i class="fas fa-thumbs-down"></i>
                            @endif
                        @endauth
                    <span>{{ $comment->countDislikes ?: 0 }}</span>
                </div>
            </div>
        </div>

