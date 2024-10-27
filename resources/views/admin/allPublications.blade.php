@extends('layout.app')

@section('content')

@foreach($news as $item)
    <h5><a href="{{ route('news.show', $item) }}">{{ $item->title }}</a> </h5>
@endforeach
    <div class="mt-3 mb-3"> {{ $news->links() }}</div>
@endsection
