@extends('layout.app')

@section('content')

   <form action="{{ route('admin.updateMatch', ['matchId' => $matches->id]) }}" method="POST">
       @csrf
       @method('PUT')
            <div class="form-group">
                <label>Команда господарів:</label>
                <p><strong>{{ $matches->homeTeam->name }}</strong></p>
            </div>
            <div class="form-group">
                <label>М'ячі господарів:</label>
                <input type="number" name="home_score" class="form-control" value="{{ $matches->home_score }}" style="width: 300px; margin-bottom: 12px;">
            </div>
       <div class="form-group">
           <label>Команда гостей:</label>
           <p><strong>{{ $matches->awayTeam->name }}</strong></p>
       </div>
       <div class="form-group">
           <label>М'ячі гостей:</label>
           <input type="number" name="away_score" class="form-control" value="{{ $matches->away_score }}" style="width: 300px; margin-bottom: 12px;">
       </div>
       <div class="form-group">
           <label for="match_date" style="display: block; margin-bottom: 5px;">Дата матчу</label>
           <input type="datetime-local" name="match_date" id="match_date" class="form-control"
                  value="{{ \Carbon\Carbon::parse($matches->match_date)->format('Y-m-d\TH:i') }}"
                  style="width: 300px; margin-bottom: 12px;">
       </div>
       <div class="form-group">
           <label>Статус:</label>
           <select name="status" class="form-control" style="width: 300px; margin-bottom: 12px;">
               @foreach($statuses as $status => $item)
                   <option value="{{ $status }}">{{ $item }}</option>
               @endforeach
           </select>
       </div>
       <button type="submit" class="btn btn-success">Зберегти</button>
   </form>

@endsection
