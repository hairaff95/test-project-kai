<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->string('asset_number', 100)->primary();
            $table->string('asset_block_name', 255)->nullable();
            $table->string('sub_title', 255)->nullable();
            $table->text('description')->nullable();
            $table->decimal('size_area', 10, 2)->nullable();
            $table->string('peruntukan', 100)->nullable();
            $table->string('jenis_asset', 100)->nullable();
            $table->string('stasiun', 100)->nullable();
            $table->string('wilayah_asset', 100)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('images')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
