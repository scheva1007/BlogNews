@extends('layout.app')

@section('content')

<div class="container">
    <div class="d-flex align-items-center">
    <h5>Турнірна таблиця {{ $championship->name }}</h5>
    <a href="{{ route('championship.calendar', $championship->id) }}" class="mb-2 ml-5">Переглянути календар матчів</a>
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
                    <td>{{ $team->matches }}</td>
                    <td>{{ $team->wins }}</td>
                    <td>{{ $team->draws }}</td>
                    <td>{{ $team->losses }}</td>
                    <td>{{ $team->goals_scored }}</td>
                    <td>{{ $team->goals_missed }}</td>
                    <td>{{ $team->points }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
