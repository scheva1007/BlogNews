
@extends('layout.app')

@section('content')

 <form method="post" action="{{ route('tag.store') }}" style="width: 300px;">
    @csrf
     <label for="title" style="display: block; margin-bottom: 5px;" class="my-font-weight">Новий тег:</label>
     <input name="name" id="title" type="text" style="width: 300px; margin-bottom: 12px;">
     <button type="submit" class="btn btn-primary mb-3">Створити</button>
 </form>

@endsection
