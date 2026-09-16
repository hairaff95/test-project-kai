<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            if (! Schema::hasColumn('contracts', 'asset_block_name')) {
                $table->string('asset_block_name', 255)->nullable()->after('asset_number');
            }
            if (! Schema::hasColumn('contracts', 'size_area')) {
                $table->decimal('size_area', 10, 2)->default(0)->after('asset_block_name');
            }
            if (! Schema::hasColumn('contracts', 'peruntukan')) {
                $table->string('peruntukan', 100)->nullable()->after('size_area');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('contracts', 'asset_block_name') ? 'asset_block_name' : null,
                Schema::hasColumn('contracts', 'size_area') ? 'size_area' : null,
                Schema::hasColumn('contracts', 'peruntukan') ? 'peruntukan' : null,
            ]));
        });
    }
};
