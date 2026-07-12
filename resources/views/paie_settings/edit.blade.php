@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Paramètres de Paie</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('paie.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Méthode de calcul</label>
            <select name="calculation_method" class="form-control">
                <option value="pro_rata" {{ (old('calculation_method', $settings->calculation_method ?? '')=='pro_rata') ? 'selected' : '' }}>Pro rata (jours)</option>
                <option value="hours" {{ (old('calculation_method', $settings->calculation_method ?? '')=='hours') ? 'selected' : '' }}>Par heures</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jours travail par mois</label>
            <input type="number" name="jours_travail_par_mois" class="form-control" value="{{ old('jours_travail_par_mois', $settings->jours_travail_par_mois ?? 22) }}" />
        </div>

        <div class="mb-3">
            <label class="form-label">Heures par jour</label>
            <input type="number" name="heures_par_jour" class="form-control" value="{{ old('heures_par_jour', $settings->heures_par_jour ?? 8) }}" />
        </div>

        <div class="mb-3">
            <label class="form-label">Multiplicateur heures sup</label>
            <input type="text" name="overtime_multiplier" class="form-control" value="{{ old('overtime_multiplier', $settings->overtime_multiplier ?? 1.5) }}" />
        </div>

        <button class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
