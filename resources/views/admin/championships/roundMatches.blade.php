@extends('layout.app')

@section('content')

    <h5 class="mt-3 mb-3">Тур: {{ $round }}</h5>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Домашня команда</th>
            <th>Гостьова команда</th>
            <th>Рахунок</th>
            <th>Дія</th>
        </tr>
    </thead>
    <tbody>
        @foreach($matches as $match)
            <tr>
                <td>{{ $match->homeTeam->name }}</td>
                <td>{{ $match->awayTeam->name }}</td>
                <td>{{ $match->home_score }} - {{ $match->away_score }}</td>
                <td>
                    <a href="{{ route('admin.editMatch', ['matchId' => $match->id]) }}">Редагувати</a>
                    <form action="{{ route('schedule.destroy', $match->id) }}" method="post" class="ml-3" style="display: inline-block"
                          onsubmit="return confirm('Ви впевнені, що хочете видалити цей матч?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Видалити</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
