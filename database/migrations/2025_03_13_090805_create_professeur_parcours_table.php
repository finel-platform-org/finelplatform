<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_create_professeur_parcours_table.php
public function up()
{
    Schema::create('professeur_parcours', function (Blueprint $table) {
        $table->unsignedBigInteger('ProfesseurID');
        $table->unsignedBigInteger('ParcoursID');
        $table->foreign('ProfesseurID')->references('ProfesseurID')->on('professeur');
        $table->foreign('ParcoursID')->references('ParcoursID')->on('parcours');
        $table->primary(['ProfesseurID', 'ParcoursID']); // Composite primary key
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professeur_parcours');
    }
};
