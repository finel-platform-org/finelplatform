<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('emploisoutenance', function (Blueprint $table) {
            $table->id('EmploiSoutenanceID'); // Clé primaire
            $table->unsignedBigInteger('ProfesseurID');
            $table->unsignedBigInteger('ThemeID');
            $table->unsignedBigInteger('EtudiantID');
            $table->unsignedBigInteger('SpecialiteID');
            $table->unsignedBigInteger('GroupID');
            $table->time('HeureDebut');
            $table->time('HeureFin');
            $table->unsignedBigInteger('LocalID');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('ProfesseurID')->references('ProfesseurID')->on('professeurs')->onDelete('cascade');
            $table->foreign('ThemeID')->references('ThemeID')->on('themes')->onDelete('cascade');
            $table->foreign('EtudiantID')->references('EtudiantID')->on('etudiants')->onDelete('cascade');
            $table->foreign('SpecialiteID')->references('SpecialiteID')->on('specialites')->onDelete('cascade');
            $table->foreign('GroupID')->references('GroupID')->on('groups')->onDelete('cascade');
            $table->foreign('LocalID')->references('LocalID')->on('locals')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emploisoutenance');
    }
};

