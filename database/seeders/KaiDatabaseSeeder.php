<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaiDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Tenants ───────────────────────────────────────────
        DB::table('tenants')->updateOrInsert(
            ['id' => 1],
            [
                'fullname'         => 'MARDIYAH',
                'status_customer'  => 'Swasta',
                'jenis_perusahaan' => 'Perorangan',
                'brand'            => '(kosong)',
                'created_at'       => now(),
            ]
        );

        DB::table('tenants')->updateOrInsert(
            ['id' => 2],
            [
                'fullname'         => 'ARIF KHUZAINI',
                'status_customer'  => 'Swasta',
                'jenis_perusahaan' => 'Perorangan',
                'brand'            => '(kosong)',
                'created_at'       => now(),
            ]
        );

        // ── 2. Assets ────────────────────────────────────────────
        DB::table('assets')->updateOrInsert(
            ['asset_number' => '04.01.00764'],
            [
                'asset_block_name' => 'LAHAN BARU BLOK B PEKALONGAN',
                'sub_title'        => 'Pekalongan Barat, Kota Pekalongan',
                'description'      => 'Aset Lahan Komersial KAI Daop 4 Pekalongan',
                'size_area'        => 50.00,
                'peruntukan'       => 'Tanah',
                'jenis_asset'      => 'Tanah',
                'stasiun'          => 'Pekalongan',
                'wilayah_asset'    => 'Daop 4 Semarang',
                'latitude'         => -6.88620000,
                'longitude'        => 109.67380000,
                'images'           => json_encode([]),
                'created_at'       => now(),
            ]
        );

        // ── 3. Contracts ─────────────────────────────────────────
        DB::table('contracts')->updateOrInsert(
            ['contract_number' => '0005/51116/D.4/941/PK/TN/XII/2016'],
            [
                'tenant_id'            => 1,
                'asset_number'         => '04.01.00764',
                'contract_date'        => '42710',
                'jenis_kontrak'        => 'Kontrak Sewa',
                'area_kontrak'         => 'Non Row',
                'start_datetime'       => '2016-01-01',
                'end_datetime'         => '2017-12-31',
                'start_datetime_baru'  => '2018-01-01',
                'end_datetime_baru'    => '2026-12-31',
                'price'                => 2264394.00,
                'spv'                  => 'Sales Executive Area 1 Pekalongan',
                'asset_block_name'     => 'SEKITAR 2+1/200 LINTAS NON OPERASI - WONOPRINGGO KEL. TEGALREJO RT/RW.01/02 KEC. PEKALONGAN BARAT KOTA PEKALONGAN (5/51116/PK/TN/941)',
                'size_area'            => 42.00,
                'peruntukan'           => 'Tanah',
                'keterangan'           => 'Pendapatan Sewa Tanah Non Row',
                'created_at'           => now(),
            ]
        );

        DB::table('contracts')->updateOrInsert(
            ['contract_number' => '0004/51116/D.4/941/PK/TN/XI/2016'],
            [
                'tenant_id'            => 2,
                'asset_number'         => '04.01.00764',
                'contract_date'        => '42678',
                'jenis_kontrak'        => 'Kontrak Sewa',
                'area_kontrak'         => 'Daop 4 Semarang',
                'start_datetime'       => '2016-04-01',
                'end_datetime'         => '2018-08-31',
                'start_datetime_baru'  => '2018-09-01',
                'end_datetime_baru'    => '2026-12-31',
                'price'                => 1887604.00,
                'spv'                  => 'Sales Executive Area 1 Pekalongan',
                'asset_block_name'     => 'SEKITAR KM. 2+533 S.D KM. 3+533 KEL. PRINGREJO KEC. PEKALONGAN BARAT KOTA PEKALONGAN LINTAS NON OPERASI PEKALONGAN - WONOSOBO (4/51116/PK/TN/941)',
                'size_area'            => 43.50,
                'peruntukan'           => 'RUMAH TINGGAL',
                'keterangan'           => 'RKA',
                'created_at'           => now(),
            ]
        );

        // ── 4. Contract Financials ───────────────────────────────
        DB::table('contract_financials')->updateOrInsert(
            ['contract_number' => '0005/51116/D.4/941/PK/TN/XII/2016'],
            [
                'jumlah_hari'      => 730,
                'nilai_per_hari'   => 3102.00,
                'awal'             => '2026-01-01',
                'akhir'            => '2026-12-31',
                'hari_2026'        => 365,
                'nilai_2026'       => 1132197.00,
                'nilai_backlog'    => 9063780.00,
                'nilai_backlog2'   => 9402819.00,
                'gl_account'       => '3421190010',
                'form_rka'         => 'RKA',
                'tahun_rka'        => 2026,
                'jenis_pendapatan' => 'Pendapatan Non Angkutan',
                'persentase'       => 0.90,
                'pencapaian'       => 0.90,
                'ket'              => 'AKTIF',
            ]
        );

        DB::table('contract_financials')->updateOrInsert(
            ['contract_number' => '0004/51116/D.4/941/PK/TN/XI/2016'],
            [
                'jumlah_hari'      => 882,
                'nilai_per_hari'   => 2140.00,
                'awal'             => '2026-01-01',
                'akhir'            => '2026-12-31',
                'hari_2026'        => 365,
                'nilai_2026'       => 781151.00,
                'nilai_backlog'    => 5733437.00,
                'nilai_backlog2'   => 6019359.00,
                'gl_account'       => '3421190010',
                'form_rka'         => 'RKA',
                'tahun_rka'        => 2026,
                'jenis_pendapatan' => 'Pendapatan Non Angkutan',
                'persentase'       => 0.90,
                'pencapaian'       => 0.90,
                'ket'              => 'AKTIF',
            ]
        );

        // ── 5. Monthly Schedules ─────────────────────────────────
        DB::table('monthly_schedules')->updateOrInsert(
            ['contract_number' => '0005/51116/D.4/941/PK/TN/XII/2016', 'tahun' => 2026],
            [
                'invoice'         => 'SUDAH TERBIT',
                'januari'         => 105775.00,
                'febuari'         => 95539.00,
                'maret'           => 105775.00,
                'april'           => 102363.00,
                'mei'             => 105775.00,
                'juni'            => 102363.00,
                'juli'            => 105775.00,
                'agustus'         => 105775.00,
                'september'       => 102363.00,
                'oktober'         => 105775.00,
                'november'        => 102363.00,
                'desember'        => 105775.00,
                'jan_des'         => 1245417.00,
            ]
        );

        DB::table('monthly_schedules')->updateOrInsert(
            ['contract_number' => '0004/51116/D.4/941/PK/TN/XI/2016', 'tahun' => 2026],
            [
                'invoice'         => 'SUDAH TERBIT',
                'januari'         => 72979.00,
                'febuari'         => 65916.00,
                'maret'           => 72979.00,
                'april'           => 70625.00,
                'mei'             => 72979.00,
                'juni'            => 70625.00,
                'juli'            => 72979.00,
                'agustus'         => 72979.00,
                'september'       => 70625.00,
                'oktober'         => 72979.00,
                'november'        => 70625.00,
                'desember'        => 72979.00,
                'jan_des'         => 859266.00,
            ]
        );
    }
}
