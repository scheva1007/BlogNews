@extends('layout.app')

@section('content')
    @if ($user && $user->count()>0 )
    <div class="logout-container">
        <a href=" {{ route('user.index', $user->first()->id) }}"  class="my-grade my-font-weight" style="font-size: 20px">Панель управління</a>
    </div>
    @endif
    <div>
        <a href="{{ route('category.create') }}" class="my-grade my-font-weight" style="font-size: 20px">Додати категорію</a>
    </div>

@endsection
