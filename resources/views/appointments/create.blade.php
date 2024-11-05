@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="mb-6 text-3xl font-bold text-blue-700">Créer un rendez-vous</h1>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6 bg-white p-6 shadow rounded-lg">
        @csrf

        <div>
            <label for="user" class="block text-sm font-medium text-gray-700">Patient</label>
            <input type="text" class="w-full mt-1 p-2 border rounded-md bg-gray-100 text-gray-600" value="{{ $user->name }}" disabled>
            <input type="hidden" name="user_id" value="{{ $user->id }}">
        </div>

        <div>
            <label for="doctor_id" class="block text-sm font-medium text-gray-700">Médecin</label>
            <select name="doctor_id" id="doctor_id" class="w-full mt-1 p-2 border rounded-md" required>
                <option value="">Sélectionner un médecin</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="consultation_type" class="block text-sm font-medium text-gray-700">Type de consultation</label>
            <select name="consultation_type" id="consultation_type" class="w-full mt-1 p-2 border rounded-md" required>
                <option value="généraliste">Généraliste</option>
                <option value="spécialiste">Spécialiste</option>
                <option value="suivi">Suivi</option>
            </select>
        </div>

        <div>
            <label for="date_heure" class="block text-sm font-medium text-gray-700">Date et Heure</label>
            <input type="datetime-local" name="date_heure" id="date_heure" class="w-full mt-1 p-2 border rounded-md" required>
        </div>

        <div>
            <label for="comment" class="block text-sm font-medium text-gray-700">Commentaire</label>
            <textarea name="comment" id="comment" class="w-full mt-1 p-2 border rounded-md"></textarea>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md shadow hover:bg-gray-700 transition duration-300">Enregistrer</button>
            <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600 transition duration-300">Annuler</a>
        </div>
    </form>
</div>
@endsection
