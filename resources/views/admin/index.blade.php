@extends('layout.app')

@section('content')
    @if ($user && $user->count()>0 )
    <div class="logout-container">
        <a href=" {{ route('user.index', $user->first()->id) }}"  class="my-grade my-font-weight" style="font-size: 20px">Керування ролями</a>
    </div>
    @endif
    <div>
        <a href="{{ route('category.create') }}" class="my-grade my-font-weight" style="font-size: 20px">Додати категорію</a>
    </div>
    <div>
        <a href="{{ route('comment.index') }}" class="my-grade my-font-weight" style="font-size: 20px">Керування коментарями</a>
    </div>
    <div>
        <a href="{{ route('tag.create') }}" class="my-grade my-font-weight" style="font-size: 20px">Додати тег</a>
    </div>
    <div>
        <a href="{{ route('admin.allPublications') }}" class="my-grade my-font-weight"  style="font-size: 20px;">Всі публікації</a>
    </div>
    <div>
        <a href="{{ route('admin.uncheckedNews') }}" class="my-grade my-font-weight" style="font-size: 20px;">Неопубліковані статті</a>
    </div>
    <div>
        <a href="{{ route('championship.creationTournaments') }}" class="my-grade my-font-weight" style="font-size: 20px;">Створення турнірів</a>
    </div>

@endsection
