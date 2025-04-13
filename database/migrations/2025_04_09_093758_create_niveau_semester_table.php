<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('niveau_semester', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('NiveauID');
            $table->unsignedBigInteger('SemestreID');
            $table->timestamps();

            // Définir les clés étrangères
            $table->foreign('NiveauID')->references('NiveauID')->on('niveaux')->onDelete('cascade');
            $table->foreign('SemestreID')->references('SemestreID')->on('semesters')->onDelete('cascade');

            // Assurer que la combinaison NiveauID + SemestreID soit unique
            $table->unique(['NiveauID', 'SemestreID']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('niveau_semester');
    }
};
