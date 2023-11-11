<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('electre_criteria_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('electre_one_id')->constrained()->cascadeOnDelete();
            $table->foreignId('criterion_id')->constrained()->cascadeOnDelete();
            $table->double('weight')->nullable();
            $table->double('q')->nullable();
            $table->double('p')->nullable();
            $table->double('v')->nullable();
            $table->timestamps(); // see last change by teacher
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electre_criteria_settings');
    }
};
