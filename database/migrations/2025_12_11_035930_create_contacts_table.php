<?php
// database/migrations/2025_12_11_create_contacts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'whatsapp' atau 'instagram'
            $table->string('label'); // Label untuk ditampilkan
            $table->string('value'); // Nomor WA atau username IG
            $table->string('link'); // Full link URL
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};