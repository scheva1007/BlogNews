Это из partials.comment.blade

<span>
    <a href="javascript:void(0);" class="reply" style="margin-left: 5px;" data-comment-id="{{ $comment->id }}">Відповісти</a>
</span>

Это из news.show.blade

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const commentForm = document.getElementById('comment-form');
            const commentsContainer = document.getElementById('comments-container');
           if (commentForm) {
                commentForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const formData = new FormData(commentForm);
                    const url = commentForm.getAttribute('data-url');
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                       .then(response => response.text())
                        .then(data => {
                            commentForm.querySelector('textarea[name="text"]').value = '';
                            commentsContainer.insertAdjacentHTML('afterbegin', data);
                        })
                        .catch(error => {
                            console.error('Error:', error)
                        });
                });
            }
        });
      </script>
     <script>
    document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM fully loaded and parsed');
             const replyLink = document.querySelectorAll('.reply');
        replyLink.forEach(link => {
             link.addEventListener('click', function () {
                 const commentId = this.getAttribute('data-comment-id');
                 if (commentId) {
                     console.log('Comment ID:', commentId);
                 } else {
                     console.error('No comment ID found.');
                }
                 const form = document.getElementById(`reply-form-${commentId}`);
                 if(form) {
                     console.log('Form:', form);
                     form.style.display = form.style.display === 'none' ? 'block' : 'none';
                 } else {
                    console.error(`Form with id "reply-form-${commentId}" not found.`);
                 }
            });
         });
     });
    </script>



@if($item->message_type == 'comment_reply' && $item->news)
@elseif($item->message_type == 'subscription' && $item->news)
    <small>опуюлікована новина автора<strong>{{ $item->news->author->name }}</strong></small>
@endif<small>опуюлікована новина автора<strong>{{ $item->news->author->name }}</strong></small>


notification.blade:

@extends('layout.app')

@section('content')

    @if($notifications->isEmpty())
        <p>У вас немає повідомлень</p>
    @else
        @foreach($notifications as $item)
            @if($item->message_type == 'subscription')
                <div style="margin-bottom: 5px;">
                    <a href="{{ route('news.show', $item->news) }}" class="font-weight-bold" style="font-size: 1.1em;">
                        {{ $item->news->title }}</a>
                    <p style="margin-top: 5px; font-size: 1em;">
                        Опублікована новина автора: <strong>{{ $item->news->author->name }}</strong>
                    </p>
                </div>
            @elseif($item->message_type == 'comment_reply')
                <div style="margin-bottom: 15px;">
                    <p style="font-size: 1.1em;">
                        В новині
                        <a href="{{ route('news.show', $item->news) }}" class="font-weight-bold"> {{ $item->news->title }} </a>
                        відповіли на ваш коментар
                    </p>
                </div>
            @endif
        @endforeach
    @endif
@endsection

Это из news.index.blade(для изменения даты в календаре - чтобы выводило матчи):

<script>
    document.getElementById('date-picker').addEventListener('change', function () {
        let selectedDate = this.value;
        if (selectedDate) {
            let url = new URL(window.location.href);
            url.searchParams.set('date', selectedDate);
            window.location.href = url.toString();
        }
    });
</script>
