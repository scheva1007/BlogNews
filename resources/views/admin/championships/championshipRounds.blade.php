@extends('layout.app')

@section('content')

    <div class="rounds-container">
   @foreach($rounds as $item)
            <div class="round-item">
       <h5><a href="{{ route('admin.roundMatches', ['championshipId' => $championshipId, 'round' => $item->round]) }}">{{ $item->round }}</a> </h5>
            </div>
   @endforeach
    </div>

@endsection

