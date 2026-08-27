<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaiDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Penyewa ────────────────────────────────────────────
        DB::table('penyewa')->insert([
            ['id' => 1, 'fullnama' => 'PT Kargo Cepat Pantura',     'status_pelanggan' => 'Aktif',  'jenis_perusahaan' => 'PT',  'merek' => 'KCP Logistics',     'dibuat_pada' => now()],
            ['id' => 2, 'fullnama' => 'Drs. Bambang Sudarsono',      'status_pelanggan' => 'Aktif',  'jenis_perusahaan' => 'Perorangan', 'merek' => '-',           'dibuat_pada' => now()],
            ['id' => 3, 'fullnama' => 'CV Sumber Rejeki Semarang',   'status_pelanggan' => 'Aktif',  'jenis_perusahaan' => 'CV',  'merek' => 'Sumber Rejeki',     'dibuat_pada' => now()],
        ]);

        // ── Assets ─────────────────────────────────────────────
        DB::table('assets')->insert([
            [
                'asset_number'     => 'AST-SMG-PCL-005',
                'asset_block_name' => 'PT Kargo Cepat Pantura',
                'size_area'        => 850.00,
                'peruntukan'       => 'Depo Logistik & Kantor Ekspedisi',
                'jenis_aset'       => 'Tanah',
                'stasiun'          => 'Semarang Poncol',
                'wilayah_aset'     => 'Daop 4 Semarang',
                'latitude'         => -6.96970000,
                'longitude'        => 110.41370000,
                'created_at'       => now(),
            ],
            [
                'asset_number'     => 'AST-TGL-GDG-002',
                'asset_block_name' => 'Gudang Logistik Tegal Timur',
                'size_area'        => 2462.00,
                'peruntukan'       => 'Gudang Logistik Komersial & Pergudangan Pelabuhan',
                'jenis_aset'       => 'Bangunan Dinas',
                'stasiun'          => 'Tegal',
                'wilayah_aset'     => 'Daop 4 Semarang',
                'latitude'         => -6.87900000,
                'longitude'        => 109.12500000,
                'created_at'       => now(),
            ],
            [
                'asset_number'     => 'AST-SMG-TWG-001',
                'asset_block_name' => 'Eks Gudang Kaligawe',
                'size_area'        => 2500.00,
                'peruntukan'       => 'Pergudangan & Industri Ringan',
                'jenis_aset'       => 'Gudang',
                'stasiun'          => 'Semarang Tawang',
                'wilayah_aset'     => 'Daop 4 Semarang',
                'latitude'         => -6.95530000,
                'longitude'        => 110.45610000,
                'created_at'       => now(),
            ],
        ]);

        // ── Contracts ──────────────────────────────────────────
        DB::table('contracts')->insert([
            [
                'contract_number'      => 'KTR-2026-SMG-PCL-001',
                'tenant_id'            => 1,
                'asset_number'         => 'AST-SMG-PCL-005',
                'contract_date'        => '2026-01-01',
                'jenis_kontrak'        => 'Baru',
                'area_kontrak'         => 'Non Row',
                'start_datetime'       => '2026-01-01',
                'end_datetime'         => '2027-12-31',
                'start_datetime_baru'  => '2026-01-01',
                'end_datetime_baru'    => '2027-12-31',
                'price'                => 380000000.00,
                'spv'                  => 'SPV Komersial Daop 4',
                'keterangan'           => 'Aset lahan pergudangan sisi timur stasiun Poncol',
                'created_at'           => now(),
            ],
            [
                'contract_number'      => 'KTR-2026-TGL-GDG-001',
                'tenant_id'            => 2,
                'asset_number'         => 'AST-TGL-GDG-002',
                'contract_date'        => '2026-01-21',
                'jenis_kontrak'        => 'Perpanjangan',
                'area_kontrak'         => 'Row',
                'start_datetime'       => '2026-01-21',
                'end_datetime'         => '2026-12-31',
                'start_datetime_baru'  => '2026-01-21',
                'end_datetime_baru'    => '2026-12-31',
                'price'                => 970028000.00,
                'spv'                  => 'SPV Komersial & Non Angkutan Daop 4',
                'keterangan'           => 'Kawasan strategis dekat pusat niaga Tegal',
                'created_at'           => now(),
            ],
        ]);

        // ── Contract Financials ────────────────────────────────
        DB::table('contract_financials')->insert([
            [
                'id'               => 1,
                'contract_number'  => 'KTR-2026-SMG-PCL-001',
                'jumlah_hari'      => 730,
                'nilai_per_hari'   => 520547.95,
                'awal'             => '2026-01-01',
                'akhir'            => '2027-12-31',
                'hari_2026'        => 365,
                'nilai_2026'       => 190000000.00,
                'nilai_backlog'    => 0.00,
                'nilai_backlog2'   => 0.00,
                'gl_account'       => '411101 - Sewa Tanah ROW',
                'form_rka'         => 'RKA',
                'tahun_rka'        => 2026,
                'jenis_pendapatan' => 'Row',
                'persentase'       => 100.00,
                'pencapaian'       => 75.00,
                'ket'              => 'Berjalan normal',
            ],
            [
                'id'               => 2,
                'contract_number'  => 'KTR-2026-TGL-GDG-001',
                'jumlah_hari'      => 344,
                'nilai_per_hari'   => 2820430.23,
                'awal'             => '2026-01-21',
                'akhir'            => '2026-12-31',
                'hari_2026'        => 344,
                'nilai_2026'       => 970028000.00,
                'nilai_backlog'    => 0.00,
                'nilai_backlog2'   => 0.00,
                'gl_account'       => '411102 - Sewa Bangunan',
                'form_rka'         => 'RKA',
                'tahun_rka'        => 2026,
                'jenis_pendapatan' => 'Non Row',
                'persentase'       => 100.00,
                'pencapaian'       => 60.00,
                'ket'              => 'Perpanjangan tahun ke-2',
            ],
        ]);

        // ── Monthly Schedules ──────────────────────────────────
        DB::table('monthly_schedules')->insert([
            [
                'id'              => 1,
                'contract_number' => 'KTR-2026-TGL-GDG-001',
                'tahun'           => 2026,
                'invoice'         => 'INV-2026-001',
                'januari'         => 26920637.00,
                'febuari'         => 26920637.00,
                'maret'           => 26920637.00,
                'april'           => 26920637.00,
                'mei'             => 26920637.00,
                'juni'            => 26920637.00,
                'juli'            => 26920637.00,
                'agustus'         => 26920637.00,
                'september'       => 26920637.00,
                'oktober'         => 26920637.00,
                'november'        => 26920637.00,
                'desember'        => 26920637.00,
                'jan_des'         => 323047644.00,
            ],
        ]);
    }
}
