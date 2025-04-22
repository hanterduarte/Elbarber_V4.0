<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CashRegister;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Get today's appointments
        $todayAppointments = Appointment::with(['client', 'barber', 'service'])
            ->whereDate('start_time', $today)
            ->orderBy('start_time')
            ->get();

        // Get upcoming appointments
        $upcomingAppointments = Appointment::with(['client', 'barber', 'service'])
            ->whereDate('start_time', '>', $today)
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        // Get today's revenue
        $todayRevenue = Sale::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('total');

        // Get current cash register
        $currentCashRegister = CashRegister::whereNull('closed_at')
            ->with('user')
            ->first();

        // Get last closed cash register
        $lastClosedRegister = CashRegister::whereNotNull('closed_at')
            ->with(['user', 'closedByUser'])
            ->latest()
            ->first();

        return view('dashboard', compact(
            'todayAppointments',
            'upcomingAppointments',
            'todayRevenue',
            'currentCashRegister',
            'lastClosedRegister'
        ));
    }
}
