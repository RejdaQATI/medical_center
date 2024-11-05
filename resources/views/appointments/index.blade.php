@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center text-primary">Liste des rendez-vous</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="lead">Gérez facilement vos rendez-vous ci-dessous :</p>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary shadow-sm">Créer un nouveau rendez-vous</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Patient</th>
                    <th scope="col">Médecin</th>
                    <th scope="col">Type de consultation</th>
                    <th scope="col">Date et Heure</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->user->name }}</td>
                        <td>{{ $appointment->doctor->name }}</td>
                        <td>
                            <span class="badge 
                                @if ($appointment->consultation_type == 'généraliste') bg-primary 
                                @elseif ($appointment->consultation_type == 'spécialiste') bg-success 
                                @else bg-warning 
                                @endif">
                                {{ $appointment->consultation_type }}
                            </span>
                        </td>
                        <td>{{ $appointment->date_heure }}</td>
                        <td class="text-center">
                            <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-info btn-sm me-1">Voir</a>
                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm me-1">Modifier</a>
                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
