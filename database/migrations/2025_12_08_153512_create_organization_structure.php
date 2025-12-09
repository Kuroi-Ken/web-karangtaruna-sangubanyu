<?php
// database/migrations/2025_12_08_create_structure_positions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('structure_positions', function (Blueprint $table) {
            $table->id();
            $table->string('position'); // Jabatan (Ketua, Wakil, dll)
            $table->string('name'); // Nama orang
            $table->string('phone')->nullable();
            $table->string('photo')->nullable(); // Path foto
            $table->integer('order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('structure_positions');
    }
};