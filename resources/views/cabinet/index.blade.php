
@extends('layout.app')

@section('content')
    @php
        $user = auth()->user();
    @endphp
<div class="d-flex align-items-start">
<div style="margin-right: 30px; margin-top: 30px;">
    <a href="{{ route('cabinet.edit') }}" class="btn btn-primary">Редагувати профіль</a>
</div>
@if ($user && ($user->isAdmin() || $user->isAuthor()))
<div style="margin-right: 30px; margin-top: 30px;">
<a href="{{ route('cabinet.publications') }}" class="btn btn-secondary">Мої публікації</a>
</div>
    <div style="margin-right: 30px; margin-top: 30px;">
        <a href="{{ route('cabinet.unapprovedNews', $user->id) }}" class="btn btn-warning">Статті на доопрацювання</a>
    </div>
<div style="margin-right: 30px; margin-top: 30px;">
    <a href="{{ route('cabinet.rejectionNews', $user->id) }}" class="btn btn-danger">Статті,що не пройшли перевірку</a>
</div>
</div>
    @endif
@endsection
