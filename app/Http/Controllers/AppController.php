<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\GuestCheckin;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function dashboard()
    {
        $totalTamu = Guest::count();

        $tamuHadir = GuestCheckin::count();

        $belumHadir = $totalTamu - $tamuHadir;

        $persen = $totalTamu > 0
            ? round(($tamuHadir / $totalTamu) * 100)
            : 0;

        $recentGuests = GuestCheckin::with('guest.kategori')
            ->latest()
            ->limit(10)
            ->get();

        $kedatangan = GuestCheckin::selectRaw('HOUR(waktu_checkin) as jam, COUNT(*) as total')
            ->groupBy('jam')
            ->orderBy('jam')
            ->get();

        $chartJam = [];
        $chartTotal = [];

        foreach ($kedatangan as $row) {
            $chartJam[] = $row->jam . ":00";
            $chartTotal[] = $row->total;
        }

        return view('modules.dashboard', compact(
            'totalTamu',
            'tamuHadir',
            'belumHadir',
            'persen',
            'recentGuests',
            'chartJam',
            'chartTotal'
        ));
    }
}
