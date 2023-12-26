<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваш спортивный сайт</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>
<body>

<header class="container-fluid">
    <div class="row" >
        <div class="col d-flex">
         <nav class="nav">
            <a class="nav-link custom-font-size custom-margin site-name" style="color: green" href="{{ route('news.index') }}" >Команда</a>
             @php
                $user=auth()->user();
             @endphp
             @if ($user && ($user->isAdmin() || $user->isAuthor()))
            <a class="nav-link custom-font-size custom-margin category-link" href="{{ route('news.create') }}">Добавить новость</a>
            @endif
            @if(isset($categories))
                @foreach($categories as $category)
                    <a class="nav-link custom-font-size custom-margin category-link" href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                @endforeach
            @endif
         </nav>
        </div>
        <div class="mt-4">
            @if(!$user)
            <a href="{{ route('register') }}" class="custom-margin custom-font-size">Регистрация</a>
            @endif
        </div>
        <div class="col-md-1 mt-4">
            @if(!$user)
            <a href="{{ route('login') }}" class="custom-margin custom-font-size">Вход</a>
            @endif
        </div>
        @if($user)
            <div class="logout-container">
              <form id="logout-form" action="{{ route('logout') }}" method="POST"  >
                {{ csrf_field() }}
                <button type="submit" class="btn-link-like"> Выйти</button>
              </form>
           </div>
        @endif
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
