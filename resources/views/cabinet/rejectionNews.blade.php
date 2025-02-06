@extends('layout.app')

@section('content')

    @if($rejectionNews->isEmpty())
    <p>У вас немає статей, що не пройшли перевірку</p>
    @else
        @foreach($rejectionNews as $item)
        <div style="margin-bottom: 30px;">
            <h5><a href="{{ route('cabinet.editUnapprovedNews', $item) }}">{{ $item->title }}</a></h5>
            @if($item->rejection_reason)
                <span style="margin-right: 15px;  font-weight: bold;">Причина відмови:</span>{{ $item->rejection_reason }}
            @endif
         </div>
        @endforeach
    @endif
    <div class="mt-3 mb-3">{{ $rejectionNews->links() }}</div>
@endsection
