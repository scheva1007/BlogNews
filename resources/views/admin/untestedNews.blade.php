@extends('layout.app')

@section('content')

<h4 style="margin-bottom: 20px;">Неперевірені публікації:</h4>
@foreach($untestedNews as $item)
    @if($item->photo)
        <div style="width: 170px; height: 130px; margin-right: 20px;">
            <img src="{{ asset('/storage/' . $item->photo) }}" alt="News Photo"
                 style="max-width: 170px; max-height: 130px; ">
        </div>
    @endif
    <div style="width: 50%; margin-top: 0;">
<h5>{{ $item->title }}</h5>
    <p>{{ $item->text }}</p>
        <div class="d-flex align-items-start" style="gap:20px;">
<form action="{{ route('admin.check', $item) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary mb-5">Схвалити</button>
</form>
        <form action="{{ route('admin.reject', $item) }}" method="POST" class="d-flex align-items-start">
            @csrf
            <button type="submit" class="btn btn-success">Відхилити</button>
            <div class="form-group" style="margin-left:20px;">
                <textarea name="rejection" id="rejection" class="form-control" placeholder="Причина відмови" style="width: 250px;" required></textarea>
            </div>
        </form>
        </div>
    </div>
@endforeach
<div class="mb-3 mt-3">{{ $untestedNews->links() }}</div>
@endsection
