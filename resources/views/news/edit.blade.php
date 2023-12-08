@extends('layout.app')

@section('content')
    <h1>Редактировать новость</h1>
    <form method="post" action="{{ route('news.update', $news) }}">
        @csrf
        @method('PUT')
        <label for="title">Заголовок:</label>
        <input type="text" name="title" value="{{ $news->title }}" required>
        <br>
        <label for="content">Контент:</label>
        <textarea name="text" required>{{ $news->content }}</textarea>
        <br>
        <label for="category_id">Категория:</label>
        <select name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $news->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <br>
        <button type="submit" class='btn btn-primary mb-3'>Сохранить</button>
    </form>
@endsection
