<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JatuhTempoController extends Controller
{
    public function index()
    {
        // Sample data for Jatuh Tempo page matching Figma design
        $contracts = [
            [
                'asset_no'         => 'AST-TGL-GDG-002',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-01-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '4 bulan lagi',
                'contract_status'  => '2 Kontrak',
                'overdue_class'    => 'normal',
            ],
            [
                'asset_no'         => 'AST-TGL-GDG-002',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-01-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '4 bulan lagi',
                'contract_status'  => '2 Kontrak',
                'overdue_class'    => 'normal',
            ],
            [
                'asset_no'         => 'AST-TGL-GDG-002',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-21-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '4 bulan lagi',
                'contract_status'  => '4 Kontrak',
                'overdue_class'    => 'normal',
            ],
            [
                'asset_no'         => 'AST-TGL-GDG-002',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-21-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '4 bulan lagi',
                'contract_status'  => '2 Kontrak',
                'overdue_class'    => 'normal',
            ],
            [
                'asset_no'         => 'AST-TGL-GDG-G82',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-21-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '4 bulan lagi',
                'contract_status'  => '4 Kontrak',
                'overdue_class'    => 'normal',
            ],
            [
                'asset_no'         => 'AST-TGL-GDG-002',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-21-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '4 bulan lagi',
                'contract_status'  => '4 Kontrak',
                'overdue_class'    => 'normal',
            ],
            [
                'asset_no'         => 'AST-TGL-GDG-002',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-21-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '4 bulan lagi',
                'contract_status'  => '4 Kontrak',
                'overdue_class'    => 'normal',
            ],
            [
                'asset_no'         => 'AST-TGL-GDG-002',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-21-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '4 bulan lagi',
                'contract_status'  => '4 Kontrak',
                'overdue_class'    => 'normal',
            ],
            [
                'asset_no'         => 'AST-TGL-GDG-002',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-21-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '4 bulan lagi',
                'contract_status'  => '4 Kontrak',
                'overdue_class'    => 'normal',
            ],
            [
                'asset_no'         => 'RAL-MAW-GGC-002',
                'tenant'           => 'Drs. Bambang Sudarsono',
                'asset_type'       => 'Bangunan Dinas',
                'start_date'       => '01-21-2026',
                'end_date'         => '12-31-2026',
                'contract_value'   => 'Rp 970.026.000',
                'due_date'         => '6 bulan lagi',
                'contract_status'  => '4 Kontrak',
                'overdue_class'    => 'normal',
            ],
        ];

        return view('jatuh-tempo', compact('contracts'));
    }
}
