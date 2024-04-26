@extends('layout.app')

@section('content')


    <form method="post" enctype='multipart/form-data' action="{{ route('news.store') }}" style="width: 300px;">
        @csrf
        <label for="title" class="my-font-weight" style="display: block; margin-bottom: 5px;">Заголовок:</label>
        <input type="text" name="title" required style="width: 300px; margin-bottom: 12px;">
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        <label for="content" class="my-font-weight" style="display: block; margin-bottom: 5px;">Контент:</label>
        <textarea name="text" required style="width: 300px; margin-bottom: 5px;"></textarea>
        @error('content')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label for="photo" class="my-font-weight">Фото:</label>
        <br>
        <input type="file" name="photo" accept="image/*">
        <label for="category_id" class="my-font-weight indent" style="display: block; margin-bottom: 5px;">Категория:</label>
        <select name="category_id" required style="width: 300px; margin-bottom: 12px;">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <br>
        <button type="submit" class="btn btn-primary mb-3">Создать</button>
    </form>

@endsection
