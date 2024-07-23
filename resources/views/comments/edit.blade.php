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
    <form method="post" action="{{ route('user.block', $comment->user->id) }}" style="width: 300px;">
    @csrf
        @method('PUT')
        <div class="form-group">
            <label for="days" class="my-font-weight">Заблокувати на (діб):</label>
            <select name="days" class="form-control" style="width: 300px;">
                @foreach($blockingTime as $item)
                    <option value="{{$item}}">{{ $item }}</option>
                @endforeach
                    @if ($errors->has('blocking_until'))
                        <div class="text-danger">{{ $errors->first('blocking_until') }}</div>
                    @endif
            </select>
        </div>
        <button type="submit"class="btn btn-danger mb-3">Заблокувати</button>
    </form>

@endsection
