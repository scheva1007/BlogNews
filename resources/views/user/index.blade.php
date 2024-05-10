@extends('layout.app')

@section('content')
    <h5 style="margin-bottom: 15px;">Список користувачів:</h5>
    <style>
        td:nth-child(n+2) {
            padding-left: 5px;
        }
    </style>
    <table border="2">
        <thead>
        <tr>
            <th width="70px" >Номер</th>
            <th width="90px">Ім'я</th>
            <th>Роль</th>
        </tr>
        </thead>
        <tbody>
        @foreach($user as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td ><a href="{{ route('admin.edit', $item->id) }}">{{ $item->name }}</a></td>
                <td>{{ $item->role }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
