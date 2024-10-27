@extends('layout.app')

@section('content')

@if($news->isEmpty())
    <p>У вас немає публікацій</p>
@else
    @foreach($news as $item)
    <h5><a href="{{ route('news.show', $item) }}"> {{$item->title}}</a></h5>
    @endforeach
    @endif

@endsection
