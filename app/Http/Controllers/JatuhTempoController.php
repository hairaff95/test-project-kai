<?php

namespace App\Http\Controllers;

use App\Models\KaiContract;
use Illuminate\Http\Request;

class JatuhTempoController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kontrak yang akan jatuh tempo dalam 6 bulan ke depan, diurutkan paling dekat
        $contracts = KaiContract::with(['penyewa', 'asset'])
            ->whereNotNull('end_datetime_baru')
            ->where('end_datetime_baru', '>=', now())
            ->where('end_datetime_baru', '<=', now()->addMonths(6))
            ->orderBy('end_datetime_baru', 'asc')
            ->get();

        // Jika belum ada data, tampilkan semua kontrak
        if ($contracts->isEmpty()) {
            $contracts = KaiContract::with(['penyewa', 'asset'])
                ->orderBy('end_datetime_baru', 'asc')
                ->get();
        }

        return view('jatuh-tempo.index', compact('contracts'));
    }
}
