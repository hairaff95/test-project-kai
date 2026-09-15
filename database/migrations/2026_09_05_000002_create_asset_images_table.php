<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_images', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id', 100); // asset_number
            $table->text('image_path');
            $table->string('caption', 255)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_images');
    }
};
