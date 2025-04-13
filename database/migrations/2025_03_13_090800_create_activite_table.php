<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_activite_table.php
public function up()
{
    Schema::create('activite', function (Blueprint $table) {
        $table->id('ActiviteID');
        $table->enum('Type', ['Cours', 'TP', 'TD'])->nullable(false);
        $table->unsignedBigInteger('ModuleID')->nullable(false);
        $table->unsignedBigInteger('ProfesseurID')->nullable(false);
        $table->foreign('ModuleID')->references('ModuleID')->on('module');
        $table->foreign('ProfesseurID')->references('ProfesseurID')->on('professeur');
        $table->unique(['ModuleID', 'ProfesseurID', 'Type']); // Unique constraint
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activite');
    }
};
