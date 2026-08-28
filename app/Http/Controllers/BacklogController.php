<?php

namespace App\Http\Controllers;

use App\Models\KaiContract;
use App\Models\ContractFinancial;
use Illuminate\Http\Request;

class BacklogController extends Controller
{
    public function index(Request $request)
    {
        // Backlog = kontrak yang memiliki nilai_backlog > 0
        $items = KaiContract::with(['tenant', 'asset', 'financial'])
            ->whereHas('financial', fn($q) => $q->where('nilai_backlog', '>', 0))
            ->get();

        // Jika belum ada data backlog, tampilkan semua kontrak
        if ($items->isEmpty()) {
            $items = KaiContract::with(['tenant', 'asset', 'financial'])->get();
        }

        return view('backlog.index', compact('items'));
    }
}
