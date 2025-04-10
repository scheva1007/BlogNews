@extends('layout.app')

@section('content')

<div class="container">
    <div class="d-flex align-items-center">
    <h5 class="mr-3">Турнірна таблиця {{ $seasonChampionship->name }}</h5>
        <form method="GET">
            <select name="season" onchange="this.form.submit()" class="mb-2">
                @foreach($seasons as $season)
                    <option value="{{ $season->season }}" {{ $selectedSeason == $season->season ? 'selected' : '' }}>
                    {{ $season->season }}
                    </option>
                @endforeach
            </select>
        </form>
    <a href="{{ route('championship.calendar', $seasonChampionship->id) }}" class="mb-2 ml-5">Переглянути календар матчів</a>
</div>
    <table class="table table-striped float-left">
        <thead>
            <tr>
                <th>#</th>
                <th>Команда</th>
                <th>Ігри</th>
                <th>В</th>
                <th>Н</th>
                <th>П</th>
                <th>ЗМ</th>
                <th>ПМ</th>
                <th>Очки</th>
            </tr>
        </thead>
        <tbody>
            @foreach($standings as $index => $team)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $team->teams->name }}</td>
                    <td>{{ $team['matches'] }}</td>
                    <td>{{ $team['wins'] }}</td>
                    <td>{{ $team['draws'] }}</td>
                    <td>{{ $team['losses'] }}</td>
                    <td>{{ $team['goals_scored'] }}</td>
                    <td>{{ $team['goals_missed'] }}</td>
                    <td>{{ $team['points'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
