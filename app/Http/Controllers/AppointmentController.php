<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function index()
    {
        $appointments = Appointment::with(['user', 'doctor'])->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $user = auth()->user(); 
        $doctors = Doctor::all(); 
        return view('appointments.create', compact('user', 'doctors'));
    }
    


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'consultation_type' => 'required|in:généraliste,spécialiste,suivi',
            'date_heure' => 'required|date|after:now',
            'comment' => 'nullable|string',
        ]);

        Appointment::create($request->all());

        return redirect()->route('appointments.index')
        ->with('success', 'Rendez-vous créé avec succès.');
    }


    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }


    public function edit(Appointment $appointment)
    {
        $users = User::all();
        $doctors = Doctor::all();
        return view('appointments.edit', compact('appointment', 'users', 'doctors'));
    }


    public function update(Request $request, Appointment $appointment)
    {
        if ($request->has('statut')) {
            $appointment->update([
                'statut' => $request->input('statut'),
            ]);
            return redirect()->route('appointments.myAppointments')
                            ->with('success', 'Statut du rendez-vous mis à jour avec succès.');
        }
    
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'consultation_type' => 'required|in:généraliste,spécialiste,suivi',
            'date_heure' => 'required|date|after:now',
            'comment' => 'nullable|string',
        ]);
    
        $appointment->update($request->all());
    
        return redirect()->route('appointments.index')
                        ->with('success', 'Rendez-vous mis à jour avec succès.');
    }
    

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
        ->with('success', 'Rendez-vous supprimé avec succès.');
    }

    public function myAppointments()
{
    $userId = auth()->id();
    $appointments = Appointment::where('user_id', $userId)
                                ->orderBy('date_heure', 'asc')
                                ->get();

    return view('appointments.myAppointments', compact('appointments'));
}

}
