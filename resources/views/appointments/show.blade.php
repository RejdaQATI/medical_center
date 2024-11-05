@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du rendez-vous</h1>

    <div class="mb-3">
        <strong>Patient :</strong> {{ $appointment->user->name }}
    </div>
    <div class="mb-3">
        <strong>Médecin :</strong> {{ $appointment->doctor->name }}
    </div>
    <div class="mb-3">
        <strong>Type de consultation :</strong> {{ $appointment->consultation_type }}
    </div>
    <div class="mb-3">
        <strong>Date et Heure :</strong> {{ $appointment->date_heure }}
    </div>
    <div class="mb-3">
        <strong>Commentaire :</strong> {{ $appointment->comment ?? 'Aucun' }}
    </div>

    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
