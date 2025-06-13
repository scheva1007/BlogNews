@extends('layout.app')

@section('content')

    @foreach($championships as $championship)
        <div class="mb-4 p-3 border rounded">
            <h5>{{ $championship->name }}</h5>

            @if(isset($seasons[$championship->id]))
                <ul>
                    @foreach($seasons[$championship->id] as $seasonItem)
                        <li>
                            <a href="{{ route('admin.championshipRounds', [
                                'championshipId' => $championship->id,
                                'season' => $seasonItem->season
                            ]) }}">
                                Сезон {{ $seasonItem->season }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Немає сезонів</p>
            @endif
        </div>
    @endforeach

    <div class="mt-3 mb-3">
        {{ $championships->links() }}
    </div>

@endsection
