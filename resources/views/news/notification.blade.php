@extends('layout.app')

@section('content')
    <h1>Ваші повідомлення</h1>

    @if($notifications->isEmpty())
        <p>У вас немає повідомлень</p>
    @else
        @foreach($notifications as $item)
            @if($item->message_type == 'subscription')
                <div style="margin-bottom: 5px;">
                    <a href="{{ route('news.show', $item->news) }}" class="font-weight-bold; mark-as-read" data-id="{{ $item->id }}" style="font-size: 1.1em;">
                        {{ $item->news->title }}</a>
                    <p style="margin-top: 5px; font-size: 1em;">
                        Опублікована новина автора: <strong>{{ $item->news->author->name }}</strong>
                    </p>
                </div>
            @elseif($item->message_type == 'comment_reply')
                <div style="margin-bottom: 15px;">
                    <p style="font-size: 1.1em;">
                        В новині
                        <a href="{{ route('news.show', $item->news) }}#comment-{{ $item->additional_info }}" class="font-weight-bold; mark-as-read" data-id="{{ $item->id }}"> {{ $item->news->title }} </a>
                        відповіли на ваш коментар
                    </p>
                </div>
            @endif
        @endforeach
    @endif
@endsection

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.mark-as-read');

            links.forEach(link => {
                link.addEventListener('click', function (event) {
                    const notificationId = this.dataset.id;

                    fetch("{{ route('notification.changeStatus') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ notification_id: notificationId }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const notificationDiv = this.closest('.notification');
                                if (notificationDiv) {
                                    notificationDiv.style.transition = "opacity 0.5s ease";
                                    notificationDiv.style.opacity = "0";
                                    setTimeout(() => notificationDiv.remove(), 500);
                                }
                            }
                        })
                        .catch(error => console.error('Error:', error));
                })
            })
        })
</script>
