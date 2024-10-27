
@extends('layout.app')

@section('content')

<div style="margin-bottom: 40px;">
    <a href="{{ route('cabinet.edit', $user->id) }}" class="btn btn-primary" style="margin-top: 30px;">Редагувати профіль</a>
</div>
@if ($user && ($user->isAdmin() || $user->isAuthor()))
<div>
<a href="{{ route('cabinet.publications', $user->id) }}" class="btn btn-secondary" style="margin-bottom: 40px;">Мої публікації</a>
</div>
    <div >
        <a href="{{ route('cabinet.unapprovedNews', $user->id) }}" class="btn btn-warning" >Статті на доопрацювання</a>
    </div>
    @endif
@endsection
