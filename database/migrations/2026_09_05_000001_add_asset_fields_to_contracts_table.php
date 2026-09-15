<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('asset_block_name', 255)->nullable()->after('asset_number');
            $table->decimal('size_area', 10, 2)->default(0)->after('asset_block_name');
            $table->string('peruntukan', 100)->nullable()->after('size_area');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['asset_block_name', 'size_area', 'peruntukan']);
        });
    }
};
