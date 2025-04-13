<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id('ThemeID'); // Clé primaire
            $table->string('Nom'); // Nom du thème
            $table->unsignedBigInteger('ProfesseurID'); // Professeur qui a proposé le thème
            

            // Clé étrangère vers la table professeurs
            $table->foreign('ProfesseurID')->references('ProfesseurID')->on('professeurs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('themes');
    }
};
