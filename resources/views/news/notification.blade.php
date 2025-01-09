@extends('layout.app')

@section('content')

@if($notifications->isEmpty())
    <p>Увас немає відгуків на ваш коментар</p>
@else
    @foreach($notifications as $item)
        <h5><a href="{{ route('news.show', $item->news) }}">{{ $item->news->title }}</a></h5>
    @endforeach
@endif
@endsection
