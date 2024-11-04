@extends('layout.app')

@section('content')
    @php
        $user = auth()->user();
    @endphp
<form method="post" action="{{ route('cabinet.update') }}" style="width: 300px;">
    @csrf
    @method('PUT')
    <div>
        <label style="display: block; margin-bottom: 5px;" class="my-font-weight">Ім'я:</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" style="width: 200px; margin-bottom: 7px;">
        @if ($errors->has('name'))
            <div class="text-danger">{{ $errors->first('name') }}</div>
        @endif
    </div>
    <div>
        <label style="display: block; margin-bottom: 5px;" class="my-font-weight">e-mail:</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" style="width: 200px; margin-bottom: 7px;">
        @if ($errors->has('email'))
            <div class="text-danger">{{ $errors->first('email') }}</div>
        @endif
    </div>
    <div>
        <label style="display: block; margin-bottom: 5px;" class="my-font-weight">Новий пароль:</label>
        <input type="password" name="password"  style="width: 200px; margin-bottom: 7px;">
        @if ($errors->has('password'))
            <div class="text-danger">{{ $errors->first('password') }}</div>
        @endif
    </div>
    <div>
        <label style="display: block; margin-bottom: 5px;" class="my-font-weight">Повторіть новий пароль:</label>
        <input type="password" name="password_confirmation"  style="width: 200px; margin-bottom: 15px;">
    </div>
    <button type="submit" class="btn btn-primary mb-3">Зберегти</button>
</form>

@endsection

