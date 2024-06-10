@extends('layout.app')

@section('content')

    <form method="post" enctype='multipart/form-data'  action="{{ route('category.store') }}" style="width: 300px;">
        @csrf
        <label for="title" style="display: block; margin-bottom: 5px;" class="my-font-weight">Категорія:</label>
        <input id="title" type="text" name="name" required style="width: 300px; margin-bottom: 12px;">
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-primary mb-3">Створити</button>
    </form>
@endsection



