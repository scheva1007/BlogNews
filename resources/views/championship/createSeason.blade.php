@extends('layout.app')

@section('content')

    <form method="post" action="{{ route('championship.storeSeason') }}" style="width: 300px;">
        @csrf
        <div class="form-group">
            <label class="my-font-weight" style="display: block; margin-bottom: 8px;">Чемпіонат</label>
            <select name="championship_id" class="form-control">
                <option value="">Оберіть чемпіонат</option>
                    @foreach($championships as $championship)
                <option value="{{ $championship->id }}">{{ $championship->name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="form-group mt-3" >
            <label class="my-font-weight" style="display: block; margin-bottom: 8px;">Назва сезону</label>
            <input type="text" name="season" class="form-control">
        </div>
        <div class="form-group mt-3">
            <label class="my-font-weight" style="display: block; margin-bottom: 8px;">Оберіть команди</label>
            @foreach($championships as $championship)
               <div class="championship-teams d-none" data-id="{{ $championship->id }}">
                   @foreach($championship->teams as $team)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="teams[]" value="{{ $team->id }}">
                            <label class="form-check-label">{{ $team->name }}</label>
                        </div>
                   @endforeach
               </div>
            @endforeach
            <button type="submit" class="btn btn-primary mt-3">Зберегти</button>
        </div>
    </form>
    <script>
        const select = document.querySelector('[name="championship_id"]');
        const allGroups = document.querySelectorAll('.championship-teams');

        select.addEventListener('change', function () {
            allGroups.forEach(g => g.classList.add('d-none'));
            const selected = document.querySelector(`.championship-teams[data-id="${this.value}"]`);
            if (selected) selected.classList.remove('d-none');
        });
    </script>
@endsection
