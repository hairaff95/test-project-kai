<?php

namespace App\Http\Controllers;

use App\Models\KaiContract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $query = KaiContract::with(['penyewa', 'asset', 'financial'])->latest('created_at');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('contract_number', 'like', "%{$s}%")
                  ->orWhereHas('penyewa', fn($q2) => $q2->where('fullnama', 'like', "%{$s}%"))
                  ->orWhereHas('asset', fn($q2) => $q2->where('asset_block_name', 'like', "%{$s}%"));
            });
        }

        if ($request->filled('jenis_kontrak')) {
            $query->where('jenis_kontrak', $request->jenis_kontrak);
        }

        $contracts = $query->get();

        return view('contracts.index', compact('contracts'));
    }
}
