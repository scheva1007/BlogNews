@extends('layout.app')

@section('content')

    <div>
        <a href="{{ route('championship.createChampionship') }}" class="my-grade my-font-weight" style="font-size: 20px;">Додавання нових турнірів</a>
    </div>
    <div>
        <a href="{{ route('championship.createSeason') }}" class="my-grade my-font-weight" style="font-size: 20px;">Додавання нових сезонів</a>
    </div>
    <div>
        <a href="{{ route('championship.createTeam') }}" class="my-grade my-font-weight" style="font-size: 20px;">Додавання нових команд</a>
    </div>

    <div>
        <a href="{{ route('admin.createMatch') }}" class="my-grade my-font-weight" style="font-size: 20px;">Додавання нових матчів</a>
    </div>

    <div>
        <a href="{{ route('admin.allChampionship') }}" class="my-grade my-font-weight" style="font-size: 20px;">Список турнірів</a>
    </div>

@endsection

