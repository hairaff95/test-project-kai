<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            // Jumlah request yang sudah dibuat dalam satu siklus (per user, reset saat approved/completed)
            $table->unsignedTinyInteger('request_count')->default(0)->after('status');

            // Kapan admin di-block (tidak bisa submit request baru sampai superadmin approve request terakhir)
            // null = tidak sedang di-block
            $table->timestamp('blocked_until')->nullable()->after('request_count');
        });
    }

    public function down(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            $table->dropColumn(['request_count', 'blocked_until']);
        });
    }
};
