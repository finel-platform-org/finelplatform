<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_emploi_du_temps_table.php
public function up()
{
    Schema::create('emploi_du_temps', function (Blueprint $table) {
        $table->id('EmploiDuTempsID');
        $table->string('Jour');
        $table->integer('TimeSlot');
        $table->unsignedBigInteger('SectionID')->nullable();
        $table->unsignedBigInteger('ParcoursID')->nullable();
        $table->unsignedBigInteger('NiveauID')->nullable();
        $table->unsignedBigInteger('SpecialiteID')->nullable();
        $table->unsignedBigInteger('ActiviteID')->nullable();
        $table->unsignedBigInteger('ProfesseurID')->nullable();
        $table->unsignedBigInteger('GroupID')->nullable();
        $table->unsignedBigInteger('ModuleID')->nullable();
        $table->unsignedBigInteger('LocalID')->nullable();
        
        $table->foreign('ProfesseurID')->references('ProfesseurID')->on('professeurs');
        $table->foreign('GroupID')->references('GroupID')->on('groups');
        $table->foreign('ModuleID')->references('ModuleID')->on('modules');
        $table->foreign('LocalID')->references('LocalID')->on('locals');
        $table->foreign('SectionID')->references('SectionID')->on('sections');
        $table->foreign('ParcoursID')->references('ParcoursID')->on('parcours');
        $table->foreign('NiveauID')->references('NiveauID')->on('niveaux');
        $table->foreign('SpecialiteID')->references('SpecialiteID')->on('specialites');
        $table->foreign('ActiviteID')->references('ActiviteID')->on('activites');




        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emploi_du_temps');
    }
};
