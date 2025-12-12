<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('report_type', ['monthly', 'quarterly', 'yearly']);
            $table->year('year');
            $table->integer('month')->nullable();
            $table->integer('quarter')->nullable();
            $table->decimal('income', 15, 2)->default(0);
            $table->decimal('expense', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['year', 'month', 'quarter']);
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};