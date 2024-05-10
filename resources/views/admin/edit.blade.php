@extends('layout.app')

@section('content')
    <form method="post"  action="{{ route('admin.update', $user->id) }}" enctype='multipart/form-data'  style="width: 300px;" >
        @csrf
        @method('PUT')
       <span>
           <span>Ім`я: </span>
           <span class="my-font-weight" > {{ $user->name }} </span>
       </span>
        <select name="role" id="role" style="width: 300px; margin-bottom: 12px;">
            <option value="">Оберіть роль:</option>
            @foreach($roles as $item)
            <option value="{{ $item }}" {{ $user->role  === $item ? 'selected' : ""}}> {{ $item }}</option>
            @endforeach
            </select>
        <button type="submit" class='btn btn-primary mb-3'>Оновити</button>
    </form>
@endsection
