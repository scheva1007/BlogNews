@extends('layout.app')

@section('content')

    @foreach($championship as $item)
       <h5><a href="{{ route('admin.championshipRounds', ['championshipId' => $item->id]) }}">{{ $item->name }}</a> </h5>
   @endforeach
       <div class="mt-3 mb-3"> {{ $championship->links() }}</div>
@endsection
