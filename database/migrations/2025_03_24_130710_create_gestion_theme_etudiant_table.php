<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('gestion_theme_etudiant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('GestionThemeID');
            $table->unsignedBigInteger('EtudiantID');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('GestionThemeID')->references('GestionThemeID')->on('gestiondesthemes')->onDelete('cascade');
            $table->foreign('EtudiantID')->references('EtudiantID')->on('etudiants')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gestion_theme_etudiant');
    }
};
