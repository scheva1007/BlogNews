
        <div style="margin-bottom: 10px; ">
            <span
                class="news-link my-font-size my-margin-right background-data">Добавил(-a): {{ $comment->user->name }} </span>
            <span class="news-link my-font-size background-data">{{ $comment->formattedDate }}</span>
            <div> *{{ $comment->content }}
                <div class="rating-buttons" style="display: flex;">
                    @auth
                        @if($comment->user_id != auth()->id())
                            <a href="{{ route('comment.setLikeStatus', ['comment' => $comment->id, 'like_status' => true]) }}"><i
                                    class="fas fa-thumbs-up"></i></a>
                        @else
                            <i class="fas fa-thumbs-up"></i>
                        @endif
                    @endauth
                    <span style="margin-right: 10px;">{{ $comment->countLikes ?: 0 }}</span>
                        @auth
                            @if($comment->user_id != auth()->id())
                                <a href="{{ route('comment.setLikeStatus', ['comment' => $comment->id, 'like_status' => false]) }}"><i
                                        class="fas fa-thumbs-down"></i></a>
                            @else
                                <i class="fas fa-thumbs-down"></i>
                            @endif
                        @endauth
                    <span>{{ $comment->countDislikes ?: 0 }}</span>
                        <div style="margin-left:20px;">
                            <input type="checkbox" id="reply-toggle-{{ $comment->id }}" class="reply-toggle" style="display: none;">
                            <label for="reply-toggle-{{ $comment->id }}" class="reply" style="cursor: pointer; margin-left: 5px;">Відповісти</label>

                            <div class="reply-form" id="reply-form-{{ $comment->id }}" style="margin-top: 10px;">
                            <form method="post" action="{{ route('comment.store', $news) }}">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <textarea name="text" id="reply-content-{{ $comment->id }}" required placeholder="Приєднатися до обговорення" style="width: 300px;"></textarea>
                                <div>
                                <button type="submit" class="btn btn-success mb-3" style="height: 30px; line-height: 1">Коментар</button>
                                </div>
                            </form>
                        </div>
                        </div>
                </div>
                        @if($comment->replies)
                            <div class="replies" style="margin-left: 20px;">
                                @foreach($comment->replies as $reply)
                                    @include('news.partials.comment', ['comment' => $reply])
                                @endforeach
                            </div>
                        @endif
                </div>
        </div>

