@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="mb-6 text-3xl font-bold text-blue-700">Modifier le rendez-vous</h1>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="space-y-6 bg-white p-6 shadow rounded-lg">
        @csrf
        @method('PUT')

        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Patient</label>
            <select name="user_id" id="user_id" class="w-full mt-1 p-2 border rounded-md" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $appointment->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="doctor_id" class="block text-sm font-medium text-gray-700">Médecin</label>
            <select name="doctor_id" id="doctor_id" class="w-full mt-1 p-2 border rounded-md" required>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="consultation_type" class="block text-sm font-medium text-gray-700">Type de consultation</label>
            <select name="consultation_type" id="consultation_type" class="w-full mt-1 p-2 border rounded-md" required>
                <option value="généraliste" {{ $appointment->consultation_type == 'généraliste' ? 'selected' : '' }}>Généraliste</option>
                <option value="spécialiste" {{ $appointment->consultation_type == 'spécialiste' ? 'selected' : '' }}>Spécialiste</option>
                <option value="suivi" {{ $appointment->consultation_type == 'suivi' ? 'selected' : '' }}>Suivi</option>
            </select>
        </div>

        <div>
            <label for="date_heure" class="block text-sm font-medium text-gray-700">Date et Heure</label>
            <input type="datetime-local" name="date_heure" id="date_heure" class="w-full mt-1 p-2 border rounded-md" value="{{ date('Y-m-d\TH:i', strtotime($appointment->date_heure)) }}" required>
        </div>

        <div>
            <label for="comment" class="block text-sm font-medium text-gray-700">Commentaire</label>
            <textarea name="comment" id="comment" class="w-full mt-1 p-2 border rounded-md">{{ $appointment->comment }}</textarea>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md shadow hover:bg-gray-700 transition duration-300">Mettre à jour</button>
            <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600 transition duration-300">Annuler</a>
        </div>
    </form>
</div>
@endsection
