@extends('layout.app')

@section('content')

    <table border="2">
        <thead>
        <tr>
            <th width="70px" >Номер</th>
            <th width="170px" >Коментар</th>
            <th width="70px">Статус</th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $index => $comment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $comment->content }}</td>
                <td ><a href="{{ route('comment.edit', $comment->id) }}">{{ $comment->status }}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
