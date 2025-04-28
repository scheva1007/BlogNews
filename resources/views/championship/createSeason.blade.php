@extends('layout.app')

@section('content')
    <form method="post" action="{{ route('championship.storeSeason') }}" style="width: 300px;">
        @csrf

        <div class="form-group">
            <label class="my-font-weight" style="display: block; margin-bottom: 5px;">Чемпіонат</label>
            <select name="championship_id" id="championship" class="form-control">
                <option value="">Оберіть чемпіонат</option>
                @foreach($championships as $championship)
                    <option value="{{ $championship->id }}" data-country="{{ $championship->country }}">
                        {{ $championship->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label class="my-font-weight" style="display: block; margin-bottom: 5px;">Назва сезону</label>
            <input type="text" name="season" class="form-control">
        </div>

        <div class="form-group mt-3">
            <label class="my-font-weight" style="display: block; margin-bottom: 5px;">Оберіть команди</label>
            @foreach($teams as $country => $teamsGroup)
                <div class="team-group d-none" data-country="{{ $country }}">
                    @foreach($teamsGroup as $team)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="teams[]" value="{{ $team->id }}">
                            <label class="form-check-label">{{ $team->name }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">Зберегти</button>
    </form>
    <script>
        document.getElementById('championship').addEventListener('change', function () {
            const selectedCountry = this.options[this.selectedIndex].dataset.country;

            document.querySelectorAll('.team-group').forEach(group => {
                if (group.dataset.country === selectedCountry) {
                    group.classList.remove('d-none');
                } else {
                    group.classList.add('d-none');
                }
            });
        });
    </script>
@endsection
