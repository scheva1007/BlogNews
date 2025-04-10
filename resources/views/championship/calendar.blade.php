@extends('layout.app')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center">
            <h5 class="mb-2 mr-3"> Календар матчів {{ $seasonChampionship->name }} </h5>
            <form method="GET">
                <select name="season" onchange="this.form.submit()" class="mb-2">
                    @foreach($seasons as $season)
                        <option value="{{ $season->season }}" {{ $selectSeason == $season->season ? 'selected' : '' }}>
                            {{ $season->season }}
                        </option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('championship.standing', $seasonChampionship->id) }}" class="mb-2 ml-5">Переглянути таблицю</a>
        </div>
        @foreach ($matches as $round => $roundMatches)
            <div class="mb-4">
                <h5 class="border-bottom pb-2">Тур {{ $round }}</h5>
                @foreach ($roundMatches as $match)
                    <div class="d-flex justify-content-between align-items-center py-2 px-3 bg-light rounded mb-1">
                    <span class="text-muted small">
                        @if ($match->status === 'finished')
                           <span>FT </span> <span class="ml-3">{{ \Carbon\Carbon::parse($match->match_date)->format('d.m.Y') }}</span>
                        @else
                            {{ \Carbon\Carbon::parse($match->match_date)->format('H:i d.m.Y') }}
                        @endif
                    </span>
                        <span class="font-weight-bold">{{ $match->homeTeam->name }} - {{ $match->awayTeam->name }}</span>
                        <span class="font-weight-bold">
                        @if ($match->status === 'finished')
                                {{ $match->home_score }} : {{ $match->away_score }}
                            @endif
                    </span>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
