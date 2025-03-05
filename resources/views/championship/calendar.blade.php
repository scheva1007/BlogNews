@extends('layout.app')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center">
            <h5 class="mb-2"> Календар матчів {{ $championship->name }} </h5>
            <a href="{{ route('championship.standing', $championship->id) }}" class="mb-2 ml-5">Переглянути таблицю</a>
        </div>
        @foreach ($matches as $round => $roundMatches)
            <div class="mb-4">
                <h5 class="border-bottom pb-2">Тур {{ $round }}</h5>
                @foreach ($roundMatches as $match)
                    <div class="d-flex justify-content-between align-items-center py-2 px-3 bg-light rounded mb-1">
                    <span class="text-muted small">
                        @if ($match->status === 'finished')
                            FT
                        @else
                            {{ \Carbon\Carbon::parse($match->match_date)->format('H:i') }}
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
