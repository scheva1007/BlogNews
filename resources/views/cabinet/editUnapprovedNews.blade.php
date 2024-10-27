@extends('layout.app')

@section('content')
    @if($news)
        <h5>Редагувати новину:</h5>
    <form method="post" action="{{ route('cabinet.updateUnapprovedNews', $news->id) }}" enctype='multipart/form-data' style="width: 300px;">
        @csrf
        @method('PUT')
        <label for="title" style="display: block; margin-bottom: 5px;">Заголовок:</label>
        <input type="text" name="title" value="{{ $news->title }}" required style="width: 300px; margin-bottom: 12px;">
        @if($errors->has('title'))
            <div class="text-danger">{{ $erors->first('title') }}</div>
        @endif
        <br>
        <label for="content" style="display: block; margin-bottom: 5px;">Контент:</label>
        <textarea name="text" required style="width: 300px; margin-bottom: 5px;">{{ $news->content }}</textarea>
        @if($errors->has('content'))
            <div class="text-danger">{{ $erors->first('content') }}</div>
        @endif
        <br>
        <label for="category_id" style="display: block; margin-bottom: 5px;">Категорія:</label>
        <select name="category_id" required style="width: 300px; margin-bottom: 12px;">
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $news->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @if($errors->has('category_id'))
            <div class="text-danger">{{ $erors->first('category_id') }}</div>
        @endif
        <label for="tags" style="display: block; margin-bottom: 5px;">Теги:</label>
        <select name="tags[]" multiple style="width: 300px; margin-bottom: 12px;">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <br>
        <label for="image" style="display: block; margin-bottom: 5px;">Зображення:</label>
        @if($news->photo)
            <div style="margin-bottom: 12px;">
                <img src="{{ asset('storage/' .$news->photo) }}" alt="Current Photo" style="max-height: 150px; max-width: 150px;">
            </div>
        @endif
        <input type="file" name="photo" accept="image/*" style="margin-bottom: 12px;">
        @if($errors->has('photo'))
            <div class="text-danger">{{ $errors->first('photo') }}</div>
        @endif
        <br>
        <div style="margin-bottom: 2px;">
            <input type="checkbox" name="published" id="published" {{ $news->published  ? 'checked' : '' }}>
            <label for="published" class="my-font-weight">Опублікувати статтю</label>
        </div>
        <button type="submit" class='btn btn-primary mb-3'>Зберегти</button>
    </form>
    @else
        <p>У вас немає неперевірених статей</p>
    @endif
@endsection




