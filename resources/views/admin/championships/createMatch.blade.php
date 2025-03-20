@extends('layout.app')

@section('content')
    <div class="container">
    <form method="post" action="{{ route('admin.storeMatch') }}">
        @csrf
        <label style="display: block; margin-bottom: 5px;">Чемпіонат:</label>
        <select name="championship_id" class="form-control" style="width: 300px; margin-bottom: 12px;">
            @foreach ($championships as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <label>Тур:</label>
        <input type="number" name="round" class="form-control" style="width: 300px; margin-bottom: 12px;">

        <label style="display: block; margin-bottom: 5px;">Команда господарів:</label>
        <input type="text" id="homeTeamSearch" list="homeTeams" placeholder="введіть назву команди"
               class="form-control" style="width: 300px; margin-bottom: 8px;">
        <datalist id="homeTeams"></datalist>
        <input type="hidden" name="home_team_id" id="homeTeamId">

        <label>Господарі забили:</label>
        <input type="number" name="home_score" class="form-control" style="width: 300px; margin-bottom: 12px;">

        <label style="display: block; margin-bottom: 5px;">Команда гостей:</label>
        <input type="text" id="awayTeamSearch" list="awayTeams" placeholder="введіть назву команди"
               class="form-control" style="width: 300px; margin-bottom: 8px;">
        <datalist id="awayTeams"></datalist>
        <input type="hidden" name="away_team_id" id="awayTeamId">

        <label>Гості забили:</label>
        <input type="number" name="away_score" class="form-control" style="width: 300px; margin-bottom: 12px;">


        <label style="display: block; margin-bottom: 5px;">Дата матчу:</label>
        <input type="datetime-local" name="match_date" class="form-control" style="width: 300px; margin-bottom: 12px;">

        <label>Статус:</label>
        <select name="status" class="form-control" style="width: 300px; margin-bottom: 12px;">
            @foreach($statuses as $status => $item)
                <option value="{{ $status }}">{{ $item }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-success mt-3">Зберегти</button>
    </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const championshipSelect = document.querySelector('select[name="championship_id"]');
            const homeTeamSearch = document.getElementById('homeTeamSearch');
            const awayTeamSearch = document.getElementById('awayTeamSearch');
            const homeTeamIdInput = document.getElementById('homeTeamId');
            const awayTeamIdInput = document.getElementById('awayTeamId');
            const homeTeamsDatalist = document.getElementById('homeTeams');
            const awayTeamsDatalist = document.getElementById('awayTeams');

            let teams = [];

            function loadTeams(championshipId) {
                if (!championshipId) return;

                fetch(`/admin/teamsChampionship/${championshipId}`)
                    .then(response => response.json())
                    .then(data => {
                        teams = data;
                        console.log("Отримані команди:", teams);

                        // Очищаем список
                        homeTeamsDatalist.innerHTML = '';
                        awayTeamsDatalist.innerHTML = '';

                        // Добавляем команды в `datalist`
                        teams.forEach(team => {
                            let option1 = document.createElement('option');
                            option1.value = team.name;
                            homeTeamsDatalist.appendChild(option1);

                            let option2 = document.createElement('option');
                            option2.value = team.name;
                            awayTeamsDatalist.appendChild(option2);
                        });
                    })
                    .catch(error => console.error('Помилка:', error));
            }

            function filterTeams(inputElement, idInput) {
                const searchText = inputElement.value.toLowerCase();
                const matchedTeam = teams.find(team => team.name.toLowerCase() === searchText);

                if (matchedTeam) {
                    idInput.value = matchedTeam.id;
                } else {
                    idInput.value = '';
                }
            }

            championshipSelect.addEventListener('change', function () {
                loadTeams(this.value);
            });

            homeTeamSearch.addEventListener('input', function () {
                filterTeams(homeTeamSearch, homeTeamIdInput);
            });

            awayTeamSearch.addEventListener('input', function () {
                filterTeams(awayTeamSearch, awayTeamIdInput);
            });

            // Подгружаем команды при загрузке страницы
            loadTeams(championshipSelect.value);
        });
    </script>
    @endsection

