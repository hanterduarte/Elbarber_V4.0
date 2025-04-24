<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Client;
use App\Models\Service;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with([
            'client' => function($query) {
                $query->withTrashed();
            },
            'barber' => function($query) {
                $query->withTrashed();
            },
            'barber.user' => function($query) {
                $query->withTrashed();
            },
            'service' => function($query) {
                $query->withTrashed();
            }
        ])
        ->orderBy('start_time', 'desc')
        ->paginate(10);
        
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('is_active', true)->get();
        $barbers = Barber::where('is_active', true)->with('user')->get();
        $services = Service::where('is_active', true)->get();
        
        return view('appointments.create', compact('clients', 'barbers', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'barber_id' => 'required|exists:barbers,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        // Get the service to calculate end time and price
        $service = Service::findOrFail($validated['service_id']);
        
        // Calculate end time based on service duration
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);
        
        // Create appointment with calculated fields
        $appointment = Appointment::create([
            'client_id' => $validated['client_id'],
            'barber_id' => $validated['barber_id'],
            'service_id' => $validated['service_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $service->price,
            'notes' => $validated['notes'],
            'status' => 'scheduled'
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::with([
            'client' => function($query) {
                $query->withTrashed();
            },
            'barber' => function($query) {
                $query->withTrashed();
            },
            'barber.user' => function($query) {
                $query->withTrashed();
            },
            'service' => function($query) {
                $query->withTrashed();
            }
        ])->findOrFail($id);
        
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = Appointment::with(['client', 'barber.user', 'service'])
            ->findOrFail($id);
        $clients = Client::where('is_active', true)->get();
        $barbers = Barber::where('is_active', true)->with('user')->get();
        $services = Service::where('is_active', true)->get();
        
        return view('appointments.edit', compact('appointment', 'clients', 'barbers', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'barber_id' => 'required|exists:barbers,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled',
            'notes' => 'nullable|string'
        ]);

        // Get the service to calculate end time and price
        $service = Service::findOrFail($validated['service_id']);
        
        // Calculate end time based on service duration
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);
        
        // Update appointment with calculated fields
        $appointment->update([
            'client_id' => $validated['client_id'],
            'barber_id' => $validated['barber_id'],
            'service_id' => $validated['service_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $service->price,
            'status' => $validated['status'],
            'notes' => $validated['notes']
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }
}
