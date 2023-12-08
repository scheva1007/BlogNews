@extends('layout.app')

@section('content')

    <form method="post" action="{{ route('news.store') }}" style="width: 300px;">
        @csrf
        <label for="title" style="display: block; margin-bottom: 5px;">Заголовок:</label>
        <input type="text" name="title" required style="width: 300px; margin-bottom: 12px;">
        <br>
        <label for="content" style="display: block; margin-bottom: 5px;">Контент:</label>
        <textarea name="text" required style="width: 300px; margin-bottom: 5px;"></textarea>
        <br>
        <label for="category_id" style="display: block; margin-bottom: 5px;">Категория:</label>
        <select name="category_id" required style="width: 300px; margin-bottom: 12px;">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <br>
        <button type="submit" class="btn btn-primary mb-3">Создать</button>
    </form>
@endsection
