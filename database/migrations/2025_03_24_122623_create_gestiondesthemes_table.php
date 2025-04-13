<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('gestiondesthemes', function (Blueprint $table) {
            $table->id('GestionThemeID'); // Clé primaire
            $table->unsignedBigInteger('SpecialiteID');
            $table->unsignedBigInteger('GroupID');
            $table->unsignedBigInteger('ThemeID');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('SpecialiteID')->references('SpecialiteID')->on('specialites')->onDelete('cascade');
            $table->foreign('GroupID')->references('GroupID')->on('groups')->onDelete('cascade');
            $table->foreign('ThemeID')->references('ThemeID')->on('themes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gestiondesthemes');
    }
};
