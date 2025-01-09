<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваш спортивный сайт</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>

<header class="container-fluid fixed-header">

    <div class="row">
        <div class="col d-flex">
            <nav class="nav">
                <a class="nav-link custom-font-size custom-margin site-name" style="color: green"
                   href="{{ route('news.index') }}">Команда</a>
                @php
                    $user=auth()->user();
                @endphp

                @if ($user && ($user->isAdmin() || $user->isAuthor()) && Route::currentRouteName() !== 'news.create')
                    <a class="nav-link custom-font-size custom-margin category-link " href="{{ route('news.create') }}">
                        Додати новину</a>
                @endif

                <div class="dropdown mb-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Оберіть категорію
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <a class="dropdown-item main-link"
                                   href="{{ route('category.show', $category) }}">{{ $category->name }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>

            </nav>
        </div>
        <div class="mt-4">
            @if(!$user)
                <a href="{{ route('register') }}" class="custom-margin custom-font-size">Реєстрація</a>
            @endif
        </div>
        <div class="col-md-1 mt-4">
            @if(!$user)
                <a href="{{ route('login') }}" class="custom-margin custom-font-size">Вхід</a>
            @endif
        </div>

        @if($user && $user->isAdmin())
            <div class="logout-container" style="margin-top: 27px;">
                <a href=" {{ route('admin.index') }}" class="custom-margin custom-font-size admin-link">Адмінпанель</a>
            </div>
        @endif
        <div class="d-flex mt-4">
        @if(auth()->check() &&  !$user->isAdmin())
            @if(Route::currentRouteName() != 'cabinet.index')
                    <a href="{{ route('cabinet.index') }}" class="btn-link-like">Кабінет</a>
                @endif
            @endif
            @if($user)
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mr-2">
                    {{ csrf_field() }}
                    <button type="submit" class="btn-link-like">Вийти</button>
                </form>
            @endif
            <div class="d-flex mr-5 my-indent">
                @if(auth()->check() && ($user->isAdmin() || $user->isAuthor() || $user->isRegistered()))
                <a href="{{ route('notification.index') }} " class="custom-margin admin-link">Повідомлення</a>
                @endif
            </div>

    </div>
</header>

<main class="container-fluid main-container" style="margin-top: 100px;">
    @yield('content')
</main>

<footer>
    <h4>&copy;{{ date('Y') }} Команда</h4>
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
