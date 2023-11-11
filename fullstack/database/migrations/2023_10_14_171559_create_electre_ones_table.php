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
        Schema::create('electre_ones', function (Blueprint $table) {
            $table->id();
            $table->double('lambda');
//            $table->string('concordance')->nullable();
//            $table->string('discordance')->nullable();
//            $table->string('combined')->nullable();
//            $table->string('relations')->nullable();
//            $table->string('clean_graph')->nullable();
            $table->foreignId('project_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electre_ones');
    }
};
