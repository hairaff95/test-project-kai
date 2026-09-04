<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            $table->string('temp_password')->nullable()->after('otp_code');          // plain text (akan di-hash di model)
            $table->timestamp('temp_password_sent_at')->nullable()->after('temp_password');
            $table->timestamp('temp_password_expires_at')->nullable()->after('temp_password_sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            $table->dropColumn(['temp_password', 'temp_password_sent_at', 'temp_password_expires_at']);
        });
    }
};
