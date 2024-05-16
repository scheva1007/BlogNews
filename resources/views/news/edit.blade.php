@extends('layout.app')

@section('content')
    <h6>Редагувати новину</h6>
    <form method="post"  action="{{ route('news.update', $news) }}" enctype='multipart/form-data'  style="width: 300px;" >
        @csrf
        @method('PUT')
        <label for="title" style="display: block; margin-bottom: 5px;">Заголовок:</label>
        <input type="text" name="title" value="{{ $news->title }}" required style="width: 300px; margin-bottom: 12px;">
        <br>
        <label for="content" style="display: block; margin-bottom: 5px;">Контент:</label>
        <textarea name="text" required style="width: 300px; margin-bottom: 5px;">{{ $news->content }}</textarea>
        <br>
        <label for="category_id" style="display: block; margin-bottom: 5px;">Категорія:</label>
        <select name="category_id" required style="width: 300px; margin-bottom: 12px;">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $news->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <label for="tag" style="display: block; margin-bottom: 5px;">Теги:</label>
        <select name="tag[]" multiple style="width: 300px; margin-bottom: 12px;">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <br>
        <label for="image" style="display: block; margin-bottom: 5px;">Зображення:</label>
        <input type="file" name="photo" accept="image/*" style="margin-bottom: 12px;">
        <br>
        <button type="submit" class='btn btn-primary mb-3'>Зберегти</button>
    </form>
@endsection
