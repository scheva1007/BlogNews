@extends('layout.app')

@section('content')
    <div class="container">
    <form method="post" action="{{ route('admin.storeMatch') }}">
        @csrf
        <label style="display: block; margin-bottom: 5px;">Чемпіонат:</label>
        <select name="championship_id" class="form-control" style="width: 300px; margin-bottom: 12px;">
            @foreach ($championships as $id => $name)
                <option value="{{ $id }}" {{ old('championship_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        @error('championship_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label>Сезон:</label>
        <select name="season" id="seasonSelect" class="form-control" style="width: 300px; margin-bottom: 12px;">
            <option value="">Оберіть сезон</option>
        </select>
        @error('season')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label>Тур:</label>
        <input type="number" name="round" class="form-control" value="{{ old('round') }}" style="width: 300px; margin-bottom: 12px;">
        @error('round')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label style="display: block; margin-bottom: 5px;">Команда господарів:</label>
        <input type="text" id="homeTeamSearch" list="homeTeams" placeholder="введіть назву команди"
               class="form-control" style="width: 300px; margin-bottom: 8px;" autocomplete="off">
        <datalist id="homeTeams"></datalist>
        <input type="hidden" name="home_team_id" id="homeTeamId" value="{{ old('home_team_id') }}" required>
        @error('home_team_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label>Господарі забили:</label>
        <input type="number" name="home_score" class="form-control" value="{{ old('home_score') }}" style="width: 300px; margin-bottom: 12px;">
        @error('home_score')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label style="display: block; margin-bottom: 5px;">Команда гостей:</label>
        <input type="text" id="awayTeamSearch" list="awayTeams" placeholder="введіть назву команди"
               class="form-control" style="width: 300px; margin-bottom: 8px;" autocomplete="off">
        <datalist id="awayTeams"></datalist>
        <input type="hidden" name="away_team_id" id="awayTeamId" value="{{ old('away_team_id') }}" required>
        @error('away_team_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label>Гості забили:</label>
        <input type="number" name="away_score" class="form-control" value="{{ old('away_score') }}" style="width: 300px; margin-bottom: 12px;">
        @error('away_score')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label style="display: block; margin-bottom: 5px;">Дата матчу:</label>
        <input type="datetime-local" name="match_date" class="form-control" value="{{ old('match_date') }}" style="width: 300px; margin-bottom: 12px;">
        @error('match_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <label>Статус:</label>
        <select name="status" class="form-control" style="width: 300px; margin-bottom: 12px;">
            @foreach($statuses as $status => $item)
                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $item }}</option>
            @endforeach
        </select>
        @error('status')
        <div class="text-danger">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-success mt-3">Зберегти</button>
    </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const championshipSelect = document.querySelector('select[name="championship_id"]');
            const seasonSelect = document.getElementById('seasonSelect');
            const homeTeamSearch = document.getElementById('homeTeamSearch');
            const awayTeamSearch = document.getElementById('awayTeamSearch');
            const homeTeamIdInput = document.getElementById('homeTeamId');
            const awayTeamIdInput = document.getElementById('awayTeamId');
            const homeTeamsDatalist = document.getElementById('homeTeams');
            const awayTeamsDatalist = document.getElementById('awayTeams');

            let teams = [];

            championshipSelect.addEventListener('change', function () {
                const championshipId = this.value;
                homeTeamsDatalist.innerHTML = '';
                awayTeamsDatalist.innerHTML = '';
                homeTeamSearch.value = '';
                awayTeamSearch.value = '';
                homeTeamIdInput.value = '';
                awayTeamIdInput.value = '';
                teams = [];

                fetch(`/admin/seasons/${championshipId}`)
                    .then(response => response.json())
                    .then(data => {
                        seasonSelect.innerHTML = '<option value="">Оберіть сезон</option>';
                        data.forEach(season => {
                            const option = document.createElement('option');
                            option.value = season;
                            option.textContent = season;
                            seasonSelect.appendChild(option);
                        });
                    });
            });

            seasonSelect.addEventListener('change', function () {
                const championshipId = championshipSelect.value;
                const season = this.value;

                fetch(`/admin/teamsChampionship/${championshipId}/${season}`)
                    .then(response => response.json())
                    .then(data => {
                        teams = data;
                        homeTeamsDatalist.innerHTML = '';
                        awayTeamsDatalist.innerHTML = '';
                        teams.forEach(team => {
                            const option1 = document.createElement('option');
                            option1.value = team.name;
                            homeTeamsDatalist.appendChild(option1);

                            const option2 = document.createElement('option');
                            option2.value = team.name;
                            awayTeamsDatalist.appendChild(option2);
                        });
                    });
            });

            function filterTeams(inputElement, idInput) {
                const searchText = inputElement.value.toLowerCase();
                const matchedTeam = teams.find(team => team.name.toLowerCase() === searchText);
                idInput.value = matchedTeam ? matchedTeam.id : '';
            }

            homeTeamSearch.addEventListener('input', function () {
                filterTeams(homeTeamSearch, homeTeamIdInput);
            });

            awayTeamSearch.addEventListener('input', function () {
                filterTeams(awayTeamSearch, awayTeamIdInput);
            });
        });
    </script>
    @endsection

