@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="mb-8 text-center text-4xl font-extrabold text-blue-700">Mes rendez-vous</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg" role="alert">
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <h2 class="mt-8 mb-4 text-3xl font-bold text-gray-800 border-b-2 border-blue-300 pb-2">Rendez-vous futurs</h2>
    @php
        $futurs = $appointments->filter(function($appointment) {
            return \Carbon\Carbon::parse($appointment->date_heure)->isFuture();
        });
    @endphp
    @if ($futurs->isEmpty())
        <p class="text-gray-600 italic">Aucun rendez-vous futur trouvé.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full table-auto bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Date et Heure</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Type de consultation</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Commentaire</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Statut</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($futurs as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $appointment->date_heure }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                    @if ($appointment->consultation_type == 'généraliste') bg-blue-100 text-blue-800
                                    @elseif ($appointment->consultation_type == 'spécialiste') bg-green-100 text-green-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $appointment->consultation_type }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $appointment->comment }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($appointment->statut) }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md shadow hover:bg-blue-700 transition duration-300">
                                    Modifier
                                </a>
                                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="statut" value="annulé">
                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-xs font-semibold rounded-md shadow hover:bg-red-700 transition duration-300 ml-2">
                                        Annuler
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <h2 class="mt-8 mb-4 text-3xl font-bold text-gray-800 border-b-2 border-green-300 pb-2">Rendez-vous en cours</h2>
    @php
        $enCours = $appointments->filter(function($appointment) {
            $startTime = \Carbon\Carbon::parse($appointment->date_heure);
            $endTime = $startTime->copy()->addHour(1); 
            return now()->between($startTime, $endTime);
        });
    @endphp
    @if ($enCours->isEmpty())
        <p class="text-gray-600 italic">Aucun rendez-vous en cours trouvé.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full table-auto bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Date et Heure</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Type de consultation</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Commentaire</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($enCours as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $appointment->date_heure }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $appointment->consultation_type }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $appointment->comment }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($appointment->statut) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <h2 class="mt-8 mb-4 text-3xl font-bold text-gray-800 border-b-2 border-red-300 pb-2">Rendez-vous passés</h2>
    @php
        $passes = $appointments->filter(function($appointment) {
            $endTime = \Carbon\Carbon::parse($appointment->date_heure)->addHour(); 
            return now()->isAfter($endTime);
        });
    @endphp
    @if ($passes->isEmpty())
        <p class="text-gray-600 italic">Aucun rendez-vous passé trouvé.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full table-auto bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Date et Heure</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Type de consultation</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Commentaire</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($passes as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $appointment->date_heure }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $appointment->consultation_type }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $appointment->comment }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($appointment->statut) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
