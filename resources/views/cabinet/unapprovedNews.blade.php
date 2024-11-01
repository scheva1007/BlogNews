@extends('layout.app')

@section('content')

    @if($news->isEmpty())
        <p>У вас немає недоопрацьованих статей</p>
    @else
        @foreach($news as $item)
            <h5><a href="{{ route('cabinet.editUnapprovedNews', $item) }}">{{ $item->title }}</a> </h5>
        @endforeach
    @endif
    <div class="mt-3 mb-3">{{ $news->links() }}</div>

@endsection
