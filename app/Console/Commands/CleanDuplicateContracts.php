<?php

namespace App\Console\Commands;

use App\Models\KaiContract;
use App\Models\ContractFinancial;
use App\Models\MonthlySchedule;
use Illuminate\Console\Command;

class CleanDuplicateContracts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contracts:clean-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bersihkan data kontrak duplikat dari import ulang sehingga total kembali 575 data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $duplicates = KaiContract::whereDate('created_at', '2026-09-04')->get();
        $count = $duplicates->count();

        if ($count === 0) {
            $this->info("Tidak ada data duplikat yang ditemukan.");
            return 0;
        }

        $this->warn("Ditemukan {$count} data duplikat import dari tanggal 2026-09-04. Menghapus data...");

        foreach ($duplicates as $c) {
            ContractFinancial::where('contract_number', $c->contract_number)->delete();
            MonthlySchedule::where('contract_number', $c->contract_number)->delete();
            $c->delete();
        }

        $remaining = KaiContract::count();
        $this->info("Berhasil membersihkan {$count} data duplikat. Total data kontrak saat ini: {$remaining}.");

        return 0;
    }
}
