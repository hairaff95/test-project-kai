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
        // 1. Tabel Tenants
        Schema::create('tenants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname', 255);
            $table->string('status_customer', 50);
            $table->string('jenis_perusahaan', 50);
            $table->string('brand', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // 2. Tabel Contracts
        Schema::create('contracts', function (Blueprint $table) {
            $table->string('contract_number', 100)->primary();
            $table->unsignedInteger('tenant_id');
            $table->string('asset_number', 100)->nullable();
            $table->string('contract_date', 100)->nullable();
            $table->string('jenis_kontrak', 100)->nullable();
            $table->string('area_kontrak', 100)->nullable();
            $table->date('start_datetime')->nullable();
            $table->date('end_datetime')->nullable();
            $table->date('start_datetime_baru')->nullable();
            $table->date('end_datetime_baru')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->string('spv', 150)->nullable();
            $table->text('asset_block_name')->nullable();
            $table->decimal('size_area', 10, 2)->nullable();
            $table->string('peruntukan', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('asset_number')->references('asset_number')->on('assets')->cascadeOnDelete()->cascadeOnUpdate();
        });

        // 3. Tabel Contract Financials
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

        // 4. Tabel Monthly Schedules
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
        Schema::dropIfExists('monthly_schedules');
        Schema::dropIfExists('contract_financials');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('tenants');
    }
};
