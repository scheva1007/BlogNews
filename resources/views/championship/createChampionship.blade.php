@extends('layout.app')

@section('content')

 <form method="post" action="{{ route('championship.storeChampionship') }}" >
     @csrf
     <label class="my-font-weight"  style="display: block; margin-bottom: 8px;">Назва чемпіонату</label>
     <input type="text" name="name" required style="width: 300px; height: 30px; margin-bottom: 12px;">
     @error('name')
     <div class="alert alert-danger">{{ $message }}</div>
     @enderror
     <br>
     <label class="my-font-weight"  style="display: block; margin-bottom: 8px;">Країна</label>
     <input type="text" name="country" required style="width: 300px; height: 30px; margin-bottom: 12px;">
     @error('country')
     <div class="alert alert-danger">{{ $message }}</div>
     @enderror
     <br>
     <button type="submit" class="btn btn-primary mb-3">Зберегти</button>
 </form>

@endsection
