@extends('layout.app')

@section('content')
    <form method="post"  action="{{ route('comment.update', $comment->id) }}" enctype='multipart/form-data'  style="width: 300px;" >
    @csrf
    @method('PUT')
    <select name="status" id="status" style="width: 300px; margin-bottom: 12px;">
        <option value="">Оберіть статус:</option>
        @foreach($statusSelection as $item)
            <option value="{{ $item }}" {{ $comment->status  === $item ? 'selected' : ""}}> {{ $item }}</option>
        @endforeach
    </select>
    <button type="submit" class='btn btn-primary mb-3'>Оновити</button>
    </form>

@endsection
