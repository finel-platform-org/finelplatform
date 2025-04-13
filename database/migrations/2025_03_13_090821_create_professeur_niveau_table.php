<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_professeur_niveau_table.php
public function up()
{
    Schema::create('professeur_niveau', function (Blueprint $table) {
        $table->unsignedBigInteger('ProfesseurID');
        $table->unsignedBigInteger('NiveauID');
        $table->foreign('ProfesseurID')->references('ProfesseurID')->on('professeur');
        $table->foreign('NiveauID')->references('NiveauID')->on('niveau');
        $table->primary(['ProfesseurID', 'NiveauID']); // Composite primary key
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professeur_niveau');
    }
};
