@extends('layout.app')

@section('content')
    <form method="post"  action="{{ route('comment.update', $comment->id) }}" enctype='multipart/form-data'  style="width: 300px;" >
    @csrf
    @method('PUT')
    <select name="status" id="status" style="width: 300px; margin-bottom: 12px;" required>
        @foreach($statusSelection as $item)
            <option value="{{ $item }}" {{ $comment->status  === $item ? 'selected' : ""}}> {{ $item }}</option>
        @endforeach
        @if ($errors->has('status'))
            <div class="text-danger">{{ $errors->first('status') }}</div>
        @endif
    </select>
    <button type="submit" class='btn btn-primary mb-3'>Оновити</button>
    </form>

@endsection
