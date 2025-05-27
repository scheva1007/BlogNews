@extends('layout.app')

@section('content')
    <div>
        <h4 style="margin-bottom: 15px;">Всі новини:</h4>
        <div id="news-container">
            @include('news.partials.ajaxNews')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('click', function (e) {
                let target = e.target.closest('.pagination a');
                if (target) {
                    e.preventDefault();
                    let url = target.getAttribute('href');
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            document.querySelector('#news-container').innerHTML = data.html;
                            window.history.pushState({}, '', url);
                        })
                        .catch(error => console.error('Помилка завантаження:', error));
                }
            });
        });
    </script>
@endsection
