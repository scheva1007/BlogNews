@extends('layout.app')

@section('content')

@if($notifications->isEmpty())
    <p>У вас немає повідомлень</p>
@else
    @foreach($notifications as $item)
        <p>
            <smal>В новині</smal>
        <a href="{{ route('news.show', $item->news) }}" class="fs-1 font-weight-bold"> {{ $item->news->title }} </a>
            <smal>відповіли на ваш коментар</smal>
        </p>
    @endforeach
@endif
@endsection
