<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        // Sample contract data for UI presentation matching design
        $contracts = [
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
            [
                'tenant' => 'Drs. Bambang Sudarsono',
                'asset_no' => 'AST-TGL-GDG-002',
                'station' => 'Semarang Tawang',
                'asset_type' => 'Bangunan Dinas',
                'designation' => 'Gudang Logistik Komersil & Pergudangan Pelabuhan',
                'area' => '2.462',
                'contract_value' => 'Rp 970.028.000',
                'due_date' => '4 bulan 6 hari',
                'status' => 'Aktif/Terbit',
            ],
        ];

        return view('contracts', compact('contracts'));
    }
}
