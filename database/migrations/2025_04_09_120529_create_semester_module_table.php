<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('semester_module', function (Blueprint $table) {
            $table->id();  // ID pour la table pivot
            $table->unsignedBigInteger('SemestreID'); // Clé étrangère vers la table semesters
            $table->unsignedBigInteger('ModuleID');   // Clé étrangère vers la table modules
            $table->timestamps();

            // Définir les clés étrangères
            $table->foreign('SemestreID')->references('SemestreID')->on('semesters')->onDelete('cascade');
            $table->foreign('ModuleID')->references('ModuleID')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('semester_module');
    }
};
