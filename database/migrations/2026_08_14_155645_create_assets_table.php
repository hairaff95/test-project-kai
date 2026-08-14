<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique();
            $table->string('name');
            $table->string('district_area');
            $table->text('full_address');
            $table->longText('description')->nullable();
            $table->decimal('land_area', 10, 2)->default(0);
            $table->decimal('building_area', 10, 2)->default(0);
            $table->decimal('price', 15, 2)->default(0);
            $table->string('road_access')->nullable();
            $table->string('electricity')->nullable();
            $table->string('water_supply')->nullable();
            $table->string('security')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
