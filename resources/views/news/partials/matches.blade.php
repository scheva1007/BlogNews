<div class="container-fluid mt-3">
    <div class="ml-3">
        @foreach ($groupedMatches as $championshipId => $data)
            <div class="d-flex align-items-center border-bottom pb-1 mb-2">
                <h6 class="mb-0 text-left">{{ $data['name'] }}</h6>
                <div class="ml-3">
                    <a href="{{ route('championship.calendar', $championshipId) }}" class=" ml-2">Календар</a>
                    <a href="{{ route('championship.standing', ['championshipId' => $championshipId]) }}" class="ml-3">Таблиця</a>
                </div>
            </div>
            @foreach ($data['rounds'] as $round => $matches)
                <h6 class="mt-3">Тур {{ $round }}</h6>
                @foreach ($matches as $match)
                    <div class="d-flex align-items-center py-1 px-2 bg-light rounded mb-2 text-left">
                            <span class="text-muted small">
                                @if ($match->status === 'finished')
                                    FT
                                @else
                                    {{ \Carbon\Carbon::parse($match->match_date)->format('H:i') }}
                                @endif
                            </span>
                        <span class="font-weight-bold ml-3">
                                {{ $match->homeTeam->name ?? 'Невідомо' }} - {{ $match->awayTeam->name ?? 'Невідомо' }}
                            </span>
                        <span class="font-weight-bold ml-3">
                                @if ($match->status === 'finished')
                                {{ $match->home_score }} : {{ $match->away_score }}
                            @endif
                            </span>
                    </div>
                @endforeach
            @endforeach
        @endforeach
    </div>
</div>
