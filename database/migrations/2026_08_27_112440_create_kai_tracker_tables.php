<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambahkan kolom pendukung KAI Tracker pada tabel assets jika belum ada
        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'asset_number')) {
                $table->string('asset_number', 100)->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('assets', 'asset_block_name')) {
                $table->string('asset_block_name', 255)->nullable()->after('asset_number');
            }
            if (!Schema::hasColumn('assets', 'size_area')) {
                $table->decimal('size_area', 10, 2)->nullable()->after('asset_block_name');
            }
            if (!Schema::hasColumn('assets', 'peruntukan')) {
                $table->string('peruntukan', 100)->nullable()->after('size_area');
            }
            if (!Schema::hasColumn('assets', 'jenis_aset')) {
                $table->string('jenis_aset', 100)->nullable()->after('peruntukan');
            }
            if (!Schema::hasColumn('assets', 'stasiun')) {
                $table->string('stasiun', 100)->nullable()->after('jenis_aset');
            }
            if (!Schema::hasColumn('assets', 'wilayah_aset')) {
                $table->string('wilayah_aset', 100)->nullable()->after('stasiun');
            }
            // Jadikan kolom katalog nullable agar data KAI bisa disimpan
            $table->string('asset_code')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('district_area')->nullable()->change();
            $table->text('full_address')->nullable()->change();
            $table->decimal('latitude', 10, 7)->nullable()->change();
            $table->decimal('longitude', 10, 7)->nullable()->change();
        });

        // 2. Tabel Penyewa
        Schema::create('penyewa', function (Blueprint $table) {
            $table->id();
            $table->string('fullnama', 255);
            $table->string('status_pelanggan', 50)->default('Aktif');
            $table->string('jenis_perusahaan', 100)->default('Perorangan');
            $table->string('merek', 150)->nullable()->default('-');
            $table->timestamp('dibuat_pada')->useCurrent();
        });

        // 3. Tabel Contracts
        Schema::create('contracts', function (Blueprint $table) {
            $table->string('contract_number', 100)->primary();
            $table->foreignId('tenant_id')->constrained('penyewa')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('asset_number', 100)->nullable()->index();
            $table->date('contract_date')->nullable();
            $table->string('jenis_kontrak', 100)->default('Baru');
            $table->string('area_kontrak', 100)->default('Non Row');
            $table->date('start_datetime')->nullable();
            $table->date('end_datetime')->nullable();
            $table->date('start_datetime_baru')->nullable();
            $table->date('end_datetime_baru')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->string('spv', 150)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // 4. Tabel Contract Financials
        Schema::create('contract_financials', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number', 100);
            $table->integer('jumlah_hari')->default(0);
            $table->decimal('nilai_per_hari', 15, 2)->default(0);
            $table->date('awal')->nullable();
            $table->date('akhir')->nullable();
            $table->integer('hari_2026')->default(0);
            $table->decimal('nilai_2026', 15, 2)->default(0);
            $table->decimal('nilai_backlog', 15, 2)->default(0);
            $table->decimal('nilai_backlog2', 15, 2)->default(0);
            $table->string('gl_account', 50)->nullable();
            $table->string('form_rka', 100)->nullable();
            $table->integer('tahun_rka')->default(2026);
            $table->string('jenis_pendapatan', 100)->nullable();
            $table->decimal('persentase', 5, 2)->default(0);
            $table->decimal('pencapaian', 5, 2)->default(0);
            $table->text('ket')->nullable();

            $table->foreign('contract_number')->references('contract_number')->on('contracts')->cascadeOnDelete()->cascadeOnUpdate();
        });

        // 5. Tabel Monthly Schedules
        Schema::create('monthly_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number', 100);
            $table->integer('tahun')->default(2026);
            $table->string('invoice', 100)->nullable();
            $table->decimal('januari', 15, 2)->default(0);
            $table->decimal('febuari', 15, 2)->default(0);
            $table->decimal('maret', 15, 2)->default(0);
            $table->decimal('april', 15, 2)->default(0);
            $table->decimal('mei', 15, 2)->default(0);
            $table->decimal('juni', 15, 2)->default(0);
            $table->decimal('juli', 15, 2)->default(0);
            $table->decimal('agustus', 15, 2)->default(0);
            $table->decimal('september', 15, 2)->default(0);
            $table->decimal('oktober', 15, 2)->default(0);
            $table->decimal('november', 15, 2)->default(0);
            $table->decimal('desember', 15, 2)->default(0);
            $table->decimal('jan_des', 15, 2)->default(0);

            $table->foreign('contract_number')->references('contract_number')->on('contracts')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kai_tracker_tables');
    }
};
