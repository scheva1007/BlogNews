<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваш спортивный сайт</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .custom-font-size {
            font-size: 18px;
        }

        .custom-margin {
            margin-right: 10px;
        }

        .news-link {
            color: #000000;
        }

        .nav {
            display: flex;
            align-items: baseline;
        }

        .site-name {
            font-size: 30px;
            margin-bottom: 0;
        }

        .category-link {
            font-size: 18px;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px;
            color: blue;
        }

        //.news-item {
            display: flex;
            margin-bottom: 20px;
        }

        //.news-meta {
            margin-left: 20px;
            text-align: right;
        }

        //.news-content {
            flex-grow: 1;
        }
    </style>
</head>
<body>


<header class="container-fluid">
    <div class="row" >
            <div class="col d-flex">
             <nav class="nav">
                <a class="nav-link custom-font-size custom-margin site-name" style="color: green" href="{{ route('news.index') }}" >Команда</a>
                <a class="nav-link custom-font-size custom-margin category-link" href="{{ route('news.create') }}">Добавить новость</a>
                @if(isset($categories))
                    @foreach($categories as $category)
                        <a class="nav-link custom-font-size custom-margin category-link" href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                    @endforeach
                @endif
             </nav>
            </div>
    </div>
</header>


<main class="container-fluid">
    @yield('content')
</main>

<footer>
    <h4>&copy; 2023 Команда</h4>
</footer>

</body>
</html>
