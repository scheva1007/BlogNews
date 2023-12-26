@extends('layout.app')

@section('content')
    <h6>Редактировать новость</h6>
    <form method="post" action="{{ route('news.update', $news) }}">
        @csrf
        @method('PUT')
        <label for="title" style="display: block; margin-bottom: 5px;">Заголовок:</label>
        <input type="text" name="title" value="{{ $news->title }}" required style="width: 300px; margin-bottom: 12px;">
        <br>
        <label for="content" style="display: block; margin-bottom: 5px;">Контент:</label>
        <textarea name="text" required style="width: 300px; margin-bottom: 5px;">{{ $news->content }}</textarea>
        <br>
        <label for="category_id" style="display: block; margin-bottom: 5px;">Категория:</label>
        <select name="category_id" required style="width: 300px; margin-bottom: 12px;">
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
